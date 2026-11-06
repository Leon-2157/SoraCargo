<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use SoraCargo\Core\Models\User;

class StaffManagementController extends Controller
{
    /**
     * Tampilkan data Kelola Staf & Hak Akses (RBAC).
     */
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = $request->query('search');

        $query = User::where('user_type', 'ADMIN_USER');

        if (!empty($role)) {
            $query->where('admin_role', $role);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%")
                  ->orWhere('phone', 'ilike', "%{$search}%");
            });
        }

        $staffs = $query->orderBy('created_at', 'asc')->paginate(10)->withQueryString();

        // 4 KPI Agregasi Staf
        $totalStaff = User::where('user_type', 'ADMIN_USER')->count();
        $superAdmins = User::where('user_type', 'ADMIN_USER')->where('admin_role', 'SUPER_ADMIN')->count();
        $financeAdmins = User::where('user_type', 'ADMIN_USER')->where('admin_role', 'FINANCE_ADMIN')->count();
        $opsAdmins = User::where('user_type', 'ADMIN_USER')->where('admin_role', 'OPS_ADMIN')->count();

        return view('system.staff', compact(
            'staffs',
            'totalStaff',
            'superAdmins',
            'financeAdmins',
            'opsAdmins',
            'role',
            'search'
        ));
    }

    /**
     * Tambah Akun Staf Internal Baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'phone' => 'nullable|string|max:50',
            'admin_role' => 'required|in:SUPER_ADMIN,FINANCE_ADMIN,OPS_ADMIN',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'phone' => $request->phone,
            'user_type' => 'ADMIN_USER',
            'admin_role' => $request->admin_role,
            'status' => 'ACTIVE',
            'password' => Hash::make($request->password),
        ]);

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'CREATE_INTERNAL_STAFF',
            'target_schema' => 'public',
            'target_table' => 'users',
            'record_id' => $user->id,
            'before_state_json' => null,
            'after_state_json' => json_encode([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->admin_role,
                'status' => $user->status,
            ]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', "Akun staf baru {$user->name} ({$user->admin_role}) berhasil didaftarkan.");
    }

    /**
     * Saklar Nonaktifkan / Aktifkan Akun Staf.
     */
    public function toggleStatus(Request $request, string $id)
    {
        $user = User::where('user_type', 'ADMIN_USER')->findOrFail($id);

        if ($user->id === Auth::id() || $user->email === 'valerie.admin@soracargo.com') {
            return back()->withErrors(['staff' => 'Akun Superadmin Utama tidak dapat dinonaktifkan demi integritas sistem.']);
        }

        $beforeState = ['status' => $user->status];
        $newStatus = ($user->status === 'ACTIVE') ? 'SUSPENDED' : 'ACTIVE';
        $user->status = $newStatus;
        $user->save();

        // Rekam Immutable Audit Trail
        $adminId = Auth::id() ?? 'a0000000-0000-0000-0000-000000000001';
        DB::table('admin.immutable_audit_trails')->insert([
            'admin_user_id' => $adminId,
            'action_type' => 'TOGGLE_INTERNAL_STAFF_STATUS',
            'target_schema' => 'public',
            'target_table' => 'users',
            'record_id' => $user->id,
            'before_state_json' => json_encode($beforeState),
            'after_state_json' => json_encode(['status' => $newStatus]),
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Portal',
            'created_at' => now(),
        ]);

        $msg = ($newStatus === 'ACTIVE') 
            ? "Akun staf {$user->name} telah DIAKTIFKAN kembali."
            : "Akun staf {$user->name} RESMI DIBEKUKAN (Suspended).";

        return redirect()->back()->with('success', $msg);
    }
}

