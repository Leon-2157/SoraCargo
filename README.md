# SoraCargo — Arsitektur Multi-Tier & Multi-App

Repositori terintegrasi platform logistik kargo **SoraCargo**, dirancang dengan pemisahan aplikasi (*multi-app isolation*) dan segmentasi jaringan tingkat enterprise (*Public*, *Semi-Private Regional VPN*, dan *Strictly Private Admin*).

---

## 1. Topologi Jaringan & Akses Keamanan

```text
[ INTERNET PUBLIK ] ──────► customer.soracargo.com ──► apps/customer (Port 8001)
                            (Semua Pengguna Publik)

[ REGIONAL VPN ]    ──────► ops-id.soracargo.com   ──► apps/operator (Port 8002)
                            (Hanya IP Gateway VPN Negara Cabang)

[ PRIVATE LAPTOP/MESH] ───► admin.soracargo.internal ─► apps/admin   (Port 8003)
                            (Hanya IP Laptop Developer / Private WireGuard)
                                    │
                                    ▼
                         [ DATABASE TERPUSAT ]
                         (PostgreSQL / Redis)
```

| Aplikasi | Tier Keamanan | Target Pengguna | Karakteristik Akses |
| :--- | :--- | :--- | :--- |
| **`apps/customer`** | **Public** | Pelanggan / Shipper | Akses internet umum tanpa VPN. Tracking radar, cek tarif, AI assistant. |
| **`apps/operator`** | **Semi-Private** | Tim Dispatcher / Lapangan | Wajib koneksi VPN regional negara masing-masing (ID, SG, MY). Input kargo, status armada. |
| **`apps/admin`** | **Strictly Private** | Superadmin Global | Terisolasi 100% dari internet publik. Akses hanya dari laptop admin / Tailscale / SSH Tunnel. |

---

## 2. Struktur Direktori Proyek

```text
SoraCargo/
├── apps/
│   ├── customer/            # Laravel App: Portal Pelanggan Publik
│   ├── operator/            # Laravel App: Dispatcher Armada (VPN Regional)
│   │   └── app/Http/Controllers/Auth/OperatorActivationController.php
│   └── admin/               # Laravel App: Superadmin Global (Private Laptop)
│       └── app/Http/Controllers/OperatorManagement/OperatorInvitationController.php
│
├── packages/
│   └── core-domain/         # Shared Composer Package (Single Source of Truth)
│       ├── src/             # Model Eloquent, Enums, DTO, Value Objects
│       └── composer.json    # Package soracargo/core-domain
│
├── services/
│   ├── wa-gateway/          # In-House WhatsApp Gateway Service (Baileys/Node.js)
│   └── ai-service/          # Internal AI Copilot Service (Gemini/OpenAI Streaming)
│
├── podman/
│   ├── nginx/
│   │   └── conf.d/
│   │       └── default.conf # Reverse proxy rules & Network IP Whitelisting
│   ├── php/
│   │   └── Containerfile    # Base runtime PHP-FPM 8.3 & Extensions
│   └── podman-compose.yml   # Orkestrasi multi-container Podman
│
└── README.md                # Dokumentasi arsitektur proyek
```

---

## 3. Strategi Single Source of Truth (`packages/core-domain`)

Agar tidak terjadi duplikasi model Eloquent dan migrasi database di 3 aplikasi Laravel:
1. Model bersama (`User`, `Cargo`, `Fleet`, `TrackingEvent`, `Invoice`) disimpan di `packages/core-domain/src/`.
2. Setiap aplikasi (`customer`, `operator`, `admin`) memuat package ini via path lokal di `composer.json`:
   ```json
   "repositories": [
       {
           "type": "path",
           "url": "../../packages/core-domain"
       }
   ],
   "require": {
       "soracargo/core-domain": "@dev"
   }
   ```
3. Migrasi database cukup dijalankan dari salah satu app (biasanya `admin`) atau script deployment terpusat.

---

## 4. Menjalankan Menggunakan Podman

### Prasyarat:
- Podman & `podman-compose` terinstal di sistem Anda.

### Perintah Operasional:
```bash
# Pindah ke direktori podman
cd podman

# Jalankan seluruh stack (Gateway, 3 Laravel Apps, Database Postgres, Redis)
podman-compose up -d --build

# Cek status container yang sedang berjalan
podman ps

# Menghentikan container
podman-compose down
```

### Konfigurasi Domain Lokal untuk Pengujian:
Tambahkan baris berikut pada `/etc/hosts` di laptop Anda:
```text
127.0.0.1  customer.soracargo.local
127.0.0.1  ops.soracargo.local
127.0.0.1  admin.soracargo.local
```

---

## 5. Hierarki Komunikasi Berjenjang (Email & WhatsApp Gateway)

Platform menerapkan pola **Tiered Support & Operational Escalation (Dukungan Berjenjang)** agar komunikasi terstruktur dan Admin terlindungi dari beban pesan harian:

```text
┌─────────────────┐       (Pertanyaan rute, status kargo, dokumen B/L, komplain)
│    CUSTOMER     │ ─────────────────────────────────────────────────────────────► ┌──────────────────┐
└─────────────────┘                                                                │     OPERATOR     │
                                                                                   │ (Regional Hub /  │
                                                                                   │    Dispatcher)   │
                                                                                   └────────┬─────────┘
                                                                                            │
                                          (Eskalasi kendala kritis, persetujuan biaya,      │
                                           asuransi, legalitas, anomali armada)             │
                                                                                            ▼
                                                                                   ┌──────────────────┐
                                                                                   │   SUPERADMIN     │
                                                                                   │ (Private Laptop) │
                                                                                   └──────────────────┘
```

### Aturan Alur Komunikasi:
1. **Tier 1: Customer $\longrightarrow$ Operator (First Line of Defense)**
   - **Tujuan**: Menangani 90% aktivitas dan pertanyaan rutin harian pelanggan.
   - **Email Gateway**:
     - Email konfirmasi booking, manifest jalan, dan notifikasi posisi kargo dikirim dengan *Reply-To* mengarah ke email **Operator Regional/Cabang** terkait (misal `ops.jkt@soracargo.com` atau `ops.sub@soracargo.com`).
     - Jika Customer membalas email notifikasi atau mengajukan keluhan via form kontak, tiket email masuk ke antrean inbox Operator terkait.
   - **WhatsApp Gateway**:
     - Tombol *Customer Support* di portal Customer mengarahkan chat langsung ke nomor WhatsApp Operator Dispatcher regional.
     - Bot WhatsApp meneruskan pertanyaan status kargo langsung ke sistem operator setempat.
   - **Prinsip**: Customer **tidak pernah** memiliki akses email atau nomor kontak langsung ke Superadmin Global.

2. **Tier 2: Operator $\longrightarrow$ Admin (Escalation & Approvals)**
   - **Tujuan**: Menangani 10% kasus khusus yang membutuhkan wewenang manajerial/finansial tingkat tinggi.
   - **Email Gateway**:
     - Jika terjadi kerusakan kargo berat, keterlambatan cuaca ekstrem, atau sengketa klaim asuransi di atas batas limit wewenang operator, Operator menekan tombol **"Eskalasi Tiket ke Admin"**.
     - Sistem secara otomatis mengirimkan email resmi berisi ringkasan kronologi insiden, dokumen lampiran B/L, dan bukti foto ke email privat Admin (`admin@soracargo.internal`).
   - **WhatsApp Gateway**:
     - Sistem mengirimkan alert darurat prioritas tinggi ke WhatsApp Admin:
       > *"🚨 [ALERT ESKALASI OPS #OPS-402] Armada SRA-TRK-1044 mengalami kendala mesin di Tol Trans-Jawa KM 372. Operator mengajukan pergantian unit dan biaya towing darurat. Butuh approval segera."*
   - **Penyelesaian**: Admin meninjau dari portal privat dan memberikan persetujuan/kebijakan (*Approve/Reject*), lalu sistem mengabari Operator untuk eksekusi ke Customer.

3. **Manajemen Service Gateway (Admin Only)**
   - Seluruh pengelolaan fisik WhatsApp Gateway (pairing session, scan QR code, status koneksi device) dan kredensial SMTP Email Gateway dikelola secara eksklusif dari dashboard **`apps/admin`**.
   - Customer dan Operator hanya bertindak sebagai *consumer* (pemakai layanan kirim pesan) tanpa akses ke konfigurasi server gateway.

---

## 6. Alur Registrasi & Onboarding Akun Operator (Request & Invitation)

Untuk menjamin keamanan data radar kargo dan jadwal armada, **Operator TIDAK memiliki registrasi publik terbuka**. Pendaftaran akun menggunakan alur **Approval & Token Invitation**:

```text
1. REQUEST ACCESS
   Calon Operator mengajukan permohonan akses:
   👉 Mengisi data: Nama, Email Kantor, ID Karyawan, Cabang Wilayah Penugasan.
          │
          ▼
2. REVIEW & APPROVAL OLEH ADMIN
   Superadmin Global meninjau permohonan di dashboard admin:
   👉 Jika valid, Admin klik [Approve & Invite].
          │
          ▼
3. EMAIL GATEWAY MENGIRIM LINK UNDANGAN
   Email Gateway mengirimkan tautan token unik (berlaku 24 jam):
   👉 URL: https://ops.soracargo.com/register/invite?token=xyz123...
          │
          ▼
4. OPERATOR MEMBUKA EMAIL & AKTIVASI MANDIRI
   Operator mengklik link undangan di email:
   👉 Data Identitas (Nama, Email, Wilayah Hub) TERKUNCI (Read-Only).
   👉 Operator hanya mengisi: Password Baru & Verifikasi 2FA (WA OTP / Authenticator App).
          │
          ▼
5. AKUN BERUBAH MENJADI ACTIVE
   - Status akun berubah dari PENDING_INVITATION menjadi ACTIVE.
   - Token undangan langsung dihanguskan (single-use token).
   - Audit log mencatat IP address, waktu aktivasi, dan perangkat kerja operator.
   - Operator langsung diarahkan ke Dashboard Operator sesuai regional hub-nya.
```


