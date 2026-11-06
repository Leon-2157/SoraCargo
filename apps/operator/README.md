# SoraCargo — Operator Portal (Regional VPN / Semi-Private)

Aplikasi operasional dispatcher armada, pengawasan manifest kargo, koordinasi supir dan nahkoda kapal, pengurusan kepabeanan pabean, serta titik pertama layanan dukungan pelanggan (*Tier 1 Support*).

---

## 1. Spesifikasi Teknis & Akses Jaringan

- **Tier Keamanan**: **Semi-Private Access** (Wajib terhubung melalui IP Gateway VPN Regional / Kantor Cabang terdaftar).
- **Domain Produksi**: `ops-id.soracargo.com`, `ops-sg.soracargo.com`, `ops-my.soracargo.com`.
- **Domain Pengujian Lokal**: `http://ops.soracargo.local` (Port 8002 via Nginx Gateway).
- **Akses Database PostgreSQL**:
  - Schema `ops`: Akses penuh (`SELECT`, `INSERT`, `UPDATE`).
  - Schema `public`: Akses baca (`SELECT` master data kargo & pelabuhan).
  - Schema `admin`: **DITOLAK KERAS (REVOKE ALL)**.

---

## 2. Tata Kelola & Fitur Utama

1. **Aktivasi Akun Mandiri (Zero Public Registration)**:
   - Operator tidak dapat mendaftar sendiri secara publik.
   - Pendaftaran hanya melalui token undangan kriptografis 24-jam dari Superadmin (`app/Http/Controllers/Auth/OperatorActivationController.php`).
   - Identitas terkunci (*Read-Only*); operator hanya memasukkan password kuat dan aktivasi **2FA Wajib** (WhatsApp OTP / TOTP).
2. **Pemisahan Peran Operasional (Role-Based Access Control)**:
   - **`OPERATOR_DOMESTIC`**: Manajemen pengiriman darat/laut nusantara, Surat Jalan, Delivery Order (DO), penugasan supir armada, dan verifikasi e-POD lokal.
   - **`OPERATOR_INTERNATIONAL`**: Pengurusan ekspor-impor, sertifikasi PPJK, integrasi respon EDI Bea Cukai (Jalur Hijau, Kuning, Merah), verifikasi HS Code, PEB/PIB, dan koordinasi Bill of Lading (B/L) samudra.
3. **Pusat Antrean Tiket & SLA Respons WhatsApp**:
   - Menerima chat dari pelanggan yang dialihkan dari portal customer.
   - Wajib merespons dalam **SLA 15 menit** sebelum sistem menerbitkan peringatan internal otomatis.
4. **Eskalasi Tiket Kritis ke Superadmin**:
   - Menangani insiden cuaca ekstrem, sengketa muatan basah/rusak, pembuatan Berita Acara Kerusakan (BAP), dan permohonan persetujuan biaya darurat (> Rp 10.000.000).

---

## 3. Struktur Direktori Kunci

```text
apps/operator/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── OperatorActivationController.php  # Verifikasi token undangan & 2FA
│   │   │   ├── Dispatch/                             # Penugasan supir & jadwal armada
│   │   │   ├── Customs/                              # Modul PPJK ekspor-impor
│   │   │   └── Escalation/                           # Eskalasi tiket darurat ke admin
│   │   └── Middleware/                               # EnforceRegionalVPN & Enforce2FA
│   └── Providers/
├── routes/
│   └── web.php
└── README.md
```

---

> Referensi lengkap daur hidup dan komunikasi operator: lihat [docs/operator-lifecycle.md](file:///home/leon/Downloads/SoraCargo/docs/operator-lifecycle.md) dan [docs/communication-flow.md](file:///home/leon/Downloads/SoraCargo/docs/communication-flow.md).
