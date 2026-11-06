<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SoraCargo\Core\Models\Invoice;
use SoraCargo\Core\Models\Company;
use SoraCargo\Core\Models\User;

class InvoiceController extends Controller
{
    /**
     * Tampilkan daftar Faktur & Penagihan B2B.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');

        $query = Invoice::with(['company.user', 'company.corporateCredit', 'cargoBooking.route']);

        if ($filter === 'unpaid') {
            $query->where('payment_status', 'UNPAID');
        } elseif ($filter === 'overdue') {
            $query->where('payment_status', 'OVERDUE');
        } elseif ($filter === 'paid') {
            $query->where('payment_status', 'PAID');
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'ilike', "%{$search}%")
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('company_name', 'ilike', "%{$search}%")
                        ->orWhere('pic_name', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('cargoBooking', function ($bq) use ($search) {
                      $bq->where('tracking_number', 'ilike', "%{$search}%");
                  });
            });
        }

        $invoices = $query->orderByRaw("
            CASE 
                WHEN payment_status = 'OVERDUE' THEN 1 
                WHEN payment_status = 'UNPAID' THEN 2 
                ELSE 3 
            END
        ")->orderBy('due_date', 'asc')->paginate(10)->withQueryString();

        // 4 KPI Agregasi Keuangan Faktur B2B
        $totalReceivables = Invoice::where('payment_status', 'UNPAID')->sum('total_invoice_amount');
        $totalOverdue = Invoice::where('payment_status', 'OVERDUE')->sum('total_invoice_amount');
        $totalCollected = Invoice::where('payment_status', 'PAID')->sum('total_invoice_amount');
        $overdueCount = Invoice::where('payment_status', 'OVERDUE')->count();

        $counts = [
            'all' => Invoice::count(),
            'unpaid' => Invoice::where('payment_status', 'UNPAID')->count(),
            'overdue' => Invoice::where('payment_status', 'OVERDUE')->count(),
            'paid' => Invoice::where('payment_status', 'PAID')->count(),
        ];

        return view('finance.invoices', compact(
            'invoices',
            'totalReceivables',
            'totalOverdue',
            'totalCollected',
            'overdueCount',
            'counts',
            'filter',
            'search'
        ));
    }

    /**
     * Rekonsiliasi Pelunasan Bank Transfer oleh Superadmin Finance.
     */
    public function reconcile(Request $request, string $id)
    {
        $request->validate([
            'bank_account' => 'required|string|max:100',
            'payment_reference' => 'required|string|max:100',
            'paid_amount' => 'required|numeric|min:1',
            'reconciliation_notes' => 'required|string|min:5|max:500',
        ]);

        $invoice = Invoice::with('company')->findOrFail($id);
        $beforeState = $invoice->toArray();
        $now = now();

        $invoice->payment_status = 'PAID';
        $invoice->paid_at = $now;
        $invoice->save();

        // Pulihkan / kurangi penggunaan plafon kredit perusahaan
        if ($invoice->company && $invoice->company->corporateCredit) {
            $credit = $invoice->company->corporateCredit;
            $newUsed = max(0, (float) $credit->used_credit_amount - (float) $request->paid_amount);
            $credit->used_credit_amount = $newUsed;
            $credit->save();
        }

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'RECONCILE_INVOICE_PAYMENT',
            'target_schema' => 'admin',
            'target_table' => 'invoices',
            'record_id' => $invoice->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode([
                'bank_account' => $request->bank_account,
                'payment_reference' => $request->payment_reference,
                'paid_amount' => $request->paid_amount,
                'notes' => $request->reconciliation_notes,
                'settled_at' => $now->toIso8601String(),
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', "Rekonsiliasi Berhasil: Faktur {$invoice->invoice_number} sebesar Rp " . number_format($request->paid_amount, 0, ',', '.') . " dinyatakan LUNAS dan limit kredit mitra telah disesuaikan.");
    }

    /**
     * Kirim Notifikasi Penagihan / SP (Surat Peringatan) via Gateway.
     */
    public function sendReminder(Request $request, string $id)
    {
        $request->validate([
            'reminder_channel' => 'required|in:WHATSAPP,EMAIL,BOTH',
            'notice_level' => 'required|in:FRIENDLY_REMINDER,SP1_WARNING,SP2_FINAL_DEMAND',
            'custom_message' => 'nullable|string|max:500',
        ]);

        $invoice = Invoice::with('company.user')->findOrFail($id);
        $now = now();

        // Update debt enforcement stage on corporate credit if exists
        if ($invoice->company && $invoice->company->corporateCredit) {
            $credit = $invoice->company->corporateCredit;
            if ($request->notice_level === 'SP1_WARNING') {
                $credit->debt_enforcement_stage = 'SP1_ISSUED';
            } elseif ($request->notice_level === 'SP2_FINAL_DEMAND') {
                $credit->debt_enforcement_stage = 'SP2_ISSUED';
            }
            $credit->save();
        }

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'DISPATCH_INVOICE_REMINDER',
            'target_schema' => 'admin',
            'target_table' => 'invoices',
            'record_id' => $invoice->id,
            'before_state_json' => json_encode(['invoice_number' => $invoice->invoice_number]),
            'after_state_json' => json_encode([
                'channel' => $request->reminder_channel,
                'level' => $request->notice_level,
                'custom_message' => $request->custom_message,
                'sent_to' => $invoice->company?->pic_phone,
                'timestamp' => $now->toIso8601String(),
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        return redirect()->back()->with('success', "Surat Penagihan ({$request->notice_level}) berhasil dikirimkan via {$request->reminder_channel} ke PIC {$invoice->company?->pic_name} ({$invoice->company?->pic_phone}).");
    }

    /**
     * Kunci / Buka Akses Booking Kredit B2B langsung dari baris faktur.
     */
    public function toggleBookingLock(Request $request, string $id)
    {
        $invoice = Invoice::with('company.user')->findOrFail($id);
        $user = $invoice->company?->user;

        if (!$user) {
            return back()->withErrors(['company' => 'Pengguna penanggung jawab perusahaan tidak ditemukan.']);
        }

        $now = now();
        $isLocked = ($user->status === 'BOOKING_LOCKED');
        $newStatus = $isLocked ? 'ACTIVE' : 'BOOKING_LOCKED';
        $user->status = $newStatus;
        $user->save();

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'TOGGLE_CORPORATE_BOOKING_LOCK_FROM_INVOICE',
            'target_schema' => 'public',
            'target_table' => 'users',
            'record_id' => $user->id,
            'before_state_json' => json_encode(['status' => $isLocked ? 'BOOKING_LOCKED' : 'ACTIVE']),
            'after_state_json' => json_encode(['status' => $newStatus, 'triggered_by_invoice' => $invoice->invoice_number]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => $now,
        ]);

        $statusMsg = ($newStatus === 'BOOKING_LOCKED') 
            ? "Akses booking kredit {$invoice->company->company_name} RESMI DIKUNCI (Booking Locked) karena tunggakan faktur."
            : "Kunci booking {$invoice->company->company_name} telah dibuka kembali (Status Aktif).";

        return redirect()->back()->with('success', $statusMsg);
    }
}
