<?php

namespace App\Http\Controllers\OperatorManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatorInvitationController extends Controller
{
    /**
     * Menampilkan daftar permohonan & operator aktif.
     */
    public function index()
    {
        // Menampilkan list operator per regional hub beserta status akun
    }

    /**
     * Memproses permohonan baru / mengundang operator resmi via Email Gateway.
     */
    public function invite(Request $request)
    {
        // 1. Validasi input: Nama, Email Resmi Kantor, Hub Wilayah, Role Dispatcher
        // 2. Generate token unik & set kedaluwarsa 24 jam di DB
        // 3. Simpan record akun dengan status PENDING_INVITATION
        // 4. Trigger Email Gateway (dan WA alert): Kirim link aktivasi berbatas waktu
        // 5. Catat audit trail: siapa admin yang menyetujui/mengundang
    }

    /**
     * Kontrol status akun: Suspend sementara atau Revoke akses operator.
     */
    public function toggleStatus(Request $request, $operatorId)
    {
        // Ubah status: ACTIVE <-> SUSPENDED / REVOKED
    }
}

