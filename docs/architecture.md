# Arsitektur Sistem, Topologi Jaringan & Infrastruktur

Dokumen ini menjelaskan arsitektur monorepo, isolasi aplikasi, segmentasi keamanan jaringan, serta orkestrasi infrastruktur Podman dan Oracle Cloud Infrastructure (OCI).

---

## 1. Topologi Jaringan & Segmentasi Keamanan

SoraCargo menerapkan prinsip **Network Segmentation & Defense in Depth** dengan membagi akses menjadi 3 tingkatan keamanan (*tiers*):

```text
[ INTERNET PUBLIK ] ──────► customer.soracargo.com ──► apps/customer (Port 8001)
                            (Semua Pengguna Publik)

[ REGIONAL VPN ]    ──────► ops-id.soracargo.com   ──► apps/operator (Port 8002)
                            (Hanya IP Gateway VPN Negara/Cabang Terdaftar)

[ STRICTLY PRIVATE ] ─────► admin.soracargo.internal ─► apps/admin   (Port 8003)
                            (Hanya IP Laptop Developer / Private WireGuard Mesh)
                                    │
                                    ▼
                         [ DATABASE TERPUSAT ]
                         (PostgreSQL 16 & Redis)
```

### Tabel Rincian Akses:

| Aplikasi | Tier Keamanan | Target Pengguna | Karakteristik Akses |
| :--- | :--- | :--- | :--- |
| **`apps/customer`** | **Public** | Pelanggan / Shipper | Akses internet umum tanpa VPN. Tracking radar armada, cek tarif kalkulator, AI copilot, dan unduh dokumen B/L. |
| **`apps/operator`** | **Semi-Private** | Tim Dispatcher / Lapangan | Wajib terhubung ke VPN gateway regional (ID, SG, MY). Akses input manifest, koordinasi supir/nahkoda, update status bongkar muat. |
| **`apps/admin`** | **Strictly Private** | Superadmin Global | Terisolasi 100% dari internet publik. Akses hanya melalui IP laptop terdaftar via Tailscale/WireGuard atau SSH Tunnel. |

---

## 2. Struktur Monorepo Direktori

```text
SoraCargo/
├── apps/
│   ├── customer/            # Laravel App: Portal Pelanggan Publik
│   ├── operator/            # Laravel App: Dispatcher Armada (VPN Regional)
│   └── admin/               # Laravel App: Superadmin Global (Private Laptop)
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
├── docs/                    # Dokumentasi Teknis & Panduan Bisnis
└── README.md                # Ringkasan Eksekutif & Hub Proyek
```

---

## 3. Strategi Single Source of Truth (`packages/core-domain`) & Multi-Schema

Untuk mencegah duplikasi kode Model Eloquent, Enums status, dan migrasi database di ketiga aplikasi Laravel:
1. Seluruh definisi entitas bersama (`User`, `Cargo`, `Fleet`, `TrackingEvent`, `Invoice`, `EscalationTicket`) disimpan terpusat di `packages/core-domain/src/`.
2. Setiap aplikasi (`apps/customer`, `apps/operator`, `apps/admin`) memuat package ini secara lokal via Composer path:
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
3. **Struktur 3 Folder Migrasi Database Multi-Schema**:
   Migrasi database dipisahkan secara modular ke dalam 3 folder schema mandiri:
   ```text
   packages/core-domain/database/migrations/
   ├── public/   ──► Tabel Master: users, cargo_master, tracking_events, ports, tariffs
   ├── ops/      ──► Tabel Operasional: manifests, driver_assignments, fleet_telemetry, e_pod
   └── admin/    ──► Tabel Governance: operator_invitations, escrow_ledgers, revenue_splits
   ```
   Dijalankan melalui Artisan runner terpadu: `php artisan sora:migrate --schema=all` atau secara terisolasi per schema.

4. **Isolasi Sesi Pengguna Berbasis Redis (Per-App Redis Session)**:
   Mencegah pembobolan lintas portal dengan memisahkan prefix kunci dan cookie sesi:
   - `apps/customer`: Cookie `soracargo_cust_session`, Prefix Redis `cust_session:`
   - `apps/operator`: Cookie `soracargo_ops_session`, Prefix Redis `ops_session:`
   - `apps/admin`: Cookie `soracargo_admin_session`, Prefix Redis `admin_session:`

5. **Komunikasi Asinkron: Redis Queue & Pub/Sub**:
   Seluruh kejadian lintas aplikasi (pemesanan baru, alert keterlambatan, pengiriman pesan WhatsApp Gateway, eskalasi darurat) diproses melalui antrean terpusat di Redis Worker tanpa membebani thread request HTTP pengguna.

6. **Telemetri Pelacakan Otomatis via IoT Webhook**:
   - Pembaruan radar kargo menggunakan perangkat sensor GPS hardware kapal dan truk (*IoT Telemetry*).
   - Sensor mem-push data koordinat (latitude, longitude, speed knot/kmh, bearing) secara periodik setiap 5–15 menit ke endpoint internal `/api/v1/telemetry/iot`.
   - Data disimpan ke `ops.fleet_telemetry` dan otomatis memicu kalkulasi ulang ETA secara real-time.

---

## 4. Orkestrasi Podman & Lingkungan OCI (Oracle Cloud Infrastructure)

### Spesifikasi Hosting OCI:
- **Compute Instance**: OCI Ampere A1 (ARM64, 4 OCPU, 24 GB RAM — Always Free tier).
- **DNS & SSL**: Cloudflare DNS di depan IP publik OCI untuk proteksi DDoS dan sertifikat SSL otomatis.
- **Port Security**:
  - Port `80` dan `443` diarahkan ke container `soracargo-gateway` (Nginx).
  - Port database PostgreSQL dan Redis **TIDAK** diekspos ke publik (`internal: true`).
  - Port WhatsApp Gateway (`3000`) dan AI Service (`5000`) hanya berada di bridge network internal Podman.

### Jaringan Podman (`podman-compose.yml`):
- **`sora-network`**: Jaringan komunikasi antara web gateway Nginx dan aplikasi PHP-FPM.
- **`sora-db-network`**: Jaringan internal tertutup khusus untuk koneksi aplikasi ke database PostgreSQL dan Redis.

---

## 5. Strategi Domain Tunggal & Routing Subdomain

Pengembang **tidak perlu membeli domain terpisah** untuk setiap portal aplikasi. Seluruh ekosistem beroperasi di bawah **1 Domain Utama** menggunakan skema routing subdomain:

```text
                               ┌────────────────────────────────┐
                               │  1 DOMAIN UTAMA: soracargo.com │
                               │  (Cloudflare DNS & Proxy CDN)  │
                               └───────────────┬────────────────┘
                                               │
                 ┌─────────────────────────────┼─────────────────────────────┐
                 ▼                             ▼                             ▼
       customer.soracargo.com          ops.soracargo.com             admin.soracargo.internal
        (atau soracargo.com)          (atau ops-id/sg/my)           (atau admin.soracargo.com)
                 │                             │                             │
                 ▼                             ▼                             ▼
         [ INTERNET PUBLIK ]          [ REGIONAL VPN / IP ]        [ STRICT MESH WIREGUARD ]
                 │                             │                             │
                 └─────────────────────────────┼─────────────────────────────┘
                                               ▼
                              [ NGINX GATEWAY (Port 80/443) ]
```

### Konfigurasi & Manfaat:
- **Biaya Efisien**: Cukup menyewa 1 domain pertahun (~Rp 150.000 - Rp 200.000/tahun).
- **Wildcard SSL Gratis**: Satu sertifikat SSL `*.soracargo.com` dari Let's Encrypt / Cloudflare otomatis mengamankan seluruh subdomain.
- **Isolasi Lingkungan**: Subdomain operasional dan admin diproteksi pada layer DNS/WAF (Cloudflare Access / IP Whitelist) sebelum mencapai server OCI.

---

## 6. Struktur & Alokasi Aset (Assets Architecture)

SoraCargo memisahkan aset kode statis frontend dari berkas unggahan pengguna (*User Uploads / Media*):

```text
SoraCargo Asset Architecture
│
├── A. ASET KODE FRONTEND (Terisolasi per Aplikasi - Vite & Tailwind)
│   ├── apps/customer/resources/   ──► Bundle JS/CSS Publik: Radar canvas, Bento Grid, animasi landing, kalkulator.
│   ├── apps/operator/resources/   ──► Bundle JS/CSS Lapangan: Grid manifest padat, scanner QR/Kamera, form cepat.
│   └── apps/admin/resources/      ──► Bundle JS/CSS Admin: Chart analitik revenue, audit viewer, QR pairing Baileys.
│
└── B. ASET MEDIA & DOKUMEN UNGGAHAN (Penyimpanan Terpusat / Shared Storage)
    └── storage/ (Volume Persisten OCI / S3-Compatible Object Storage)
        ├── /documents/bl/         ──► Berkas Master/House Bill of Lading & Surat Jalan (Akses: Shipper & Operator)
        ├── /inspections/bap/      ──► Foto kargo rusak & Berita Acara Kerusakan (Akses: Operator & Admin)
        ├── /epod/                 ──► Foto serah terima barang & tanda tangan digital penerima
        └── /corporate/kyc/        ──► Dokumen NIB & NPWP legalitas shipper B2B (Akses: Admin Only)
```

- **Frontend Lean Bundles**: Portal pelanggan tidak terbebani pustaka JS berat milik admin (misal pustaka grafik atau scanner QR), sehingga kecepatan loading (*First Contentful Paint*) tetap optimal.
- **Shared Document Visibility**: Foto e-POD atau BAP kerusakan yang diunggah dari lapangan (`apps/operator`) dapat langsung diverifikasi oleh Superadmin di `apps/admin` dan dipantau oleh pelanggan di `apps/customer`.

---

## 7. Profil Alokasi Sumber Daya OCI (Memory & Compute Footprint)

Server OCI Always Free Tier menyediakan **4 OCPU ARM64 dan 24 GB RAM**. Seluruh stack SoraCargo beroperasi dalam 1 VM dengan konsumsi sumber daya yang sangat efisien:

| Layanan / Container | Basis Runtime | Estimasi Penggunaan RAM | Peran dalam Sistem |
| :--- | :--- | :---: | :--- |
| **`soracargo-gateway`** | Nginx Alpine | ~30 – 50 MB | Reverse Proxy, SSL Termination, & IP Whitelisting. |
| **`soracargo-customer`** | PHP-FPM 8.3 | ~128 – 256 MB | Portal Pelanggan Publik & Tracking Radar. |
| **`soracargo-operator`** | PHP-FPM 8.3 | ~128 – 256 MB | Portal Dispatcher & Operasional Hub Lapangan. |
| **`soracargo-admin`** | PHP-FPM 8.3 | ~128 – 256 MB | Portal Superadmin Global & Financial Ledger. |
| **`soracargo-db`** | PostgreSQL 16 | ~512 – 1024 MB | Database Multi-Schema (`public`, `ops`, `admin`). |
| **`soracargo-redis`** | Redis Alpine | ~64 – 128 MB | Cache, Session Store, & Queue Workers. |
| **`wa-gateway`** | Node.js (Baileys) | ~250 – 400 MB | WhatsApp Socket, QR Pairing, & Message Webhooks. |
| **`ai-service`** | Python / Node.js | ~300 – 500 MB | Streaming SSE Copilot & Automated Manifest Summarizer. |
| **Sistem Operasi (Host)**| Oracle Linux 9 / Fedora | ~500 MB | Linux Kernel, Podman daemon, & system background tasks. |
| **TOTAL ESTIMASI** | | **~2.2 – 3.5 GB** | **Sisa RAM Bebas: ~20+ GB (Sangat Lega & Tahan Beban Puncak)** |

---

## 8. Katalog 6 Pilar Fitur Superadmin (`apps/admin`)

Portal Superadmin berfungsi sebagai menara pengawas (*Cockpit Control*) dengan 6 Kategori Accordion dan 19 Sub-menu terintegrasi:

1. **📊 DASBOR** (Analitik & Monitoring Eksekutif):
   - **Dasbor Utama**: Ringkasan KPI harian, total volume kargo, pendapatan bersih, dan peringatan eskalasi.
   - **Dasbor Lapangan**: Monitoring utilisasi kontainer CY, status bersandar armada kapal, dan armada truk aktif.
   - **Dasbor Keuangan**: Arus kas harian, saldo rekening bersama mengendap, dan invoice jatuh tempo.
2. **🚢 OPERASIONAL** (Manajemen Perjalanan & Insiden):
   - **Daftar Booking & Pesanan**: Antrean pesanan pengiriman baru dari shipper sebelum armada diberangkatkan.
   - **Pelacakan & Manifes**: Radar satelit pergerakan kapal/truk darat dan data muatan kontainer aktif.
   - **Manajemen Operator**: Tata kelola akun mitra operator hub, perizinan 2FA, dan tombol penerbitan token undangan.
   - **Pusat Darurat & Kendala**: Approval biaya tak terduga (tugboat/crane), klaim asuransi BAP, dan penalti tiket SLA breach.
3. **👥 PELANGGAN** (Buku Klien & Manajemen Risiko):
   - **Pelanggan Retail**: Direktori pengirim perorangan/UMKM dengan skema 100% Prepaid Escrow & filter sanksi akun.
   - **Mitra Perusahaan B2B**: Verifikasi legalitas KYC (NIB/NPWP), evaluasi skor kredit, dan penetapan plafon TOP 30–60 hari.
4. **💳 KEUANGAN** (Arus Kas, Transaksi & Pajak):
   - **Rekening Bersama**: Rekening penampung escrow, milestone release pencairan bertahap, dan margin platform.
   - **Faktur & Penagihan**: Tagihan berjangka B2B, penalti keterlambatan, dan rekonsiliasi kas pelunasan.
   - **Pusat Laporan & Pajak**: Unduh rekap akuntansi bulanan, laporan laba rugi rute, dan faktur pajak PPN/PPh ekspedisi.
5. **📦 LOGISTIK** (Master Wilayah, Tarif & Regulasi):
   - **Tarif & Rute Ekspedisi**: Master ongkos kirim multimoda (darat/laut/udara) dan surcharge kargo khusus (DG/Reefer).
   - **Pelabuhan & Depo**: Master titik simpul pelabuhan nasional/internasional, gudang transit, dan kapasitas CY.
   - **Kamus Barang & Cukai**: Klasifikasi 8 digit HS Code pabean, ketentuan pembatasan Lartas, dan matriks bea masuk.
6. **⚙️ SISTEM** (Infrastruktur, Tim & Keamanan):
   - **Kelola Staf & Hak Akses**: Manajemen akun internal admin kantor pusat dan pembagian wewenang role RBAC.
   - **Gerbang Pesan & Email**: Pemindaian QR multi-device Baileys WhatsApp dan konfigurasi server mail SMTP.
   - **Pengaturan Mesin AI**: Monitoring kuota token LLM (Gemini/OpenAI) dan kalibrasi prompt asisten SoraBot.
   - **Catatan Aktivitas**: Rekaman log forensik permanen (*Immutable Audit Trail*) seluruh mutasi data dan aksi admin.

---

## 9. Arsitektur Tata Kelola Pelanggan (Customer Management: Retail vs. Corporate B2B)

Superadmin memegang kendali penuh atas manajemen risiko dan tata kelola akun pengirim kargo (*Shipper / Consignee*):

```text
                                TATA KELOLA CUSTOMER
                                         │
                 ┌───────────────────────┴───────────────────────┐
                 ▼                                               ▼
       PELANGGAN RETAIL / UMKM                         MITRA CORPORATE (B2B)
     • Registrasi publik instan                      • Registrasi publik -> Submit Dokumen Legalitas
     • Transaksi 100% Prepaid Escrow                 • Wajib Verifikasi KYC Superadmin (NIB & NPWP)
     • Status: ACTIVE, BOOKING_LOCKED, BLACKLISTED   • Penetapan Plafon Kredit & Hari Tempo (TOP)
     • Akses: LCL, Kargo Eceran, Truk Reguler        • Akses: Petikemas FCL Samudra & Tarif Kontrak
```

### Isolasi Data Multi-Schema:
1. **Schema `public`**: Menyimpan identitas akun pengguna di `public.users` dan data legalitas umum perusahaan di `public.companies` (Nama PT/CV, NIB, NPWP, Alamat Kantor).
2. **Schema `admin`**: Menyimpan data sensitif finansial di `admin.corporate_credits` (Batas Plafon Kredit, Sisa Saldo Kredit, Status Verifikasi B2B, Termin Hari TOP, Dokumen Bank Garansi, Catatan Audit Scoring). Data ini terlindungi 100% dan tidak dapat dibaca dari portal publik.

### 3 Tingkat Status Sanksi Akun:
- **`ACTIVE`**: Akun normal dengan hak akses penuh sesuai klasifikasi (Retail atau Verified B2B).
- **`BOOKING_LOCKED`**: Status pembekuan sementara (misal invoice tempo melewati jatuh tempo atau ada sengketa kargo). Pelanggan **dilarang membuat booking baru**, namun masih dapat melacak kargo yang sedang berlayar dan melakukan pembayaran tagihan.
- **`BLACKLISTED`**: Status pemutusan akses total permanen akibat kecurangan (*fraud*), penyelundupan barang terlarang, atau gagal bayar kronis. NIB, NPWP, dan IP perusahaan masuk daftar hitam sistem.



