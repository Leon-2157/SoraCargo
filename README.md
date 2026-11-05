# SoraCargo — Enterprise Maritime & Multimodal Logistics Platform

Platform manajemen logistik kargo maritim dan multimoda terintegrasi berbasis **Laravel Monorepo**, dirancang dengan pemisahan aplikasi mandiri (*multi-app isolation*), segmentasi jaringan tingkat enterprise (*Public*, *Semi-Private Regional VPN*, dan *Strictly Private Admin*), serta orkestrasi container berbasis **Podman**.

---

## 1. Topologi Jaringan & Tingkatan Akses Keamanan

SoraCargo menerapkan prinsip *Defense in Depth* dan isolasi jaringan ketat:

```text
[ INTERNET PUBLIK ] ──────► customer.soracargo.com ──► apps/customer (Port 8001)
                            (Semua Pengguna Publik / Shipper)

[ REGIONAL VPN ]    ──────► ops-id.soracargo.com   ──► apps/operator (Port 8002)
                            (Hanya IP Gateway VPN Cabang: ID, SG, MY)

[ STRICTLY PRIVATE ] ─────► admin.soracargo.internal ─► apps/admin   (Port 8003)
                            (Hanya IP Laptop Developer / Private WireGuard Mesh)
                                    │
                                    ▼
                         [ DATABASE TERPUSAT ]
                         (PostgreSQL 16 & Redis)
```

| Aplikasi | Tier Keamanan | Target Pengguna | Karakteristik Akses |
| :--- | :--- | :--- | :--- |
| **`apps/customer`** | **Public** | Pelanggan / Shipper | Akses internet umum tanpa VPN. Tracking radar armada, kalkulator tarif real-time, AI copilot, dan unduh dokumen B/L. |
| **`apps/operator`** | **Semi-Private** | Tim Dispatcher / Lapangan | Wajib terhubung ke VPN gateway regional (ID, SG, MY). Input manifest kargo, koordinasi supir/nahkoda, update status bongkar muat. |
| **`apps/admin`** | **Strictly Private** | Superadmin Global | Terisolasi 100% dari internet publik. Akses hanya melalui IP laptop terdaftar via WireGuard/Tailscale atau SSH Tunnel. |

---

## 2. Struktur Direktori Monorepo

```text
SoraCargo/
├── apps/
│   ├── customer/            # Laravel App: Portal Pelanggan Publik (Port 8001)
│   ├── operator/            # Laravel App: Dispatcher Armada (VPN Regional, Port 8002)
│   └── admin/               # Laravel App: Superadmin Global (Private Laptop, Port 8003)
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
├── docs/                    # Pusat Dokumentasi Arsitektur & Bisnis
│   ├── architecture.md
│   ├── operator-lifecycle.md
│   ├── communication-flow.md
│   └── shipping-and-financials.md
│
└── README.md                # Ringkasan Eksekutif & Hub Proyek
```

---

## 3. Pusat Dokumentasi Teknis & Operasional (`docs/`)

Dokumentasi arsitektur dan proses bisnis disusun secara modular:

| Dokumen | Rangkuman Isi | Tautan Langsung |
| :--- | :--- | :--- |
| **Arsitektur & Infrastruktur** | Segmentasi jaringan 3-tier, spesifikasi Podman & Oracle Cloud Infrastructure (OCI Ampere A1), single source of truth `core-domain`. | [docs/architecture.md](file:///home/leon/Downloads/SoraCargo/docs/architecture.md) |
| **Siklus Hidup Operator** | Tata kelola akun operator (*Zero Public Registration*), alur undangan token 24 jam, pemisahan peran (*Domestic* vs. *International*), setup 2FA, dan kendali Superadmin. | [docs/operator-lifecycle.md](file:///home/leon/Downloads/SoraCargo/docs/operator-lifecycle.md) |
| **Alur Komunikasi & Gateway** | Dukungan berjenjang (*Tiered Support*), perutean WhatsApp & Email Gateway, integrasi Baileys, serta studi kasus nyata (Badai Selat Madura & Kargo Rusak Air Asin). | [docs/communication-flow.md](file:///home/leon/Downloads/SoraCargo/docs/communication-flow.md) |
| **Pengiriman & Finansial** | Alur kargo Domestik vs. Internasional (PEB/PIB, HS Code, Incoterms, Jalur Merah/Hijau Bea Cukai), matriks bagi hasil (*Revenue Split*), dan sistem *Milestone Escrow*. | [docs/shipping-and-financials.md](file:///home/leon/Downloads/SoraCargo/docs/shipping-and-financials.md) |

---

## 4. Panduan Menjalankan Lingkungan (Podman)

### Prasyarat:
- Linux / macOS dengan **Podman** dan **podman-compose** terinstal.
- PHP 8.3+ dan Composer 2.7+ (untuk pengembangan lokal non-container).

### Menjalankan Seluruh Stack:
```bash
# 1. Pindah ke direktori podman
cd podman

# 2. Jalankan seluruh container di background
podman-compose up -d --build

# 3. Periksa status kontainer aktif
podman ps
```

### Konfigurasi Domain Pengujian Lokal (`/etc/hosts`):
Tambahkan baris berikut pada berkas `/etc/hosts` perangkat Anda untuk mengakses ketiga portal:
```text
127.0.0.1  customer.soracargo.local
127.0.0.1  ops.soracargo.local
127.0.0.1  admin.soracargo.local
```

### Port Mapping Default:
- `http://customer.soracargo.local` $\rightarrow$ Nginx Proxy $\rightarrow$ `apps/customer:8001`
- `http://ops.soracargo.local` $\rightarrow$ Nginx Proxy $\rightarrow$ `apps/operator:8002` (Simulasi IP Whitelist)
- `http://admin.soracargo.local` $\rightarrow$ Nginx Proxy $\rightarrow$ `apps/admin:8003` (Simulasi IP Whitelist)
- PostgreSQL: Port `5432` (Internal Bridge)
- Redis Cache: Port `6379` (Internal Bridge)

---

## 5. Ringkasan Fitur Unggulan

- **Radar Tracking Interaktif**: Visualisasi posisi kapal kontainer samudra dan armada truk darat dengan koordinat GPS real-time.
- **Deep Navy Glass Bento Grid**: Antarmuka modern dengan kontras tinggi, navigasi intuitif, dan responsif untuk pengirim (*shipper*).
- **Single Source of Truth (`packages/core-domain`)**: Satu basis kode untuk model database, status kargo, validasi DTO, dan event business logic di ketiga portal.
- **Milestone Escrow Protection**: Menjamin transparansi alokasi pembayaran bagi Admin (10-15%), Operator (60-80%), dan Pajak/Regulasi (5-25%).
