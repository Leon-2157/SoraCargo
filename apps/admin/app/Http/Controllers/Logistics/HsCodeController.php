<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SoraCargo\Core\Models\HsCode;

class HsCodeController extends Controller
{
    /**
     * Tampilkan data Kamus Barang & Bea Cukai (HS Code).
     */
    public function index(Request $request)
    {
        $filterLartas = $request->query('lartas');
        $search = $request->query('search');

        $query = HsCode::withCount('cargoBookings');

        if ($filterLartas === 'yes') {
            $query->where('has_lartas_restriction', true);
        } elseif ($filterLartas === 'no') {
            $query->where('has_lartas_restriction', false);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'ilike', "%{$search}%")
                  ->orWhere('description_id', 'ilike', "%{$search}%")
                  ->orWhere('description_en', 'ilike', "%{$search}%")
                  ->orWhere('required_permit_agency', 'ilike', "%{$search}%");
            });
        }

        $hscodes = $query->orderBy('code', 'asc')->paginate(10)->withQueryString();

        // 4 KPI Agregasi Kepabeanan
        $totalHsCodes = HsCode::count();
        $totalLartas = HsCode::where('has_lartas_restriction', true)->count();
        $totalNonLartas = HsCode::where('has_lartas_restriction', false)->count();
        $avgImportDuty = HsCode::avg('import_duty_pct') ?? 0;

        return view('logistics.hscode', compact(
            'hscodes',
            'totalHsCodes',
            'totalLartas',
            'totalNonLartas',
            'avgImportDuty',
            'filterLartas',
            'search'
        ));
    }

    /**
     * Tambah Pos Tarif HS Code Baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:15', Rule::unique(HsCode::class, 'code')],
            'description_id' => 'required|string|max:500',
            'description_en' => 'nullable|string|max:500',
            'import_duty_pct' => 'required|numeric|between:0,100',
            'vat_pct' => 'required|numeric|between:0,100',
            'income_tax_pct' => 'required|numeric|between:0,100',
            'has_lartas_restriction' => 'required|boolean',
            'required_permit_agency' => 'nullable|string|max:255',
        ]);

        $code = trim($request->code);

        $hscode = HsCode::create([
            'code' => $code,
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'import_duty_pct' => $request->import_duty_pct,
            'vat_pct' => $request->vat_pct,
            'income_tax_pct' => $request->income_tax_pct,
            'has_lartas_restriction' => (bool) $request->has_lartas_restriction,
            'required_permit_agency' => $request->has_lartas_restriction ? $request->required_permit_agency : null,
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'CREATE_HS_CODE_TARIFF',
            'target_schema' => 'public',
            'target_table' => 'hs_codes',
            'record_id' => $hscode->code,
            'before_state_json' => null,
            'after_state_json' => json_encode($hscode->toArray()),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Pos tarif HS Code {$hscode->code} ({$hscode->description_id}) berhasil didaftarkan ke kamus kepabeanan.");
    }

    /**
     * Perbarui Matriks Tarif & Kebijakan Lartas HS Code.
     */
    public function update(Request $request, string $code)
    {
        $hscode = HsCode::findOrFail($code);

        $request->validate([
            'description_id' => 'required|string|max:500',
            'description_en' => 'nullable|string|max:500',
            'import_duty_pct' => 'required|numeric|between:0,100',
            'vat_pct' => 'required|numeric|between:0,100',
            'income_tax_pct' => 'required|numeric|between:0,100',
            'has_lartas_restriction' => 'required|boolean',
            'required_permit_agency' => 'nullable|string|max:255',
        ]);

        $beforeState = $hscode->toArray();

        $hscode->update([
            'description_id' => $request->description_id,
            'description_en' => $request->description_en,
            'import_duty_pct' => $request->import_duty_pct,
            'vat_pct' => $request->vat_pct,
            'income_tax_pct' => $request->income_tax_pct,
            'has_lartas_restriction' => (bool) $request->has_lartas_restriction,
            'required_permit_agency' => $request->has_lartas_restriction ? $request->required_permit_agency : null,
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'UPDATE_HS_CODE_TARIFF',
            'target_schema' => 'public',
            'target_table' => 'hs_codes',
            'record_id' => $hscode->code,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode($hscode->toArray()),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Ketentuan pos tarif HS Code {$hscode->code} berhasil diperbarui.");
    }
}

