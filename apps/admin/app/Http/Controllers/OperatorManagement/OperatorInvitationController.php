<?php

namespace App\Http\Controllers\OperatorManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SoraCargo\Core\Models\User;
use SoraCargo\Core\Models\Port;
use SoraCargo\Core\Models\OperatorProfile;
use SoraCargo\Core\Models\OperatorInvitation;
use SoraCargo\Core\Models\AuditTrail;

class OperatorInvitationController extends Controller
{
    /**
     * Menampilkan daftar permohonan & operator aktif dari database nyata.
     */
    public function index(Request $request)
    {
        $tier = $request->query('tier');
        $hubId = $request->query('hub');
        $search = $request->query('search');

        $query = OperatorProfile::with(['user', 'hub'])->latest('created_at');

        // Filter per Kategori Tier (Lokal vs Lintas Batas)
        if ($tier === 'local') {
            $query->where('role_tier', 'OPERATOR_DOMESTIC');
        } elseif ($tier === 'cross_border') {
            $query->where('role_tier', 'OPERATOR_INTERNATIONAL');
        }

        // Filter per Regional Hub
        if (!empty($hubId) && $hubId !== 'all') {
            $query->where('assigned_hub_id', $hubId);
        }

        // Filter Pencarian (Nama, ID Pegawai, Email)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'ILIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'ILIKE', "%{$search}%")
                                ->orWhere('email', 'ILIKE', "%{$search}%");
                  });
            });
        }

        $operators = $query->paginate(10)->withQueryString();

        // Agregasi Statistik untuk Tab Navigasi & Badge
        $totalCount = OperatorProfile::count();
        $localCount = OperatorProfile::where('role_tier', 'OPERATOR_DOMESTIC')->count();
        $crossBorderCount = OperatorProfile::where('role_tier', 'OPERATOR_INTERNATIONAL')->count();

        // Master Pelabuhan untuk Dropdown Filter & Modal
        $ports = Port::orderBy('country_code')->orderBy('name')->get();

        // Ambil token undangan aktif yang belum diklaim
        $invitationsByEmail = OperatorInvitation::where('is_claimed', false)
            ->where('expires_at', '>', now())
            ->get()
            ->keyBy('email');

        return view('operators.index', compact(
            'operators',
            'ports',
            'totalCount',
            'localCount',
            'crossBorderCount',
            'invitationsByEmail',
            'tier',
            'hubId',
            'search'
        ));
    }

    /**
     * Memproses permohonan baru / mengundang operator resmi dengan token 24 jam.
     */
    public function invite(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'phone' => 'required|string|max:50',
            'employee_id' => ['required', 'string', 'max:50', Rule::unique(OperatorProfile::class, 'employee_id')],
            'hub_id' => ['required', 'string', Rule::exists(Port::class, 'id')],
            'role' => 'required|string|in:OPERATOR_DOMESTIC,OPERATOR_INTERNATIONAL',
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem SoraCargo.',
            'employee_id.unique' => 'ID Pegawai tersebut sudah digunakan oleh operator lain.',
            'hub_id.exists' => 'Regional Hub yang dipilih tidak valid di basis data.',
        ]);

        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001'; // Default ke Superadmin Valerie
        $token = Str::random(64);
        $expiresAt = now()->addHours(24);

        DB::transaction(function () use ($validated, $token, $expiresAt, $adminId, $request) {
            // 1. Buat User Baru dengan Status PENDING_ACTIVATION
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make(Str::random(32)),
                'user_type' => 'OPERATOR_USER',
                'admin_role' => null,
                'status' => 'PENDING_ACTIVATION',
                'two_factor_secret' => null,
                'two_factor_enabled_at' => null,
            ]);

            // 2. Buat Profil Operator Lapangan
            $profile = OperatorProfile::create([
                'user_id' => $user->id,
                'employee_id' => strtoupper(trim($validated['employee_id'])),
                'assigned_hub_id' => $validated['hub_id'],
                'role_tier' => $validated['role'],
                'kpi_rating' => 5.00,
                'is_on_duty' => false,
            ]);

            // 3. Terbitkan Token Undangan 24 Jam
            OperatorInvitation::create([
                'invitation_token' => $token,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'assigned_hub_id' => $validated['hub_id'],
                'assigned_role' => $validated['role'],
                'expires_at' => $expiresAt,
                'is_claimed' => false,
                'invited_by_admin_id' => $adminId,
            ]);

            // 4. Catat Jejak Audit Permanen (Immutable Audit Trail)
            AuditTrail::create([
                'admin_user_id' => $adminId,
                'action_type' => 'INVITE_OPERATOR',
                'target_schema' => 'ops',
                'target_table' => 'operator_profiles',
                'record_id' => (string) $profile->id,
                'after_state_json' => [
                    'employee_id' => $profile->employee_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'hub' => $validated['hub_id'],
                    'role' => $validated['role'],
                    'token_expires' => $expiresAt->toIso8601String(),
                ],
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
                'created_at' => now(),
            ]);
        });

        $activationUrl = url("/operator/activate?token={$token}");

        return redirect()->route('admin.operators.index')
            ->with('success', "Undangan berhasil diterbitkan untuk operator {$validated['name']} ({$validated['employee_id']})!")
            ->with('invitation_url', $activationUrl)
            ->with('invitation_name', $validated['name'])
            ->with('invitation_phone', $validated['phone'])
            ->with('invitation_expires', $expiresAt->format('d M Y, H:i') . ' WIB');
    }

    /**
     * Kirim ulang / perpanjang token undangan operator yang masih pending.
     */
    public function resendInvite(Request $request, $id)
    {
        $profile = OperatorProfile::with('user')->findOrFail($id);
        $user = $profile->user;

        $newToken = Str::random(64);
        $newExpires = now()->addHours(24);
        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

        OperatorInvitation::updateOrCreate(
            ['email' => $user->email],
            [
                'invitation_token' => $newToken,
                'phone' => $user->phone ?? '-',
                'assigned_hub_id' => $profile->assigned_hub_id,
                'assigned_role' => $profile->role_tier,
                'expires_at' => $newExpires,
                'is_claimed' => false,
                'invited_by_admin_id' => $adminId,
            ]
        );

        // Catat Audit Trail
        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'RESEND_OPERATOR_INVITATION',
            'target_schema' => 'admin',
            'target_table' => 'operator_invitations',
            'record_id' => (string) $profile->id,
            'after_state_json' => [
                'employee_id' => $profile->employee_id,
                'email' => $user->email,
                'new_expires' => $newExpires->toIso8601String(),
            ],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        $activationUrl = url("/operator/activate?token={$newToken}");

        return back()
            ->with('success', "Token aktivasi baru 24-jam berhasil diterbitkan untuk {$user->name}!")
            ->with('invitation_url', $activationUrl)
            ->with('invitation_name', $user->name)
            ->with('invitation_phone', $user->phone)
            ->with('invitation_expires', $newExpires->format('d M Y, H:i') . ' WIB');
    }

    /**
     * Kontrol status akun: Suspend sementara atau Pulihkan akses operator.
     */
    public function toggleStatus(Request $request, $operatorId)
    {
        $profile = OperatorProfile::with('user')->findOrFail($operatorId);
        $user = $profile->user;

        $oldStatus = $user->status;
        $newStatus = ($oldStatus === 'ACTIVE') ? 'SUSPENDED' : 'ACTIVE';

        $user->update(['status' => $newStatus]);

        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';

        // Catat Audit Trail
        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => $newStatus === 'ACTIVE' ? 'RESTORE_OPERATOR' : 'SUSPEND_OPERATOR',
            'target_schema' => 'public',
            'target_table' => 'users',
            'record_id' => (string) $user->id,
            'before_state_json' => ['status' => $oldStatus],
            'after_state_json' => ['status' => $newStatus],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        $msg = $newStatus === 'ACTIVE'
            ? "Akun operator {$user->name} ({$profile->employee_id}) berhasil dipulihkan ke status AKTIF."
            : "Akun operator {$user->name} ({$profile->employee_id}) berhasil DIBEKUKAN (SUSPENDED). Akses lapangan dicabut sementara.";

        return back()->with('success', $msg);
    }

    /**
     * Mengubah status shift dinas operator lapangan (ON_DUTY <-> OFF_DUTY).
     */
    public function toggleDuty(Request $request, $operatorId)
    {
        $profile = OperatorProfile::with('user')->findOrFail($operatorId);
        $newDuty = !$profile->is_on_duty;

        $profile->update(['is_on_duty' => $newDuty]);

        $adminId = auth()->id() ?? 'a0000000-0000-0000-0000-000000000001';
        AuditTrail::create([
            'admin_user_id' => $adminId,
            'action_type' => 'TOGGLE_OPERATOR_DUTY',
            'target_schema' => 'ops',
            'target_table' => 'operator_profiles',
            'record_id' => (string) $profile->id,
            'after_state_json' => ['is_on_duty' => $newDuty],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'user_agent' => $request->userAgent() ?? 'SoraCargo Admin Web',
            'created_at' => now(),
        ]);

        $statusText = $newDuty ? 'ON DUTY (Aktif Piket Lapangan)' : 'OFF DUTY (Istirahat / Selesai Shift)';
        return back()->with('success', "Status dinas operator {$profile->user->name} ({$profile->employee_id}) diubah menjadi {$statusText}.");
    }
}
