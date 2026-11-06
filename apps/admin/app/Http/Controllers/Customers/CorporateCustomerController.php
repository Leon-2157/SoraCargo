<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SoraCargo\Core\Models\Company;
use SoraCargo\Core\Models\CorporateCredit;
use SoraCargo\Core\Models\User;
use SoraCargo\Core\Models\AuditTrail;
use SoraCargo\Core\Models\Invoice;

class CorporateCustomerController extends Controller
{
    /**
     * Menampilkan daftar mitra perusahaan Corporate B2B & status kredit.
     */
    public function index(Request $request)
    {
        $kyc = $request->query('kyc');
        $debt = $request->query('debt');
        $search = $request->query('search');

        $query = Company::with(['user', 'credit.legalityVerifier', 'credit.creditApprover'])->latest('created_at');

        // Filter Status KYC
        if (!empty($kyc) && $kyc !== 'all') {
            $query->whereHas('credit', function ($cq) use ($kyc) {
                $cq->where('kyc_status', $kyc);
            });
        }

        // Filter Tahap Penagihan (Debt Enforcement)
        if (!empty($debt) && $debt !== 'all') {
            $query->whereHas('credit', function ($cq) use ($debt) {
                $cq->where('debt_enforcement_stage', $debt);
            });
        }

        // Filter Pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'ILIKE', "%{$search}%")
                  ->orWhere('nib', 'ILIKE', "%{$search}%")
                  ->orWhere('npwp', 'ILIKE', "%{$search}%")
                  ->orWhere('pic_name', 'ILIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('email', 'ILIKE', "%{$search}%");
                  });
            });
        }

        $companies = $query->paginate(10)->withQueryString();

        // Statistik Kartu KPI Radar B2B
        $totalCompaniesCount = Company::count();
        $activeCorporateCount = CorporateCredit::where('kyc_status', 'VERIFIED_APPROVED')->count();
        $totalApprovedCredit = CorporateCredit::where('kyc_status', 'VERIFIED_APPROVED')->sum('credit_limit_amount') ?? 0;
        $totalUsedCredit = CorporateCredit::sum('used_credit_amount') ?? 0;
        $pendingMakerCount = CorporateCredit::where('kyc_status', 'PENDING_VERIFICATION')->count();
        $pendingCheckerCount = CorporateCredit::where('kyc_status', 'LEGALITY_VERIFIED')->count();
        $overdueCount = CorporateCredit::whereIn('debt_enforcement_stage', ['SP1_ISSUED', 'SP2_LOCKED', 'SP3_LEGAL_COLLECTION'])->count();

        return view('customers.corporate', compact(
            'companies',
            'totalCompaniesCount',
            'activeCorporateCount',
            'totalApprovedCredit',
            'totalUsedCredit',
            'pendingMakerCount',
            'pendingCheckerCount',
            'overdueCount',
            'kyc',
            'debt',
            'search'
        ));
    }

    /**
     * Halaman Penuh Dedicated (Customer 360° Profile).
     */
    public function show($id)
    {
        $company = Company::with([
            'user',
            'credit.legalityVerifier',
            'credit.creditApprover',
            'invoices' => function ($iq) {
                $iq->latest('due_date')->limit(15);
            },
            'bookings' => function ($bq) {
                $bq->with(['route.originPort', 'route.destinationPort'])->latest('created_at')->limit(15);
            }
        ])->findOrFail($id);

        $totalFreightSpend = Invoice::where('company_id', $company->id)->sum('total_invoice_amount') ?? 0;
        $unpaidInvoicesCount = Invoice::where('company_id', $company->id)->where('payment_status', 'UNPAID')->count();
        $unpaidInvoicesTotal = Invoice::where('company_id', $company->id)->where('payment_status', 'UNPAID')->sum('total_invoice_amount') ?? 0;
        $totalBookingsCount = $company->bookings()->count();
        $totalTeuVolume = $company->bookings()->sum('total_volume_cbm') ?? 0;

        // Riwayat audit forensik terkait perusahaan dan penggunanya
        $auditLogs = AuditTrail::with('adminUser')
            ->where(function ($aq) use ($company) {
                $aq->where('record_id', (string) $company->id)
                   ->orWhere('record_id', (string) $company->user_id);
            })
            ->latest('created_at')
            ->limit(20)
            ->get();

        return view('customers.corporate-detail', compact(
            'company',
            'totalFreightSpend',
            'unpaidInvoicesCount',
            'unpaidInvoicesTotal',
            'totalBookingsCount',
            'totalTeuVolume',
            'auditLogs'
        ));
    }

    /**
     * TAHAP 1: Maker (Ops Admin) - Validasi Berkas Dokumen Legalitas NIB / NPWP / Akta.
     */
    public function verifyLegality(Request $request, $id)
    {
        $validated = $request->validate([
            'legality_status' => 'required|in:LEGALITY_VERIFIED,REJECTED',
            'legality_notes' => 'required|string|min:5|max:1000',
        ]);

        $company = Company::with(['user', 'credit'])->findOrFail($id);
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';

        DB::transaction(function () use ($company, $validated, $adminId, $request) {
            $newStatus = $validated['legality_status'] === 'LEGALITY_VERIFIED' ? 'LEGALITY_VERIFIED' : 'REJECTED';

            CorporateCredit::updateOrCreate(
                ['company_id' => $company->id],
                [
                    'kyc_status' => $newStatus,
                    'legality_verified_by_admin_id' => $adminId,
                    'legality_verified_at' => now(),
                    'legality_notes' => $validated['legality_notes'],
                ]
            );

            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'MAKER_VERIFY_CORPORATE_LEGALITY',
                'target_schema' => 'admin',
                'target_table' => 'corporate_credits',
                'record_id' => (string) $company->id,
                'after_state_json' => [
                    'company' => $company->company_name,
                    'stage' => 'TAHAP_1_MAKER_LEGALITY',
                    'status' => $newStatus,
                    'notes' => $validated['legality_notes'],
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        $msg = $validated['legality_status'] === 'LEGALITY_VERIFIED'
            ? "[Tahap 1 Maker Selesai] Berkas legalitas {$company->company_name} berhasil diverifikasi valid. Menunggu evaluasi Checker Finance untuk penetapan limit plafon."
            : "[Tahap 1 Ditolak] Berkas legalitas {$company->company_name} ditolak. Alasan telah dicatat.";

        return back()->with('success', $msg);
    }

    /**
     * TAHAP 2: Checker (Finance Admin / Superadmin) - Penetapan Plafon Kredit & TOP.
     */
    public function approveCredit(Request $request, $id)
    {
        $validated = $request->validate([
            'credit_limit_amount' => 'required|numeric|min:0',
            'top_days' => 'required|integer|in:14,30,45,60,90',
            'bank_guarantee_ref' => 'nullable|string|max:100',
            'debt_enforcement_stage' => 'required|in:HEALTHY,SP1_ISSUED,SP2_LOCKED,SP3_LEGAL_COLLECTION',
            'checker_notes' => 'nullable|string|max:1000',
        ]);

        $company = Company::with(['user', 'credit'])->findOrFail($id);
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';

        DB::transaction(function () use ($company, $validated, $adminId, $request) {
            CorporateCredit::updateOrCreate(
                ['company_id' => $company->id],
                [
                    'credit_limit_amount' => $validated['credit_limit_amount'],
                    'top_days' => $validated['top_days'],
                    'kyc_status' => 'VERIFIED_APPROVED',
                    'bank_guarantee_ref' => $validated['bank_guarantee_ref'] ?? null,
                    'debt_enforcement_stage' => $validated['debt_enforcement_stage'],
                    'credit_approved_by_admin_id' => $adminId,
                    'credit_approved_at' => now(),
                    'verified_by_admin_id' => $adminId,
                ]
            );

            // Aktifkan akun pengguna perusahaan bila sebelumnya tertunda
            if ($company->user && $company->user->status === 'PENDING_ACTIVATION') {
                $company->user->update(['status' => 'ACTIVE']);
            }

            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'CHECKER_APPROVE_CORPORATE_CREDIT',
                'target_schema' => 'admin',
                'target_table' => 'corporate_credits',
                'record_id' => (string) $company->id,
                'after_state_json' => [
                    'company' => $company->company_name,
                    'stage' => 'TAHAP_2_CHECKER_CREDIT_APPROVAL',
                    'credit_limit' => $validated['credit_limit_amount'],
                    'top_days' => $validated['top_days'],
                    'bank_guarantee' => $validated['bank_guarantee_ref'] ?? null,
                    'notes' => $validated['checker_notes'] ?? null,
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        $msg = "[Tahap 2 Checker Disetujui] Plafon kredit Rp " . number_format($validated['credit_limit_amount'], 0, ',', '.') .
               " (TOP {$validated['top_days']} Hari) untuk {$company->company_name} RESMI DIAKTIFKAN.";

        return back()->with('success', $msg);
    }

    /**
     * Membekukan atau memulihkan izin booking kargo (Lock Booking) dengan opsi Dispensasi.
     */
    public function toggleLockBooking(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $company = Company::with(['user', 'credit'])->findOrFail($id);
        $user = $company->user;

        $oldStatus = $user->status;
        $newStatus = ($oldStatus === 'BOOKING_LOCKED') ? 'ACTIVE' : 'BOOKING_LOCKED';
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';

        DB::transaction(function () use ($company, $user, $oldStatus, $newStatus, $validated, $adminId, $request) {
            $user->update(['status' => $newStatus]);

            if ($newStatus === 'BOOKING_LOCKED') {
                if ($company->credit) {
                    $company->credit->update([
                        'debt_enforcement_stage' => 'SP2_LOCKED',
                        'dispensation_notes' => null,
                    ]);
                }
            } else {
                // Pemulihan / Dispensasi
                if ($company->credit) {
                    $company->credit->update([
                        'debt_enforcement_stage' => 'HEALTHY',
                        'dispensation_notes' => $validated['reason'] ?? 'Dispensasi khusus Superadmin.',
                    ]);
                }
            }

            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'TOGGLE_CORPORATE_BOOKING_LOCK',
                'target_schema' => 'public',
                'target_table' => 'users',
                'record_id' => (string) $user->id,
                'before_state_json' => ['status' => $oldStatus],
                'after_state_json' => [
                    'status' => $newStatus,
                    'reason' => $validated['reason'] ?? 'Operasi manual admin portal.',
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        $msg = $newStatus === 'BOOKING_LOCKED'
            ? "Izin booking kargo {$company->company_name} RESMI DIKUNCI (BOOKING LOCKED)."
            : "Izin booking kargo {$company->company_name} telah DIPULIHKAN (DISPENSASI AKTIF).";

        return back()->with('success', $msg);
    }

    /**
     * Memicu pengiriman Surat Peringatan (SP1/SP2/SP3) via WhatsApp Baileys ke PIC.
     */
    public function sendWarning(Request $request, $id)
    {
        $validated = $request->validate([
            'sp_stage' => 'required|in:SP1_ISSUED,SP2_LOCKED,SP3_LEGAL_COLLECTION',
            'custom_message' => 'nullable|string|max:1000',
        ]);

        $company = Company::with(['user', 'credit'])->findOrFail($id);
        $stage = $validated['sp_stage'];

        if ($company->credit) {
            $company->credit->update(['debt_enforcement_stage' => $stage]);
        }

        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'DISPATCH_BAILEYS_CORPORATE_SP',
            'target_schema' => 'admin',
            'target_table' => 'corporate_credits',
            'record_id' => (string) $company->id,
            'after_state_json' => [
                'company' => $company->company_name,
                'pic_name' => $company->pic_name,
                'pic_phone' => $company->pic_phone,
                'sp_stage' => $stage,
                'message_preview' => $validated['custom_message'] ?? 'Notifikasi resmi tagihan jatuh tempo SoraCargo.',
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        return back()->with('success', "Surat Peringatan [{$stage}] untuk PIC {$company->company_name} ({$company->pic_phone}) berhasil dijadwalkan & dikirimkan via Baileys WhatsApp Gateway.");
    }

    /**
     * Ekspor Laporan Kredit & Piutang B2B ke format file CSV/Excel.
     */
    public function export()
    {
        $companies = Company::with(['user', 'credit'])->orderBy('company_name')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_kredit_b2b_' . date('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($companies) {
            $file = fopen('php://output', 'w');
            // Menulis BOM UTF-8 agar Excel membaca aksen Indonesia dengan benar
            fputs($file, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($file, [
                'ID Perusahaan',
                'Nama Perusahaan',
                'NIB (OSS)',
                'NPWP',
                'Nama PIC',
                'No. HP PIC',
                'Email',
                'Status Verifikasi KYC',
                'Limit Plafon Kredit (IDR)',
                'Plafon Terpakai (IDR)',
                'Sisa Plafon Kredit (IDR)',
                'Rasio Utilisasi (%)',
                'Termin TOP (Hari)',
                'Status Penagihan (Debt Stage)',
                'Status Akses Akun',
                'Tanggal Bergabung'
            ]);

            foreach ($companies as $c) {
                $credit = $c->credit;
                $limit = $credit ? (float) $credit->credit_limit_amount : 0;
                $used = $credit ? (float) $credit->used_credit_amount : 0;
                $remaining = max(0, $limit - $used);
                $utilization = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;

                fputcsv($file, [
                    $c->id,
                    $c->company_name,
                    $c->nib,
                    $c->npwp,
                    $c->pic_name,
                    $c->pic_phone,
                    $c->user->email ?? '-',
                    $credit ? $credit->kyc_status : 'PENDING_VERIFICATION',
                    number_format($limit, 0, ',', '.'),
                    number_format($used, 0, ',', '.'),
                    number_format($remaining, 0, ',', '.'),
                    $utilization . '%',
                    $credit ? $credit->top_days : 30,
                    $credit ? $credit->debt_enforcement_stage : 'HEALTHY',
                    $c->user->status ?? 'ACTIVE',
                    $c->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
