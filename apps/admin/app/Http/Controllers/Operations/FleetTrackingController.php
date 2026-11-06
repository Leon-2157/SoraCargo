<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SoraCargo\Core\Models\Manifest;
use SoraCargo\Core\Models\ManifestItem;
use SoraCargo\Core\Models\CargoBooking;
use SoraCargo\Core\Models\Port;
use SoraCargo\Core\Models\AuditTrail;

class FleetTrackingController extends Controller
{
    /**
     * Menampilkan radar pelacakan armada & manifes petikemas aktif.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $hubId = $request->query('hub');
        $search = $request->query('search');

        $query = Manifest::with([
            'originPort',
            'destinationPort',
            'items.cargoBooking.shipper',
            'items.cargoBooking.company',
        ])->latest('created_at');

        // Filter Status Manifes
        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        // Filter Regional Hub
        if (!empty($hubId) && $hubId !== 'all') {
            $query->where(function ($q) use ($hubId) {
                $q->where('origin_port_id', $hubId)
                  ->orWhere('destination_port_id', $hubId);
            });
        }

        // Filter Pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('manifest_number', 'ILIKE', "%{$search}%")
                  ->orWhere('vessel_or_vehicle_name', 'ILIKE', "%{$search}%")
                  ->orWhere('voyage_number', 'ILIKE', "%{$search}%")
                  ->orWhereHas('items', function ($iq) use ($search) {
                      $iq->where('container_serial_number', 'ILIKE', "%{$search}%")
                         ->orWhere('seal_number', 'ILIKE', "%{$search}%");
                  });
            });
        }

        $manifests = $query->paginate(10)->withQueryString();

        // Statistik Radar Armada (KPI Cards)
        $activeSailingCount = Manifest::where('status', 'SAILING')->count();
        $preparingCount = Manifest::whereIn('status', ['PREPARING', 'LOCKED_SEALED'])->count();
        $arrivedCount = Manifest::where('status', 'ARRIVED')->count();
        $totalContainersCount = ManifestItem::count();

        // Master Data untuk Modal Manifes Baru
        $ports = Port::orderBy('name')->get();
        $unmanifestedBookings = CargoBooking::whereIn('cargo_status', ['BOOKED', 'GATE_IN'])->get();

        return view('operations.fleets', compact(
            'manifests',
            'activeSailingCount',
            'preparingCount',
            'arrivedCount',
            'totalContainersCount',
            'ports',
            'unmanifestedBookings',
            'status',
            'hubId',
            'search'
        ));
    }

    /**
     * Menerbitkan manifes kapal / armada darat baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_port_id' => ['required', Rule::exists(Port::class, 'id')],
            'destination_port_id' => ['required', Rule::exists(Port::class, 'id'), 'different:origin_port_id'],
            'vessel_or_vehicle_name' => 'required|string|max:255',
            'voyage_number' => 'required|string|max:50',
            'departure_eta' => 'required|date',
            'arrival_eta' => 'required|date|after:departure_eta',
        ], [
            'destination_port_id.different' => 'Pelabuhan tujuan harus berbeda dengan pelabuhan asal.',
            'arrival_eta.after' => 'Estimasi waktu tiba harus lebih lambat dari waktu keberangkatan.',
        ]);

        $manifestNumber = 'MMK-' . $validated['origin_port_id'] . '-' . $validated['destination_port_id'] . '-' . date('Ymd') . '-' . strtoupper(Str::random(3));
        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

        $manifest = Manifest::create([
            'manifest_number' => $manifestNumber,
            'origin_port_id' => $validated['origin_port_id'],
            'destination_port_id' => $validated['destination_port_id'],
            'vessel_or_vehicle_name' => $validated['vessel_or_vehicle_name'],
            'voyage_number' => strtoupper(trim($validated['voyage_number'])),
            'departure_eta' => $validated['departure_eta'],
            'arrival_eta' => $validated['arrival_eta'],
            'status' => 'PREPARING',
        ]);

        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'CREATE_MANIFEST',
            'target_schema' => 'ops',
            'target_table' => 'manifests',
            'record_id' => (string) $manifest->id,
            'after_state_json' => [
                'manifest_number' => $manifestNumber,
                'vessel' => $validated['vessel_or_vehicle_name'],
                'voyage' => $validated['voyage_number'],
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        return redirect()->route('admin.fleets.index')
            ->with('success', "Manifes pelayaran baru {$manifestNumber} berhasil diterbitkan dengan status PREPARING.");
    }

    /**
     * Memperbarui status siklus manifes (Preparing -> Locked -> Sailing -> Arrived -> Unloaded).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:PREPARING,LOCKED_SEALED,SAILING,ARRIVED,UNLOADED',
        ]);

        $manifest = Manifest::with('items.cargoBooking')->findOrFail($id);
        $oldStatus = $manifest->status;
        $newStatus = $validated['status'];

        DB::transaction(function () use ($manifest, $oldStatus, $newStatus, $request) {
            $manifest->update(['status' => $newStatus]);

            // Sinkronisasi status booking kargo yang ada di dalam manifes ini
            if ($newStatus === 'SAILING') {
                foreach ($manifest->items as $item) {
                    if ($item->cargoBooking) {
                        $item->cargoBooking->update(['cargo_status' => 'SAILING']);
                    }
                }
            } elseif ($newStatus === 'ARRIVED') {
                foreach ($manifest->items as $item) {
                    if ($item->cargoBooking && $item->cargoBooking->cargo_status === 'SAILING') {
                        $item->cargoBooking->update(['cargo_status' => 'GATE_IN']);
                    }
                }
            }

            $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';
            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'UPDATE_MANIFEST_STATUS',
                'target_schema' => 'ops',
                'target_table' => 'manifests',
                'record_id' => (string) $manifest->id,
                'before_state_json' => ['status' => $oldStatus],
                'after_state_json' => ['status' => $newStatus],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Status manifes {$manifest->manifest_number} berhasil diubah menjadi {$newStatus}.");
    }

    /**
     * Menambahkan petikemas & resi kargo ke dalam manifes pelayaran.
     */
    public function attachContainer(Request $request, $id)
    {
        $validated = $request->validate([
            'cargo_booking_id' => ['required', Rule::exists(CargoBooking::class, 'id')],
            'container_serial_number' => 'required|string|max:20',
            'container_type' => 'required|in:DRY_20FT,DRY_40FT,REEFER_40HC',
            'seal_number' => 'required|string|max:50',
        ]);

        $manifest = Manifest::findOrFail($id);

        ManifestItem::create([
            'manifest_id' => $manifest->id,
            'cargo_booking_id' => $validated['cargo_booking_id'],
            'container_serial_number' => strtoupper(trim($validated['container_serial_number'])),
            'container_type' => $validated['container_type'],
            'seal_number' => strtoupper(trim($validated['seal_number'])),
        ]);

        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';
        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'ATTACH_CONTAINER_TO_MANIFEST',
            'target_schema' => 'ops',
            'target_table' => 'manifest_items',
            'record_id' => (string) $manifest->id,
            'after_state_json' => [
                'container' => $validated['container_serial_number'],
                'seal' => $validated['seal_number'],
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        return back()->with('success', "Petikemas {$validated['container_serial_number']} dengan nomor segel {$validated['seal_number']} berhasil ditambahkan ke manifes.");
    }

    /**
     * Mengambil rincian daftar petikemas & nomor segel resmi per manifes dalam format JSON.
     */
    public function getContainers($id)
    {
        $manifest = Manifest::with([
            'originPort',
            'destinationPort',
            'items.cargoBooking.shipper',
            'items.cargoBooking.company'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'manifest' => [
                'id' => $manifest->id,
                'manifest_number' => $manifest->manifest_number,
                'vessel' => $manifest->vessel_or_vehicle_name,
                'voyage' => $manifest->voyage_number,
                'status' => $manifest->status,
                'origin' => $manifest->originPort->name ?? $manifest->origin_port_id,
                'destination' => $manifest->destinationPort->name ?? $manifest->destination_port_id,
                'total_containers' => $manifest->items->count(),
            ],
            'items' => $manifest->items->map(function ($it) {
                return [
                    'id' => $it->id,
                    'container_serial_number' => $it->container_serial_number,
                    'container_type' => $it->container_type ?? 'DRY_20FT',
                    'seal_number' => $it->seal_number ?? 'BELUM_TERSEGEL',
                    'tracking_number' => $it->cargoBooking?->tracking_number ?? '-',
                    'shipper' => $it->cargoBooking?->company?->company_name ?? $it->cargoBooking?->shipper?->name ?? 'Shipper Umum',
                    'weight' => $it->cargoBooking ? (float) $it->cargoBooking->total_weight_kg : 0,
                    'volume' => $it->cargoBooking ? (float) $it->cargoBooking->total_volume_cbm : 0,
                    'cargo_status' => $it->cargoBooking?->cargo_status ?? '-',
                ];
            })
        ]);
    }
}

