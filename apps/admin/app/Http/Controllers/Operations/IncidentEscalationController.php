<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use SoraCargo\Core\Models\IncidentEscalation;
use SoraCargo\Core\Models\CargoBooking;
use SoraCargo\Core\Models\Route;
use SoraCargo\Core\Models\AuditTrail;

class IncidentEscalationController extends Controller
{
    /**
     * Menampilkan dashboard Pusat Darurat & Kendala (Incident Escalation).
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $status = $request->query('status');
        $search = $request->query('search');

        $query = IncidentEscalation::with([
            'cargoBooking.shipper',
            'cargoBooking.route.originPort',
            'cargoBooking.route.destinationPort',
            'reporter.user',
            'reporter.hub',
        ])->latest('created_at');

        // Filter Jenis Insiden
        if (!empty($type) && $type !== 'all') {
            $query->where('incident_type', $type);
        }

        // Filter Status Peninjauan
        if (!empty($status) && $status !== 'all') {
            $query->where('approval_status', $status);
        }

        // Pencarian (Nomor Tiket, Resi Pengiriman, atau Nama Operator/Shipper)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('incident_ticket_no', 'ILIKE', "%{$search}%")
                  ->orWhereHas('cargoBooking', function ($bQ) use ($search) {
                      $bQ->where('tracking_number', 'ILIKE', "%{$search}%")
                         ->orWhereHas('shipper', function ($sQ) use ($search) {
                             $sQ->where('name', 'ILIKE', "%{$search}%");
                         });
                  })
                  ->orWhereHas('reporter.user', function ($rQ) use ($search) {
                      $rQ->where('name', 'ILIKE', "%{$search}%");
                  });
            });
        }

        $escalations = $query->paginate(10)->withQueryString();

        // Statistik Radar Darurat (KPI Cards)
        $pendingCount = IncidentEscalation::where('approval_status', 'PENDING_REVIEW')->count();
        $pendingAmount = IncidentEscalation::where('approval_status', 'PENDING_REVIEW')->sum('requested_amount') ?? 0;
        $weatherHoldRoutesCount = Route::where('is_weather_hold', true)->count();
        $avgSlaMinutes = round(IncidentEscalation::avg('sla_response_minutes') ?? 0);

        // Tab Navigation Counts
        $totalCount = IncidentEscalation::count();
        $fieldCostCount = IncidentEscalation::where('incident_type', 'FIELD_COST')->count();
        $damageClaimCount = IncidentEscalation::where('incident_type', 'DAMAGE_CLAIM')->count();
        $weatherHoldCount = IncidentEscalation::where('incident_type', 'WEATHER_HOLD')->count();
        $slaBreachCount = IncidentEscalation::where('incident_type', 'SLA_BREACH')->count();

        // Master Rute untuk Modal Darurat Cuaca BMKG
        $allRoutes = Route::with(['originPort', 'destinationPort'])->get();
        $activeWeatherHoldRoutes = Route::with(['originPort', 'destinationPort'])->where('is_weather_hold', true)->get();

        return view('operations.escalations', compact(
            'escalations',
            'pendingCount',
            'pendingAmount',
            'weatherHoldRoutesCount',
            'avgSlaMinutes',
            'totalCount',
            'fieldCostCount',
            'damageClaimCount',
            'weatherHoldCount',
            'slaBreachCount',
            'allRoutes',
            'activeWeatherHoldRoutes',
            'type',
            'status',
            'search'
        ));
    }

    /**
     * Menyetujui pengajuan biaya/klaim darurat lapangan.
     */
    public function approve(Request $request, $id)
    {
        $escalation = IncidentEscalation::with('cargoBooking')->findOrFail($id);
        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

        $notes = $request->input('admin_notes', 'Disetujui oleh Superadmin.');
        $approvedAmount = $request->input('approved_amount', $escalation->requested_amount);

        DB::transaction(function () use ($escalation, $adminId, $notes, $approvedAmount, $request) {
            $escalation->update([
                'approval_status' => 'APPROVED_BY_ADMIN',
                'requested_amount' => $approvedAmount,
                'admin_notes' => $notes,
            ]);

            // Jika status kargo masih CLAIM_HOLD, lepaskan hold agar operasional dapat berlanjut
            if ($escalation->cargoBooking && $escalation->cargoBooking->cargo_status === 'CLAIM_HOLD') {
                $escalation->cargoBooking->update(['cargo_status' => 'GATE_IN']);
            }

            // Catat Jejak Audit Permanen
            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'APPROVE_INCIDENT_ESCALATION',
                'target_schema' => 'ops',
                'target_table' => 'incident_escalations',
                'record_id' => (string) $escalation->id,
                'after_state_json' => [
                    'ticket' => $escalation->incident_ticket_no,
                    'approved_amount' => $approvedAmount,
                    'notes' => $notes,
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Insiden {$escalation->incident_ticket_no} BERHASIL DISETUJUI. Dana operasional darurat Rp " . number_format($approvedAmount, 0, ',', '.') . " siap dicairkan ke kasbon hub.");
    }

    /**
     * Menolak pengajuan insiden / biaya darurat.
     */
    public function reject(Request $request, $id)
    {
        $escalation = IncidentEscalation::findOrFail($id);
        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

        $notes = $request->input('admin_notes', 'Ditolak oleh Superadmin setelah verifikasi dokumen BAP.');

        $escalation->update([
            'approval_status' => 'REJECTED',
            'admin_notes' => $notes,
        ]);

        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'REJECT_INCIDENT_ESCALATION',
            'target_schema' => 'ops',
            'target_table' => 'incident_escalations',
            'record_id' => (string) $escalation->id,
            'after_state_json' => [
                'ticket' => $escalation->incident_ticket_no,
                'notes' => $notes,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        return back()->with('success', "Insiden {$escalation->incident_ticket_no} telah DITOLAK. Catatan penolakan tersimpan di log audit.");
    }

    /**
     * Mengalihkan insiden ke klaim Asuransi Maritim / Penjamin Ekspedisi.
     */
    public function escalateInsurance(Request $request, $id)
    {
        $escalation = IncidentEscalation::findOrFail($id);
        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

        $notes = $request->input('admin_notes', 'Dialihkan ke penjamin Asuransi Maritim.');

        $escalation->update([
            'approval_status' => 'INSURANCE_PROCESSED',
            'admin_notes' => $notes,
        ]);

        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'ESCALATE_TO_INSURANCE',
            'target_schema' => 'ops',
            'target_table' => 'incident_escalations',
            'record_id' => (string) $escalation->id,
            'after_state_json' => [
                'ticket' => $escalation->incident_ticket_no,
                'notes' => $notes,
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        return back()->with('success', "Insiden {$escalation->incident_ticket_no} berhasil dialihkan ke penanganan Klaim Asuransi Maritim.");
    }

    /**
     * Mengaktifkan / Menutup Tahan Pelayaran Cuaca Buruk (BMKG Weather Hold).
     */
    public function toggleWeatherHold(Request $request)
    {
        $request->validate([
            'route_id' => ['required', Rule::exists(Route::class, 'id')],
        ]);

        $route = Route::with(['originPort', 'destinationPort'])->findOrFail($request->route_id);
        $newStatus = !$route->is_weather_hold;
        $route->update(['is_weather_hold' => $newStatus]);

        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';
        $routeName = "{$route->originPort->name} ({$route->origin_port_id}) &rarr; {$route->destinationPort->name} ({$route->destination_port_id})";

        // Jika rute ditahan, update status muatan aktif di rute tersebut ke WEATHER_HOLD
        if ($newStatus) {
            CargoBooking::where('route_id', $route->id)
                ->whereIn('cargo_status', ['BOOKED', 'GATE_IN', 'SAILING'])
                ->update(['cargo_status' => 'WEATHER_HOLD']);
        }

        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => $newStatus ? 'TRIGGER_WEATHER_HOLD' : 'RELEASE_WEATHER_HOLD',
            'target_schema' => 'public',
            'target_table' => 'routes',
            'record_id' => (string) $route->id,
            'after_state_json' => [
                'route_id' => $route->id,
                'is_weather_hold' => $newStatus,
                'reason' => $request->input('reason', 'Peringatan Gelombang Tinggi BMKG Maritim'),
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        $message = $newStatus
            ? "PERINGATAN DARURAT: Rute {$route->origin_port_id} ke {$route->destination_port_id} RESMI DITAHAN (WEATHER HOLD) sesuai maklumat cuaca maritim BMKG. Seluruh jadwal keberangkatan dibekukan."
            : "Rute {$route->origin_port_id} ke {$route->destination_port_id} telah DIBUKA KEMBALI (RELEASE HOLD). Keberangkatan armada dapat dilanjutkan.";

        return back()->with('success', $message);
    }
}
