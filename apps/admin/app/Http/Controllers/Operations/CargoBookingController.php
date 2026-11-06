<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SoraCargo\Core\Models\CargoBooking;
use SoraCargo\Core\Models\User;
use SoraCargo\Core\Models\Company;
use SoraCargo\Core\Models\Route;
use SoraCargo\Core\Models\Port;
use SoraCargo\Core\Models\HsCode;
use SoraCargo\Core\Models\OperatorProfile;
use SoraCargo\Core\Models\EscrowLedger;
use SoraCargo\Core\Models\TrackingEvent;
use SoraCargo\Core\Models\AuditTrail;

class CargoBookingController extends Controller
{
    /**
     * Menampilkan daftar pesanan kargo & status booking operasional.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $status = $request->query('status');
        $channel = $request->query('channel');
        $search = $request->query('search');

        $query = CargoBooking::with([
            'shipper',
            'company',
            'route.originPort',
            'route.destinationPort',
            'hsCode',
            'assignedOperator.user',
            'escrowLedger',
        ])->latest('created_at');

        // Filter Tipe Booking (Retail LCL, Corporate FCL, Charter Truk)
        if (!empty($type) && $type !== 'all') {
            $query->where('booking_type', $type);
        }

        // Filter Status Kargo
        if (!empty($status) && $status !== 'all') {
            $query->where('cargo_status', $status);
        }

        // Filter Jalur Kepabeanan
        if (!empty($channel) && $channel !== 'all') {
            $query->where('customs_channel', $channel);
        }

        // Filter Pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'ILIKE', "%{$search}%")
                  ->orWhereHas('shipper', function ($sq) use ($search) {
                      $sq->where('name', 'ILIKE', "%{$search}%")
                         ->orWhere('email', 'ILIKE', "%{$search}%");
                  })
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('company_name', 'ILIKE', "%{$search}%");
                  });
            });
        }

        $bookings = $query->paginate(10)->withQueryString();

        // Statistik Radar Kargo (KPI Cards)
        $totalBookingsCount = CargoBooking::count();
        $totalWeightKg = CargoBooking::sum('total_weight_kg') ?? 0;
        $totalVolumeCbm = CargoBooking::sum('total_volume_cbm') ?? 0;
        $totalEscrowProtected = EscrowLedger::sum('total_paid_amount') ?? 0;

        // Tab Counts
        $retailCount = CargoBooking::where('booking_type', 'RETAIL_LCL')->count();
        $corporateCount = CargoBooking::where('booking_type', 'CORPORATE_FCL')->count();
        $charterCount = CargoBooking::where('booking_type', 'CHARTER_TRUCK')->count();

        // Master Data untuk Modal Tambah Booking
        $routes = Route::with(['originPort', 'destinationPort'])->get();
        $shippers = User::whereIn('user_type', ['RETAIL_CUSTOMER', 'CORPORATE_USER'])->get();
        $hsCodes = HsCode::all();
        $operators = OperatorProfile::with(['user', 'hub'])->get();

        return view('operations.bookings', compact(
            'bookings',
            'totalBookingsCount',
            'totalWeightKg',
            'totalVolumeCbm',
            'totalEscrowProtected',
            'retailCount',
            'corporateCount',
            'charterCount',
            'routes',
            'shippers',
            'hsCodes',
            'operators',
            'type',
            'status',
            'channel',
            'search'
        ));
    }

    /**
     * Membuat booking kargo baru secara manual dari portal Admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipper_id' => ['required', Rule::exists(User::class, 'id')],
            'route_id' => ['required', Rule::exists(Route::class, 'id')],
            'booking_type' => 'required|in:RETAIL_LCL,CORPORATE_FCL,CHARTER_TRUCK',
            'cargo_type' => 'required|in:GENERAL_CARGO,DANGEROUS_GOODS,REEFER_PERISHABLE',
            'total_weight_kg' => 'required|numeric|min:1',
            'total_volume_cbm' => 'required|numeric|min:0.1',
            'declared_goods_value' => 'required|numeric|min:0',
            'hs_code' => ['nullable', Rule::exists(HsCode::class, 'code')],
            'assigned_operator_id' => ['nullable', Rule::exists(OperatorProfile::class, 'id')],
        ]);

        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';
        $trackingNumber = 'RPN-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Tentukan jalur kepabeanan berdasarkan komoditas
        $customsChannel = 'GREEN_CHANNEL';
        if ($validated['cargo_type'] === 'DANGEROUS_GOODS') {
            $customsChannel = 'RED_CHANNEL';
        } elseif ($validated['total_weight_kg'] > 5000) {
            $customsChannel = 'YELLOW_CHANNEL';
        }

        // Cek apakah shipper memiliki profil korporat
        $company = Company::where('user_id', $validated['shipper_id'])->first();

        DB::transaction(function () use ($validated, $trackingNumber, $customsChannel, $company, $adminId, $request) {
            $booking = CargoBooking::create([
                'tracking_number' => $trackingNumber,
                'shipper_id' => $validated['shipper_id'],
                'company_id' => $company ? $company->id : null,
                'route_id' => $validated['route_id'],
                'hs_code' => $validated['hs_code'] ?? '0901.11.10',
                'booking_type' => $validated['booking_type'],
                'cargo_type' => $validated['cargo_type'],
                'total_weight_kg' => $validated['total_weight_kg'],
                'total_volume_cbm' => $validated['total_volume_cbm'],
                'declared_goods_value' => $validated['declared_goods_value'],
                'currency' => 'IDR',
                'cargo_status' => 'BOOKED',
                'customs_channel' => $customsChannel,
                'assigned_operator_id' => $validated['assigned_operator_id'] ?? null,
            ]);

            // Hitung estimasi ongkos kirim dan inisialisasi akun penampung Escrow
            $route = Route::find($validated['route_id']);
            $rate = max($validated['total_weight_kg'] * $route->base_rate_per_kg, $validated['total_volume_cbm'] * $route->base_rate_per_cbm);
            $escrowAmount = max($rate, 500000);

            EscrowLedger::create([
                'cargo_booking_id' => $booking->id,
                'total_paid_amount' => $escrowAmount,
                'milestone_1_pickup_amount' => round($escrowAmount * 0.30, 2),
                'milestone_2_sailing_amount' => round($escrowAmount * 0.40, 2),
                'milestone_3_delivered_amount' => round($escrowAmount * 0.30, 2),
                'escrow_status' => 'HELD_IN_ESCROW',
            ]);

            // Jejak Audit
            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'CREATE_MANUAL_BOOKING',
                'target_schema' => 'ops',
                'target_table' => 'cargo_bookings',
                'record_id' => (string) $booking->id,
                'after_state_json' => [
                    'tracking_number' => $trackingNumber,
                    'booking_type' => $validated['booking_type'],
                    'weight' => $validated['total_weight_kg'],
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        return redirect()->route('admin.bookings.index')
            ->with('success', "Pesanan baru berhasil dibuat dengan Nomor Resi: {$trackingNumber} dan dialokasikan ke rekening bersama Escrow.");
    }

    /**
     * Memperbarui status kargo operasional (Gate In, Sailing, Delivered, dll).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'cargo_status' => 'required|in:DRAFT,BOOKED,GATE_IN,CUSTOMS_INSPECTION,SAILING,DELIVERED,WEATHER_HOLD,CLAIM_HOLD,CANCELLED',
        ]);

        $booking = CargoBooking::with('escrowLedger')->findOrFail($id);
        $oldStatus = $booking->cargo_status;
        $newStatus = $validated['cargo_status'];

        DB::transaction(function () use ($booking, $oldStatus, $newStatus, $request) {
            $booking->update(['cargo_status' => $newStatus]);

            // Milestone release logic otomatis pada Escrow
            if ($booking->escrowLedger) {
                if ($newStatus === 'GATE_IN' && is_null($booking->escrowLedger->milestone_1_released_at)) {
                    $booking->escrowLedger->update([
                        'milestone_1_released_at' => now(),
                        'escrow_status' => 'PARTIALLY_RELEASED',
                    ]);
                } elseif ($newStatus === 'SAILING' && is_null($booking->escrowLedger->milestone_2_released_at)) {
                    $booking->escrowLedger->update([
                        'milestone_2_released_at' => now(),
                        'escrow_status' => 'PARTIALLY_RELEASED',
                    ]);
                } elseif ($newStatus === 'DELIVERED') {
                    $booking->escrowLedger->update([
                        'milestone_3_released_at' => now(),
                        'escrow_status' => 'FULLY_SETTLED',
                    ]);
                } elseif ($newStatus === 'CLAIM_HOLD') {
                    $booking->escrowLedger->update([
                        'escrow_status' => 'DISPUTE_FROZEN',
                    ]);
                }
            }

            $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

            // Catat milestone otomatis di tabel ops.tracking_events
            TrackingEvent::create([
                'cargo_booking_id' => $booking->id,
                'event_name' => "Pembaruan status operasional: {$newStatus}",
                'current_status' => $newStatus,
                'latitude' => $booking->route?->originPort?->latitude ?? -6.1033,
                'longitude' => $booking->route?->originPort?->longitude ?? 106.8828,
                'operator_id' => null,
                'event_timestamp' => now(),
                'created_at' => now(),
            ]);

            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'UPDATE_CARGO_STATUS',
                'target_schema' => 'ops',
                'target_table' => 'cargo_bookings',
                'record_id' => (string) $booking->id,
                'before_state_json' => ['status' => $oldStatus],
                'after_state_json' => ['status' => $newStatus],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Status kargo resi {$booking->tracking_number} berhasil diubah dari {$oldStatus} menjadi {$newStatus}.");
    }

    /**
     * Mengambil riwayat milestone pelacakan (ops.tracking_events) dalam format JSON.
     */
    public function getTracking($id)
    {
        $booking = CargoBooking::with([
            'shipper',
            'company',
            'route.originPort',
            'route.destinationPort',
            'trackingEvents.operator.user'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'booking' => [
                'id' => $booking->id,
                'tracking_number' => $booking->tracking_number,
                'booking_type' => $booking->booking_type,
                'cargo_status' => $booking->cargo_status,
                'shipper_name' => $booking->company?->company_name ?? $booking->shipper?->name ?? 'Shipper',
                'origin' => $booking->route?->originPort?->name ?? 'Asal',
                'destination' => $booking->route?->destinationPort?->name ?? 'Tujuan',
                'weight' => $booking->total_weight_kg,
                'volume' => $booking->total_volume_cbm,
            ],
            'events' => $booking->trackingEvents->map(function ($ev) {
                return [
                    'id' => $ev->id,
                    'event_name' => $ev->event_name,
                    'current_status' => $ev->current_status,
                    'latitude' => $ev->latitude ? (float) $ev->latitude : null,
                    'longitude' => $ev->longitude ? (float) $ev->longitude : null,
                    'operator_name' => $ev->operator?->user?->name ?? 'Admin Sistem',
                    'timestamp' => $ev->event_timestamp ? $ev->event_timestamp->format('d M Y, H:i') : '-',
                    'time_ago' => $ev->event_timestamp ? $ev->event_timestamp->diffForHumans() : '-',
                ];
            })
        ]);
    }

    /**
     * Menambahkan milestone tracking event checkpoint baru secara manual dari admin.
     */
    public function storeTracking(Request $request, $id)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'current_status' => 'required|in:BOOKED,GATE_IN,CUSTOMS_INSPECTION,SAILING,DELIVERED,WEATHER_HOLD,CLAIM_HOLD',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $booking = CargoBooking::with('route.originPort')->findOrFail($id);

        $event = TrackingEvent::create([
            'cargo_booking_id' => $booking->id,
            'event_name' => $validated['event_name'],
            'current_status' => $validated['current_status'],
            'latitude' => $validated['latitude'] ?? ($booking->route?->originPort?->latitude ?? -6.1033),
            'longitude' => $validated['longitude'] ?? ($booking->route?->originPort?->longitude ?? 106.8828),
            'operator_id' => null,
            'event_timestamp' => now(),
            'created_at' => now(),
        ]);

        // Opsional: sinkronkan status kargo utama jika ada perubahan status
        if ($booking->cargo_status !== $validated['current_status']) {
            $booking->update(['cargo_status' => $validated['current_status']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Milestone checkpoint berhasil dicatat di database.',
            'event' => [
                'id' => $event->id,
                'event_name' => $event->event_name,
                'current_status' => $event->current_status,
                'latitude' => $event->latitude ? (float) $event->latitude : null,
                'longitude' => $event->longitude ? (float) $event->longitude : null,
                'operator_name' => 'Admin Sistem',
                'timestamp' => now()->format('d M Y, H:i'),
                'time_ago' => 'Baru saja',
            ]
        ]);
    }
}

