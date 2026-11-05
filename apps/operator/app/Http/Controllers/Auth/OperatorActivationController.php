<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatorActivationController extends Controller
{
    /**
     * Menampilkan form aktivasi akun operator dari link token email.
     * URL: https://ops.soracargo.com/register/invite?token={token}
     */
    public function showActivationForm(Request $request)
    {
        // 1. Validasi token (cek expiry 24 jam dan status token di DB)
        // 2. Ambil data operator yang sudah di-assign Admin (Nama, Email, Wilayah Hub, Role)
        // 3. Render view aktivasi dengan data identitas read-only
    }

    /**
     * Memproses pembuatan password mandiri & aktivasi akun oleh operator.
     */
    public function processActivation(Request $request)
    {
        // 1. Validasi password kuat (min 10 char, uppercase, number, symbol)
        // 2. Setup 2FA (WA OTP / Authenticator App)
        // 3. Update status akun: PENDING_INVITATION -> ACTIVE
        // 4. Burn / hanguskan token undangan agar tidak bisa dipakai ulang
        // 5. Catat audit log aktivasi (IP, Device, Waktu)
        // 6. Redirect ke Operator Dashboard
    }
}

