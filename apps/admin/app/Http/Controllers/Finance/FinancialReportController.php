<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SoraCargo\Core\Models\Route;
use SoraCargo\Core\Models\CargoBooking;
use SoraCargo\Core\Models\EscrowLedger;
use SoraCargo\Core\Models\RevenueSplit;
use SoraCargo\Core\Models\Invoice;

class FinancialReportController extends Controller
{
    /**
     * Tampilkan Dasbor Terpadu 3 Pilar Keuangan & Fiskal.
     */
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());
        $activePillar = $request->query('pillar', 'route_pnl');

        // 1. PILAR 1: Laporan Laba Rugi per Rute (Route P&L)
        $routes = Route::with(['originPort', 'destinationPort'])->get();
        $routePnl = [];
        $totalGmv = 0;
        $totalOperatorPayout = 0;
        $totalPortDues = 0;
        $totalNetProfit = 0;

        foreach ($routes as $r) {
            $bookingIds = CargoBooking::where('route_id', $r->id)->pluck('id');
            $splits = RevenueSplit::whereIn('cargo_booking_id', $bookingIds)->get();
            $escrows = EscrowLedger::whereIn('cargo_booking_id', $bookingIds)->get();

            $gmv = $escrows->sum('total_paid_amount');
            $opShare = $splits->sum('operator_share_amount');
            $dues = $splits->sum('tax_and_port_dues');
            $profit = $splits->sum('net_platform_profit');
            $marginPct = ($gmv > 0) ? round(($profit / $gmv) * 100, 1) : 0;

            $totalGmv += $gmv;
            $totalOperatorPayout += $opShare;
            $totalPortDues += $dues;
            $totalNetProfit += $profit;

            $routePnl[] = (object) [
                'route_id' => $r->id,
                'origin' => $r->originPort?->name ?? 'Port ' . $r->origin_port_code,
                'origin_code' => $r->origin_port_code,
                'destination' => $r->destinationPort?->name ?? 'Port ' . $r->destination_port_code,
                'destination_code' => $r->destination_port_code,
                'transport_mode' => $r->transport_mode,
                'total_bookings' => $bookingIds->count(),
                'gmv' => $gmv,
                'operator_share' => $opShare,
                'port_dues' => $dues,
                'net_profit' => $profit,
                'margin_pct' => $marginPct,
            ];
        }

        // 2. PILAR 2: Rekapitulasi Pajak Freight Forwarding (PPN 11% & PPh 23 2%)
        // Berdasarkan PMK 71/PMK.03/2022 & UU HPP: PPN Besaran Tertentu JPT / PPN 11% atas margin jasa, PPh 23 2% atas imbalan jasa armada
        $taxBaseDpp = $totalNetProfit; // DPP Jasa Kargo SoraCargo
        $ppn11Pct = $taxBaseDpp * 0.11; // PPN 11% atas jasa platform
        $pph23Withholding = $totalOperatorPayout * 0.02; // PPh Pasal 23 (2%) dipotong dari sewa/imbalan operator
        $totalTaxObligation = $ppn11Pct + $pph23Withholding;

        // 3. PILAR 3: Arus Kas & Rekonsiliasi Escrow
        $escrowInflow = EscrowLedger::sum('total_paid_amount');
        $m1Sum = EscrowLedger::whereNotNull('milestone_1_released_at')->sum('milestone_1_pickup_amount');
        $m2Sum = EscrowLedger::whereNotNull('milestone_2_released_at')->sum('milestone_2_sailing_amount');
        $m3Sum = EscrowLedger::whereNotNull('milestone_3_released_at')->sum('milestone_3_delivered_amount');
        $escrowOutflow = $m1Sum + $m2Sum + $m3Sum;
        $escrowRefunded = EscrowLedger::where('escrow_status', 'REFUNDED_SETTLED')->sum('total_paid_amount');
        $escrowFloatingBalance = EscrowLedger::whereIn('escrow_status', ['HELD_IN_ESCROW', 'PARTIALLY_RELEASED', 'DISPUTE_FROZEN'])->sum('total_paid_amount') - ($escrowOutflow - $m3Sum);

        return view('finance.reports', compact(
            'startDate',
            'endDate',
            'activePillar',
            'routePnl',
            'totalGmv',
            'totalOperatorPayout',
            'totalPortDues',
            'totalNetProfit',
            'taxBaseDpp',
            'ppn11Pct',
            'pph23Withholding',
            'totalTaxObligation',
            'escrowInflow',
            'escrowOutflow',
            'escrowRefunded',
            'escrowFloatingBalance'
        ));
    }

    /**
     * Unduh / Ekspor Laporan Finansial dalam Format CSV / Excel.
     */
    public function export(Request $request)
    {
        $type = $request->query('type', 'route_pnl');
        $filename = "SoraCargo_Report_{$type}_" . date('Ymd_His') . ".csv";

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'EXPORT_FINANCIAL_REPORT',
            'target_schema' => 'admin',
            'target_table' => 'revenue_splits',
            'record_id' => $type,
            'before_state_json' => null,
            'after_state_json' => json_encode(['export_type' => $type, 'filename' => $filename]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($type) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            if ($type === 'tax_summary') {
                fputcsv($handle, ['KOMPONEN FISKAL & PAJAK FREIGHT FORWARDING', 'DASAR PENGENAAN PAJAK (DPP)', 'TARIF PAJAK', 'JUMLAH PAJAK (IDR)', 'KETENTUAN REGULASI']);
                $totalProfit = RevenueSplit::sum('net_platform_profit');
                $totalOperator = RevenueSplit::sum('operator_share_amount');
                fputcsv($handle, ['PPN Jasa Ekspedisi (Keluaran)', number_format($totalProfit, 2, '.', ''), '11%', number_format($totalProfit * 0.11, 2, '.', ''), 'UU HPP & PMK 71/2022']);
                fputcsv($handle, ['PPh Pasal 23 Sewa Armada & JPT (Withholding)', number_format($totalOperator, 2, '.', ''), '2%', number_format($totalOperator * 0.02, 2, '.', ''), 'Pasal 23 UU PPh']);
                fputcsv($handle, ['Retribusi Pelabuhan & PNBP Kepelabuhanan', '-', '-', number_format(RevenueSplit::sum('tax_and_port_dues'), 2, '.', ''), 'Peraturan Pelindo / Syahbandar']);
            } elseif ($type === 'escrow_flow') {
                fputcsv($handle, ['RESI / BOOKING', 'TANGGAL', 'TOTAL PAID ESCROW (IDR)', 'M1 RELEASED (30%)', 'M2 RELEASED (40%)', 'M3 RELEASED (30%)', 'STATUS ESCROW']);
                $escrows = EscrowLedger::with('cargoBooking')->get();
                foreach ($escrows as $e) {
                    fputcsv($handle, [
                        $e->cargoBooking?->tracking_number ?? 'N/A',
                        $e->created_at->format('Y-m-d H:i'),
                        $e->total_paid_amount,
                        $e->milestone_1_released_at ? $e->milestone_1_pickup_amount : 0,
                        $e->milestone_2_released_at ? $e->milestone_2_sailing_amount : 0,
                        $e->milestone_3_released_at ? $e->milestone_3_delivered_amount : 0,
                        $e->escrow_status,
                    ]);
                }
            } else {
                // route_pnl
                fputcsv($handle, ['KORIDOR RUTE', 'MODA TRANSPORTASI', 'JUMLAH BOOKING', 'GROSS MERCHANDISE VALUE (IDR)', 'HAK OPERATOR ARMADA (IDR)', 'RETRIBUSI PELABUHAN (IDR)', 'NET PROFIT SORACARGO (IDR)', 'MARGIN PROFIT (%)']);
                $routes = Route::with(['originPort', 'destinationPort'])->get();
                foreach ($routes as $r) {
                    $bIds = CargoBooking::where('route_id', $r->id)->pluck('id');
                    $splits = RevenueSplit::whereIn('cargo_booking_id', $bIds)->get();
                    $gmv = EscrowLedger::whereIn('cargo_booking_id', $bIds)->sum('total_paid_amount');
                    $profit = $splits->sum('net_platform_profit');
                    $margin = ($gmv > 0) ? round(($profit / $gmv) * 100, 1) : 0;

                    fputcsv($handle, [
                        "{$r->origin_port_code} -> {$r->destination_port_code}",
                        $r->transport_mode,
                        $bIds->count(),
                        number_format($gmv, 2, '.', ''),
                        number_format($splits->sum('operator_share_amount'), 2, '.', ''),
                        number_format($splits->sum('tax_and_port_dues'), 2, '.', ''),
                        number_format($profit, 2, '.', ''),
                        $margin . '%'
                    ]);
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}

