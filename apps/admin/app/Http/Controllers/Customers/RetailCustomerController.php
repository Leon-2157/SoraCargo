<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SoraCargo\Core\Models\User;
use SoraCargo\Core\Models\CargoBooking;
use SoraCargo\Core\Models\EscrowLedger;
use SoraCargo\Core\Models\AuditTrail;

class RetailCustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan retail & status saldo prepaid escrow.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $amlStatus = $request->query('aml_status');
        $search = $request->query('search');

        $query = User::where('user_type', 'RETAIL_CUSTOMER')->latest('created_at');

        // Filter Status Akun
        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        // Filter Kepatuhan AML
        if (!empty($amlStatus) && $amlStatus !== 'all') {
            $query->where('kyc_aml_status', $amlStatus);
        }

        // Filter Pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('phone', 'ILIKE', "%{$search}%")
                  ->orWhere('nik', 'ILIKE', "%{$search}%")
                  ->orWhere('business_type', 'ILIKE', "%{$search}%");
            });
        }

        $retailUsers = $query->paginate(10)->withQueryString();

        // Agregasi Statistik Radar Retail
        $totalRetailCount = User::where('user_type', 'RETAIL_CUSTOMER')->count();
        $activeCount = User::where('user_type', 'RETAIL_CUSTOMER')->where('status', 'ACTIVE')->count();
        $lockedCount = User::where('user_type', 'RETAIL_CUSTOMER')->where('status', 'BOOKING_LOCKED')->count();
        $blacklistedCount = User::where('user_type', 'RETAIL_CUSTOMER')->where('status', 'BLACKLISTED')->count();
        $pendingAmlCount = User::where('user_type', 'RETAIL_CUSTOMER')->where('kyc_aml_status', 'HIGH_VALUE_PENDING')->count();

        // Total Escrow Prepaid yang sedang aktif berjalan
        $activePrepaidEscrow = EscrowLedger::whereHas('cargoBooking', function ($bq) {
            $bq->whereHas('shipper', function ($sq) {
                $sq->where('user_type', 'RETAIL_CUSTOMER');
            });
        })->sum('total_paid_amount') ?? 0;

        return view('customers.retail', compact(
            'retailUsers',
            'totalRetailCount',
            'activeCount',
            'lockedCount',
            'blacklistedCount',
            'pendingAmlCount',
            'activePrepaidEscrow',
            'status',
            'amlStatus',
            'search'
        ));
    }

    /**
     * Halaman Penuh Dedicated (Customer 360° Retail / UMKM).
     */
    public function show($id)
    {
        $user = User::where('user_type', 'RETAIL_CUSTOMER')
            ->with([
                'cargoBookings' => function ($bq) {
                    $bq->with(['route.originPort', 'route.destinationPort', 'escrowLedger'])
                       ->latest('created_at')
                       ->limit(20);
                }
            ])
            ->findOrFail($id);

        $totalOrdersCount = $user->cargoBookings()->count();
        $completedOrdersCount = $user->cargoBookings()->where('cargo_status', 'DELIVERED')->count();
        $totalGoodsValue = $user->cargoBookings()->sum('declared_goods_value') ?? 0;

        $activeEscrowHold = EscrowLedger::whereHas('cargoBooking', function ($bq) use ($user) {
            $bq->where('shipper_id', $user->id)->whereIn('cargo_status', ['BOOKED', 'GATE_IN', 'SAILING', 'ARRIVED_PORT']);
        })->sum('total_paid_amount') ?? 0;

        // Riwayat audit trail
        $auditLogs = AuditTrail::with('adminUser')
            ->where('record_id', (string) $user->id)
            ->latest('created_at')
            ->limit(15)
            ->get();

        return view('customers.retail-detail', compact(
            'user',
            'totalOrdersCount',
            'completedOrdersCount',
            'totalGoodsValue',
            'activeEscrowHold',
            'auditLogs'
        ));
    }

    /**
     * Verifikasi Kepatuhan AML / NIK KTP untuk Transaksi Kargo Bernilai Tinggi (> Rp 50 Juta) atau DG.
     */
    public function verifyAml(Request $request, $id)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16',
            'kyc_aml_status' => 'required|in:AML_VERIFIED,AML_REJECTED,STANDARD_VERIFIED',
            'business_type' => 'nullable|string|max:100',
            'aml_notes' => 'nullable|string|max:1000',
        ]);

        $user = User::where('user_type', 'RETAIL_CUSTOMER')->findOrFail($id);
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';

        DB::transaction(function () use ($user, $validated, $adminId, $request) {
            $user->update([
                'nik' => $validated['nik'],
                'kyc_aml_status' => $validated['kyc_aml_status'],
                'business_type' => $validated['business_type'] ?? $user->business_type,
                'ktp_verified_at' => $validated['kyc_aml_status'] === 'AML_VERIFIED' ? now() : null,
            ]);

            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'VERIFY_RETAIL_CUSTOMER_AML',
                'target_schema' => 'public',
                'target_table' => 'users',
                'record_id' => (string) $user->id,
                'after_state_json' => [
                    'customer_name' => $user->name,
                    'nik' => $validated['nik'],
                    'aml_status' => $validated['kyc_aml_status'],
                    'business_type' => $validated['business_type'] ?? null,
                    'notes' => $validated['aml_notes'] ?? null,
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        $msg = $validated['kyc_aml_status'] === 'AML_VERIFIED'
            ? "Verifikasi KTP & kepatuhan AML untuk {$user->name} BERHASIL DISETUJUI. Pelanggan dapat melakukan pengiriman kargo bernilai tinggi (> Rp 50 Jt)."
            : "Status verifikasi AML pelanggan {$user->name} telah diperbarui ({$validated['kyc_aml_status']}).";

        return back()->with('success', $msg);
    }

    /**
     * Mengubah status sanksi akun pelanggan retail (Active / Locked / Blacklist).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:ACTIVE,BOOKING_LOCKED,BLACKLISTED',
            'reason' => 'nullable|string|max:500',
        ]);

        $user = User::where('user_type', 'RETAIL_CUSTOMER')->findOrFail($id);
        $oldStatus = $user->status;
        $newStatus = $validated['status'];
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';

        DB::transaction(function () use ($user, $oldStatus, $newStatus, $validated, $adminId, $request) {
            $user->update(['status' => $newStatus]);

            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'UPDATE_RETAIL_CUSTOMER_STATUS',
                'target_schema' => 'public',
                'target_table' => 'users',
                'record_id' => (string) $user->id,
                'before_state_json' => ['status' => $oldStatus],
                'after_state_json' => [
                    'status' => $newStatus,
                    'reason' => $validated['reason'] ?? 'Penetapan sanksi administratif portal.',
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        return back()->with('success', "Status akun pelanggan {$user->name} berhasil diubah menjadi {$newStatus}.");
    }

    /**
     * Ekspor Data Pelanggan Retail & Saldo Escrow ke format file CSV/Excel.
     */
    public function export()
    {
        $users = User::where('user_type', 'RETAIL_CUSTOMER')->orderBy('name')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="pelanggan_retail_umkm_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID Pelanggan',
                'Nama Lengkap',
                'Kategori Usaha / Komoditas',
                'Email',
                'No. Handphone (WhatsApp)',
                'NIK KTP',
                'Status AML Kepatuhan',
                'Status Akun',
                'Tanggal Pendaftaran'
            ]);

            foreach ($users as $u) {
                fputcsv($file, [
                    $u->id,
                    $u->name,
                    $u->business_type ?? 'Perorangan Umum',
                    $u->email,
                    $u->phone ?? '-',
                    $u->nik ?? '-',
                    $u->kyc_aml_status ?? 'STANDARD_VERIFIED',
                    $u->status,
                    $u->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
