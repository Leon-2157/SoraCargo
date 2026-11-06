# SoraCargo — Customer Portal (Public Facing)

Aplikasi portal pelanggan publik (*Shipper & Consignee*) untuk pemesanan kargo, pelacakan radar armada real-time, perhitungan estimasi tarif otomatis, pengunduhan dokumen legalitas, dan konsultasi logistik interaktif.

---

## 1. Spesifikasi Teknis & Akses Jaringan

- **Tier Keamanan**: **Public Access** (Internet Terbuka, 0.0.0.0/0).
- **Domain Produksi**: `customer.soracargo.com` (atau `soracargo.com`).
- **Domain Pengujian Lokal**: `http://customer.soracargo.local` (Port 8001 via Nginx Gateway).
- **Framework & Runtime**: Laravel 11, PHP 8.3 FPM, Tailwind CSS, Alpine.js / Livewire.
- **Dependencies Bersama**: Mengonsumsi model master dari package `soracargo/core-domain` (Schema database: `public`).

---

## 2. Fitur Utama

1. **Pelacakan Radar Armada (Interactive Cargo Tracking)**:
   - Visualisasi posisi kapal samudra dan truk kontainer menggunakan data koordinat GPS real-time.
   - Integrasi prakiraan cuaca rute maritim via OpenWeather API dan geocoding pelabuhan.
2. **Dashboard Deep Navy Glass Bento Grid**:
   - Tampilan modern bertema maritim dengan rasio kontras tinggi, kartu informasi terfragmentasi (*Bento Grid*), dan *responsive layout*.
3. **Kalkulator Tarif & Pemesanan Kargo**:
   - Estimasi biaya pengiriman multimoda (Darat, Tol Laut, Kontainer Samudra FCL/LCL).
   - Dukungan pembayaran instan via **100% Prepaid Escrow** (Midtrans / Xendit).
4. **Pusat Unduhan Dokumen Legalitas**:
   - Unduh langsung dokumen *Electronic Bill of Lading (e-B/L)*, *Air Waybill (AWB)*, Surat Jalan, dan konfirmasi bukti serah terima digital (*e-POD*).
5. **Dukungan Pelanggan (Tier 1 Support)**:
   - Bot WhatsApp otomatis untuk cek resi 24/7.
   - Tautan langsung (*Deep-link*) ke WhatsApp Dispatcher Regional Hub terkait.
   - Konsultasi asisten AI interaktif (SoraBot) melalui koneksi streaming ke `services/ai-service`.

---

## 3. Struktur Direktori Kunci

```text
apps/customer/
├── app/
│   ├── Http/Controllers/       # Controller publik (Tracking, Booking, Calculator)
│   └── Providers/
├── config/                     # Konfigurasi layanan & API pihak ketiga
├── resources/
│   ├── css/                    # Tailwind CSS custom themes
│   ├── js/                     # Client script & radar canvas handlers
│   └── views/                  # Blade templates (Dashboard, Landing, Tracking)
├── routes/
│   └── web.php                 # Rute publik portal pelanggan
└── README.md
```

---

## 4. Perintah Pengembangan Lokal

```bash
# Instal dependensi PHP & Node
composer install
npm install

# Menjalankan build asset frontend
npm run build     # Mode produksi
npm run dev       # Mode pengawasan hot-reload

# Menjalankan unit & feature testing
php artisan test
```

---

> Referensi arsitektur global dan regulasi operasional: lihat [docs/architecture.md](file:///home/leon/Downloads/SoraCargo/docs/architecture.md) dan [docs/shipping-and-financials.md](file:///home/leon/Downloads/SoraCargo/docs/shipping-and-financials.md).
