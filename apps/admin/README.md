# SoraCargo — Global Admin Portal (Strictly Private)

Aplikasi kendali sentral Superadmin Global untuk tata kelola hak akses operator, peninjauan eskalasi insiden darurat, tata kelola keuangan (*Milestone Escrow* & *Revenue Split*), persetujuan limit kredit B2B, audit sistem, dan konfigurasi fisik gateway.

---

## 1. Spesifikasi Teknis & Akses Jaringan

- **Tier Keamanan**: **Strictly Private Access** (Terisolasi 100% dari internet publik).
- **Metode Akses**: Hanya dapat diakses dari IP terdaftar laptop administrator melalui VPN mesh terenkripsi (Tailscale / WireGuard) atau SSH Tunnel aman.
- **Domain Produksi**: `admin.soracargo.internal`.
- **Domain Pengujian Lokal**: `http://admin.soracargo.local` (Port 8003 via Nginx Gateway dengan validasi IP internal).
- **Akses Database PostgreSQL**:
  - Memiliki akses penuh (`SELECT`, `INSERT`, `UPDATE`, `DELETE`) ke seluruh schema: `admin`, `ops`, dan `public`.

---

## 2. Fitur Kendali Utama

1. **Tata Kelola Akun Operator (Operator Management)**:
   - Meninjau permohonan akses calon operator baru (`app/Http/Controllers/OperatorManagement/OperatorInvitationController.php`).
   - Menerbitkan token aktivasi kriptografis 24-jam melalui Email Gateway.
   - Mengatur mutasi penempatan regional hub (misal: Tanjung Priok ke Batam).
   - Fitur *Emergency Revoke / Kill-Switch* untuk mencabut seluruh sesi operator secara instan jika terjadi pelanggaran SOP atau anomali keamanan.
2. **Pusat Eskalasi Darurat (Level 3 SLA & Dispute Resolution)**:
   - Menerima tiket darurat berprioritas tinggi dari operator (biaya sewa tugboat darurat, penanganan kapal kandas, klaim asuransi kargo maritim).
   - Memantau tiket obrolan WhatsApp yang menembus batas SLA (> 60 menit) dengan penalti KPI operator otomatis.
3. **Pusat Keuangan & Milestone Escrow**:
   - Memantau alokasi *Revenue Split*: Admin Platform (10-15%), Operator (60-80%), dan Pajak/Regulasi (5-25%).
   - Mengendalikan pembekuan (*Escrow Freeze*) atau pencairan dana bertahap (Milestone 1: 30%, Milestone 2: 40%, Milestone 3: 30%).
   - Verifikasi legalitas corporate dan penetapan limit plafon kredit (*Credit Limit*) untuk pelanggan B2B dengan Term of Payment (TOP 30–60 hari).
4. **Pusat Konfigurasi Gateway (Admin Only)**:
   - Pairing fisik nomor WhatsApp resmi via Scan QR Code Baileys (`services/wa-gateway`).
   - Monitoring kesehatan koneksi socket dan baterai perangkat WhatsApp.
   - Pengaturan konfigurasi server email SMTP, DKIM, dan template surat jalan resmi.

---

## 3. Struktur Direktori Kunci

```text
apps/admin/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── OperatorManagement/
│   │   │   │   └── OperatorInvitationController.php # Approval & token generation
│   │   │   ├── Escalations/                         # Review tiket darurat & klaim
│   │   │   ├── Finance/                             # Escrow ledger & split calculation
│   │   │   └── Gateways/                            # QR scan WA & SMTP setup
│   │   └── Middleware/                              # EnforceStrictAdminMeshIP
│   └── Providers/
├── routes/
│   └── web.php
└── README.md
```

---

> Referensi alur eskalasi dan matriks keuangan: lihat [docs/communication-flow.md](file:///home/leon/Downloads/SoraCargo/docs/communication-flow.md) dan [docs/shipping-and-financials.md](file:///home/leon/Downloads/SoraCargo/docs/shipping-and-financials.md).
