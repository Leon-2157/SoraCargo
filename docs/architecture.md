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

## 3. Strategi Single Source of Truth (`packages/core-domain`)

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
3. Migrasi database dan database seeder dijalankan secara terpusat oleh aplikasi admin atau automated deployment script.

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

