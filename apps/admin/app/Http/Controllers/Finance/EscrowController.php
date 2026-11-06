<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SoraCargo\Core\Models\EscrowLedger;
use SoraCargo\Core\Models\RevenueSplit;
use SoraCargo\Core\Models\CargoBooking;

class EscrowController extends Controller
{
    /**
     * Tampilkan data dan tata kelola Rekening Bersama (Escrow Ledgers).
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');

        $query = EscrowLedger::with([
            'cargoBooking.shipper',
            'cargoBooking.company',
            'cargoBooking.assignedOperator.user',
            'cargoBooking.route',
            'cargoBooking.revenueSplit'
        ]);

        // Filter tab status
        if ($filter === 'held') {
            $query->where('escrow_status', 'HELD_IN_ESCROW');
        } elseif ($filter === 'partial') {
            $query->where('escrow_status', 'PARTIALLY_RELEASED');
        } elseif ($filter === 'settled') {
            $query->whereIn('escrow_status', ['SETTLED', 'REFUNDED_SETTLED']);
        } elseif ($filter === 'frozen') {
            $query->where('escrow_status', 'DISPUTE_FROZEN');
        }

        // Filter pencarian
        if (!empty($search)) {
            $query->whereHas('cargoBooking', function ($q) use ($search) {
                $q->where('tracking_number', 'ilike', "%{$search}%")
                  ->orWhereHas('shipper', function ($sq) use ($search) {
                      $sq->where('name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('company_name', 'ilike', "%{$search}%");
                  });
            });
        }

        $escrows = $query->latest('created_at')->paginate(10)->withQueryString();

        // Agregasi KPI Keuangan Real-Time dari PostgreSQL
        $totalEscrowHeld = EscrowLedger::whereIn('escrow_status', ['HELD_IN_ESCROW', 'PARTIALLY_RELEASED'])
            ->sum('total_paid_amount');

        // Total rilis milestone ke operator
        $releasedM1 = EscrowLedger::whereNotNull('milestone_1_released_at')->sum('milestone_1_pickup_amount');
        $releasedM2 = EscrowLedger::whereNotNull('milestone_2_released_at')->sum('milestone_2_sailing_amount');
        $releasedM3 = EscrowLedger::whereNotNull('milestone_3_released_at')->sum('milestone_3_delivered_amount');
        $totalReleasedToOperators = $releasedM1 + $releasedM2 + $releasedM3;

        // Total Margin Keuntungan Bersih Platform SoraCargo
        $totalPlatformProfit = RevenueSplit::sum('net_platform_profit');

        // Total Dana Dibekukan akibat Sengketa
        $totalDisputeFrozen = EscrowLedger::where('escrow_status', 'DISPUTE_FROZEN')
            ->sum('total_paid_amount');
        $disputeCount = EscrowLedger::where('escrow_status', 'DISPUTE_FROZEN')->count();

        // Hitungan per filter tab
        $counts = [
            'all' => EscrowLedger::count(),
            'held' => EscrowLedger::where('escrow_status', 'HELD_IN_ESCROW')->count(),
            'partial' => EscrowLedger::where('escrow_status', 'PARTIALLY_RELEASED')->count(),
            'settled' => EscrowLedger::whereIn('escrow_status', ['SETTLED', 'REFUNDED_SETTLED'])->count(),
            'frozen' => EscrowLedger::where('escrow_status', 'DISPUTE_FROZEN')->count(),
        ];

        return view('finance.escrow', compact(
            'escrows',
            'totalEscrowHeld',
            'totalReleasedToOperators',
            'totalPlatformProfit',
            'totalDisputeFrozen',
            'disputeCount',
            'counts',
            'filter',
            'search'
        ));
    }

    /**
     * Otorisasi Rilis Manual / Force-Release Termin Tertentu oleh Superadmin.
     */
    public function forceRelease(Request $request, string $id)
    {
        $request->validate([
            'milestone' => 'required|in:1,2,3',
            'override_reason' => 'required|string|min:5|max:500',
        ]);

        $escrow = EscrowLedger::with('cargoBooking')->findOrFail($id);

        if ($escrow->escrow_status === 'DISPUTE_FROZEN') {
            return back()->withErrors(['milestone' => 'Dana sedang berstatus DIBEKUKAN (Dispute Frozen). Selesaikan sengketa terlebih dahulu sebelum merilis dana.']);
        }

        $milestone = (int) $request->milestone;
        $now = now();
        $beforeState = $escrow->toArray();

        if ($milestone === 1) {
            $escrow->milestone_1_released_at = $now;
        } elseif ($milestone === 2) {
            $escrow->milestone_2_released_at = $now;
        } elseif ($milestone === 3) {
            $escrow->milestone_3_delivered_amount = $escrow->milestone_3_delivered_amount ?? ($escrow->total_paid_amount * 0.30);
            $escrow->milestone_3_released_at = $now;
        }

        // Tentukan status akhir escrow
        if ($escrow->milestone_1_released_at && $escrow->milestone_2_released_at && $escrow->milestone_3_released_at) {
            $escrow->escrow_status = 'SETTLED';
        } else {
            $escrow->escrow_status = 'PARTIALLY_RELEASED';
        }

        $escrow->save();

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'FORCE_RELEASE_ESCROW_MILESTONE',
            'target_schema' => 'admin',
            'target_table' => 'escrow_ledgers',
            'record_id' => $escrow->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode([
                'released_milestone' => $milestone,
                'override_reason' => $request->override_reason,
                'new_status' => $escrow->escrow_status,
                'timestamp' => $now->toIso8601String(),
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', "Otorisasi manual Berhasil: Termin Milestone {$milestone} untuk booking {$escrow->cargoBooking->tracking_number} telah dicairkan.");
    }

    /**
     * Membekukan (Freeze) atau Membuka Gembok (Unfreeze) Rekening Bersama.
     */
    public function toggleFreeze(Request $request, string $id)
    {
        $request->validate([
            'action' => 'required|in:FREEZE,UNFREEZE',
            'reason' => 'required|string|min:5|max:500',
        ]);

        $escrow = EscrowLedger::with('cargoBooking')->findOrFail($id);
        $beforeState = $escrow->toArray();
        $now = now();

        if ($request->action === 'FREEZE') {
            $escrow->escrow_status = 'DISPUTE_FROZEN';
            $message = "Rekening Escrow booking {$escrow->cargoBooking->tracking_number} RESMI DIBEKUKAN (Dispute Frozen). Penarikan dana ditahan sementara.";
        } else {
            // Restore status sesuai histori rilis milestone
            if ($escrow->milestone_1_released_at && $escrow->milestone_2_released_at && $escrow->milestone_3_released_at) {
                $escrow->escrow_status = 'SETTLED';
            } elseif ($escrow->milestone_1_released_at || $escrow->milestone_2_released_at) {
                $escrow->escrow_status = 'PARTIALLY_RELEASED';
            } else {
                $escrow->escrow_status = 'HELD_IN_ESCROW';
            }
            $message = "Gembok sengketa escrow dibuka kembali. Status diperbarui menjadi {$escrow->escrow_status}.";
        }

        $escrow->save();

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'TOGGLE_ESCROW_FREEZE',
            'target_schema' => 'admin',
            'target_table' => 'escrow_ledgers',
            'record_id' => $escrow->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode([
                'action' => $request->action,
                'reason' => $request->reason,
                'resulting_status' => $escrow->escrow_status,
                'timestamp' => $now->toIso8601String(),
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', $message);
    }

    /**
     * Resolusi Sengketa Terpadu (Refund Shipper / Payout Operator / Asuransi Kargo).
     */
    public function resolveDispute(Request $request, string $id)
    {
        $request->validate([
            'resolution_type' => 'required|in:REFUND_TO_SHIPPER,PAYOUT_TO_OPERATOR,ESCALATE_INSURANCE',
            'resolution_notes' => 'required|string|min:5|max:1000',
            'adjustment_amount' => 'nullable|numeric|min:0',
        ]);

        $escrow = EscrowLedger::with('cargoBooking')->findOrFail($id);
        $beforeState = $escrow->toArray();
        $now = now();

        if ($request->resolution_type === 'REFUND_TO_SHIPPER') {
            $escrow->escrow_status = 'REFUNDED_SETTLED';
            $successMsg = "Resolusi Selesai: Dana ganti rugi/refund sebesar Rp " . number_format($request->adjustment_amount ?? $escrow->total_paid_amount, 0, ',', '.') . " telah dikembalikan ke saldo dompet Pengirim kargo.";
        } elseif ($request->resolution_type === 'PAYOUT_TO_OPERATOR') {
            $escrow->milestone_1_released_at = $escrow->milestone_1_released_at ?? $now;
            $escrow->milestone_2_released_at = $escrow->milestone_2_released_at ?? $now;
            $escrow->milestone_3_released_at = $escrow->milestone_3_released_at ?? $now;
            $escrow->escrow_status = 'SETTLED';
            $successMsg = "Resolusi Selesai: Sengketa dinyatakan rampung. Seluruh sisa termin dicairkan ke operator pelayaran/ekspedisi.";
        } else {
            // ESCALATE_INSURANCE
            $escrow->escrow_status = 'DISPUTE_FROZEN';
            $successMsg = "Klaim berhasil diteruskan ke Divisi Asuransi Marine Cargo. Escrow tetap dikunci hingga hasil klaim polis terbit.";
        }

        $escrow->save();

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'RESOLVE_ESCROW_DISPUTE',
            'target_schema' => 'admin',
            'target_table' => 'escrow_ledgers',
            'record_id' => $escrow->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode([
                'resolution_type' => $request->resolution_type,
                'adjustment_amount' => $request->adjustment_amount,
                'resolution_notes' => $request->resolution_notes,
                'resulting_status' => $escrow->escrow_status,
                'timestamp' => $now->toIso8601String(),
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', $successMsg);
    }
}
