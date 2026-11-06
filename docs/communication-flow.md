# Hierarki Komunikasi Berjenjang (Communication Flow & Gateway Integration)

Dokumen ini menjelaskan arsitektur komunikasi berjenjang (*Tiered Escalation*), perutean pesan melalui WhatsApp Gateway dan Email Gateway, serta penanganan insiden operasional di SoraCargo.

---

## 1. Prinsip Dukungan Berjenjang (Tiered Support)

Dalam industri logistik maritim dan kargo terpadu, saluran komunikasi yang tidak terkelola dengan baik dapat menyebabkan kepanikan pelanggan, informasi simpang siur, dan kelelahan manajerial (*managerial fatigue*).

SoraCargo menerapkan arsitektur **Tiered Support & Operational Escalation**:

```mermaid
graph TD
    subgraph TIER_1["TIER 1: FIRST LINE OF DEFENSE (90% Interaksi)"]
        Customer["👤 CUSTOMER / SHIPPER<br/>(Portal Publik)"]
        Operator["👷 OPERATOR REGIONAL<br/>(Dispatcher Pelabuhan & Hub)"]
        Customer <-->|"WhatsApp Chat & Email Reply-To<br/>(Status Armada, Jadwal Sandar, Dokumen B/L)"| Operator
    end

    subgraph TIER_2["TIER 2: ESCALATION & GOVERNANCE (10% Interaksi)"]
        Admin["👑 SUPERADMIN GLOBAL<br/>(Private Dashboard)"]
        Operator -->|"Eskalasi Tiket Kritis, Klaim Asuransi,<br/>Persetujuan Biaya Darurat & Legalitas"| Admin
        Admin -.->|"Approval / Instruksi Kebijakan"| Operator
    end

    classDef customer fill:#0f172a,stroke:#38bdf8,stroke-width:2px,color:#f8fafc;
    classDef operator fill:#1e293b,stroke:#06b6d4,stroke-width:2px,color:#f8fafc;
    classDef admin fill:#020617,stroke:#6366f1,stroke-width:2px,color:#f8fafc;
    class Customer customer;
    class Operator operator;
    class Admin admin;
```

### Aturan Emas Komunikasi:
1. **Pelanggan Tidak Pernah Berhubungan Langsung dengan Superadmin**: Seluruh interaksi awal, pelacakan rute, dan pertanyaan operasional diselesaikan oleh Operator Regional setempat.
2. **Eskalasi Terstruktur Berbasis Bukti**: Operator hanya meneruskan masalah ke Superadmin jika melewati batas kewenangan finansial (misal biaya darurat > Rp 10.000.000), sengketa hukum, atau anomali keselamatan armada.
3. **Pusat Kontrol Gateway Terisolasi**: Konfigurasi teknis WhatsApp Gateway (sesi perangkat, scan QR) dan SMTP Email Gateway dikelola eksklusif oleh Superadmin dari `apps/admin`.

---

## 2. Alur Gateway: WhatsApp & Email

### A. WhatsApp Gateway Routing
Platform menggunakan microservice in-house `services/wa-gateway` (berbasis Node.js & Baileys):

| Aksi | Titik Sentuh Pelanggan | Perutean Sistem | Penerima Akhir |
| :--- | :--- | :--- | :--- |
| **Tracking Otomatis** | Kirim nomor resi / B/L ke nomor bot WA. | Bot WA menanyakan status ke API internal Core Domain dan membalas posisi radar terakhir. | Customer (Automated Bot Response). |
| **Bantuan Dispatcher** | Klik tombol *"Hubungi Operator Hub"* di web dashboard. | Sistem mengarahkan *deep-link* WA (`https://wa.me/...`) langsung ke nomor WhatsApp resmi Dispatcher Regional sesuai pelabuhan asal muat. | Operator Regional setempat. |
| **Notifikasi Kargo Siap Ambil** | Kargo tiba di depo tujuan (*Ready for Pick-Up*). | Trigger event `CargoArrivedAtDestination`: Gateway mengirimkan pesan otomatis berisi PIN Pengambilan dan QR Code. | Customer. |
| **Alert Kritis ke Admin** | Operator menekan tombol *"Eskalasi ke Admin"* di portal `apps/operator`. | Gateway mengirimkan template pesan darurat prioritas tinggi ke nomor privat Superadmin. | Superadmin Global. |

### B. Email Gateway Routing
Setiap notifikasi email yang keluar dari SoraCargo memiliki konfigurasi *Header* cerdas:
- **`From`**: `SoraCargo Logistics <no-reply@soracargo.com>` (untuk pengumuman blast atau autentikasi).
- **`Reply-To` Dinamis**: Disesuaikan dengan Hub tempat kargo ditangani.
  - Kargo diberangkatkan dari Pelabuhan Tanjung Priok: `ops.jkt@soracargo.com`.
  - Kargo diberangkatkan dari Pelabuhan Tanjung Perak: `ops.sub@soracargo.com`.
  - Kargo ekspor internasional Singapura: `ops.sin@soracargo.com`.
- **Hasil**: Ketika pelanggan mengklik *Reply* pada email notifikasi resi mereka, email balasan otomatis masuk ke antrean inbox Operator Regional terkait, bukan ke inbox developer atau Superadmin.

---

## 3. Standar SLA Respons Operator & Auto-Escalation Tiket

Untuk memastikan kualitas layanan pelanggan (*Service Level Agreement*) dan mencegah keluhan tertahan tanpa kepastian, SoraCargo memberlakukan automasi pemantauan waktu respons:

```mermaid
flowchart LR
    A["0 - 30 Detik<br/>Bot Auto-Reply<br/>(Radar Status)"] --> B["5 - 15 Menit<br/>SLA Staf Operator<br/>(Claim & Chat Manual)"]
    B --> C["Menit ke-16<br/>⚠️ Peringatan Internal<br/>(Bot Alert ke Grup Cabang)"]
    C --> D["Menit ke-31 - 60<br/>Level 2: Eskalasi<br/>(Pimpinan Cabang Hub)"]
    D --> E["> 60 Menit<br/>🚨 Level 3: Superadmin<br/>(Penalti KPI & Intervensi)"]

    classDef normal fill:#0f172a,stroke:#38bdf8,stroke-width:2px,color:#f8fafc;
    classDef warn fill:#451a03,stroke:#f59e0b,stroke-width:2px,color:#fef3c7;
    classDef alert fill:#450a0a,stroke:#ef4444,stroke-width:2px,color:#fef2f2;
    class A,B normal;
    class C,D warn;
    class E alert;
```

### Rincian Tingkatan SLA:
1. **0 – 30 Detik (Automated Instant Bot)**:
   - Bot WhatsApp langsung menyapa nama shipper dan menampilkan data radar GPS kargo terakhir dari schema database `ops`.
2. **5 – 15 Menit (SLA Staf Operator - Jam Operasional)**:
   - Staf dispatcher yang bertugas wajib mengambil alih percakapan (*Claim Ticket*) dan membalas pesan teknis shipper secara personal.
3. **Menit ke-16 (Peringatan Otomatis Antar-Staf)**:
   - Jika dalam 15 menit belum ada balasan manual, bot internal mengirim alert ke grup koordinasi regional hub:
     > *"⚠️ [REMINDER SLA] Shipper PT Maju Jaya (Resi: SRA-JKT-8821) telah menunggu 15 menit tanpa respons di Hub Tanjung Priok. Harap operator bertugas segera merespons."*
4. **Menit ke-31 – 60 (Eskalasi Level 2: Branch Manager)**:
   - Status tiket berubah menjadi `ESCALATED_TO_BRANCH_LEAD`. Notifikasi dikirim ke supervisor pelabuhan untuk reposisi penugasan operator.
5. **> 60 Menit (Eskalasi Level 3: Superadmin Global)**:
   - Tiket otomatis melompat ke dashboard `apps/admin` dengan label darurat: `SLA_BREACH_CRITICAL`.
   - Sistem mencatat penalti performa (KPI Score) pada log operator yang bertugas pada shift tersebut.
   - Superadmin dapat langsung membaca transkrip chat, menugaskan ulang ke operator cadangan, atau mengambil langkah korektif langsung.

---

## 4. Skenario Operasional Nyata (Real-World Case Studies)

Untuk menggambarkan bagaimana sistem beroperasi di bawah tekanan operasional nyata, berikut adalah 2 studi kasus konkret:

### Skenario 1: Cuaca Ekstrem Selat Madura & Permohonan Biaya Sewa Tugboat Darurat

```mermaid
sequenceDiagram
    autonumber
    actor Cust as Customer (Shipper)
    actor Ops as Operator Hub Tanjung Perak
    actor Admin as Superadmin Global
    participant Sys as SoraCargo Core & WA Gateway

    Note over Cust,Ops: 1. Status Kargo Berubah Karena Force Majeure
    Sys-->>Cust: Notifikasi Otomatis: "Kapal Tertahan Badai di Selat Madura"
    Cust->>Ops: Chat WA: "Kenapa kontainer kami belum sandar? Jadwal pabrik kami terganggu!"
    Ops-->>Cust: Respons Profesional: Menjelaskan maklumat Syahbandar & keselamatan muatan
    
    Note over Ops,Admin: 2. Kebutuhan Sewa Tugboat Darurat (Rp 35.000.000)
    Ops->>Sys: Buat Tiket Eskalasi di apps/operator: Kategori DARURAT_OPERASIONAL
    Sys->>Admin: 🚨 WA Alert: "Armada SRA-B12 butuh asistensi tugboat darurat di Karang Jamuang"
    Admin->>Sys: Akses apps/admin -> Review Dokumen Cuaca & Penawaran Vendor -> KLIK APPROVE
    Sys-->>Ops: Notifikasi: "Persetujuan Dana Sewa Tugboat Diterbitkan (PO-78821)"
    
    Note over Ops,Cust: 3. Eksekusi Lapangan & Update ke Shipper
    Ops->>Ops: Instruksikan Tugboat Bergerak Menjemput Tongkang
    Ops->>Cust: Kirim Update: "Kapal telah dikawal tugboat, estimasi sandar 3 jam lagi."
```

#### Protokol Penerapan Status WEATHER_HOLD:
Sistem menerapkan mekanisme ganda (*Hybrid Advisory & Legal Trigger*):
1. **Marine Weather API Advisory (Otomatis)**: Layanan cuaca internal mendeteksi gelombang tinggi > 2.5 meter atau angin kencang di rute pelayaran, lalu menandai rute pada peta radar dengan visual *High Wave Advisory* (Peringatan Kuning).
2. **Otorisasi Legal Syahbandar (Manual Trigger)**: Status kargo tidak langsung dibatalkan secara sepihak oleh AI/sensor. Operator regional mengaktifkan status resmi **`WEATHER_HOLD`** setelah Kantor Kesyahbandaran dan Otoritas Pelabuhan (KSOP) setempat menerbitkan Maklumat Penundaan Surat Persetujuan Berlayar (SPB Hold).
3. **Automasi Broadcast Shipper**: Saat `WEATHER_HOLD` diaktifkan operator, antrean pesan WhatsApp dan email otomatis mengirimkan tautan resmi maklumat Syahbandar kepada seluruh *consignee/shipper* yang muatannya berada di kapal tersebut.

#### Kronologi Langkah:
1. **Deteksi & Notifikasi**: Gelombang tinggi 3.5 meter di Selat Madura memaksa Syahbandar menerbitkan surat penundaan berlayar (SPB Hold). Status kargo otomatis berubah menjadi `WEATHER_HOLD` di portal customer.
2. **Interaksi Customer - Operator (Tier 1)**: Customer bertanya melalui chat WA ke Operator Hub Tanjung Perak. Operator memberikan informasi resmi BMKG tanpa melibatkan Admin.
3. **Kebutuhan Biaya Darurat**: Nahkoda kapal menginformasikan bahwa tongkang membutuhkan pengawalan kapal tunda (*tugboat*) darurat untuk bermanuver menghindari karang dengan biaya sewa Rp 35.000.000. Batas wewenang operator hanya Rp 10.000.000.
4. **Eskalasi ke Admin (Tier 2)**: Operator menekan tombol **"Eskalasi ke Superadmin"** di dashboard operator, melampirkan surat Syahbandar dan invoice proforma tugboat.
5. **Alert WA Instan**: WhatsApp Gateway mengirimkan pesan berprioritas ke Superadmin:
   > *"🚨 [ALERT ESKALASI OPS #TUG-201] Hub Tj. Perak membutuhkan persetujuan sewa Tugboat darurat Rp 35.000.000 untuk Armada SRA-B12 di Selat Madura demi menghindari risiko hanyut. Segera lakukan review di admin portal."*
6. **Keputusan Admin**: Admin membuka `apps/admin`, meninjau dokumen, dan mengklik **Approve Biaya**.
7. **Penyelesaian**: Operator menerima notifikasi dana disetujui, memesan tugboat, tongkang sandar dengan aman, dan customer menerima kabar pembaruan tanpa friksi.

---

### Skenario 2: Kargo Basah Terpapar Air Laut & Klaim Asuransi Maritim (Jakarta – Batam)

```mermaid
sequenceDiagram
    autonumber
    actor Ops as Operator Hub Batam (Batu Ampar)
    actor Cust as Penerima Barang (Consignee)
    actor Admin as Superadmin Global
    participant Sys as SoraCargo Core Domain
    actor Ins as Tim Surveyor Asuransi Maritim

    Note over Ops,Cust: 1. Penemuan Kerusakan Saat Bongkar Muat (De-vanning)
    Ops->>Ops: Pemeriksaan Pintu Kontainer: Ditemukan segel rusak dan rembesan air asin
    Ops->>Sys: Catat Berita Acara Kerusakan (BAP), Upload Foto & GPS Tag
    Sys-->>Cust: Notifikasi Insiden: "Kargo Tiba dengan Catatan Kerusakan Parsial (BAP Terlampir)"
    Cust->>Ops: Mengajukan Klaim Ganti Rugi Kerusakan Komponen Elektronik

    Note over Ops,Admin: 2. Eskalasi Klaim Asuransi Bernilai Tinggi (> Rp 150.000.000)
    Ops->>Sys: Submit Tiket Klaim Asuransi ke apps/admin (Kategori MARITIME_CLAIM)
    Sys-->>Admin: Alert Prioritas di Dashboard Superadmin
    Admin->>Ins: Forward Berita Acara & Bill of Lading ke Lembaga Asuransi
    Ins-->>Admin: Surveyor Melakukan Verifikasi Lapangan & Menerbitkan Surat Klaim
    Admin->>Sys: Setujui Pencairan Klaim Polis Asuransi
    Sys-->>Ops: Dana Klaim Siap Diteruskan ke Shipper/Consignee
    Ops->>Cust: Konfirmasi Penyelesaian Klaim & Penggantian Kerugian
```

#### Protokol Penerapan Status WEATHER_HOLD:
Sistem menerapkan mekanisme ganda (*Hybrid Advisory & Legal Trigger*):
1. **Marine Weather API Advisory (Otomatis)**: Layanan cuaca internal mendeteksi gelombang tinggi > 2.5 meter atau angin kencang di rute pelayaran, lalu menandai rute pada peta radar dengan visual *High Wave Advisory* (Peringatan Kuning).
2. **Otorisasi Legal Syahbandar (Manual Trigger)**: Status kargo tidak langsung dibatalkan secara sepihak oleh AI/sensor. Operator regional mengaktifkan status resmi **`WEATHER_HOLD`** setelah Kantor Kesyahbandaran dan Otoritas Pelabuhan (KSOP) setempat menerbitkan Maklumat Penundaan Surat Persetujuan Berlayar (SPB Hold).
3. **Automasi Broadcast Shipper**: Saat `WEATHER_HOLD` diaktifkan operator, antrean pesan WhatsApp dan email otomatis mengirimkan tautan resmi maklumat Syahbandar kepada seluruh *consignee/shipper* yang muatannya berada di kapal tersebut.

#### Kronologi Langkah:
1. **Penemuan di Lapangan**: Saat kontainer diturunkan di Pelabuhan Batu Ampar Batam, operator mencatat paking karet pintu kontainer sobek akibat cuaca badai di laut Jawa, menyebabkan 25 karton suku cadang elektronik basah air asin.
2. **Dokumentasi Bukti**: Operator membuat *Berita Acara Kerusakan Barang (BAP)* di `apps/operator`, memotret segel peti kemas, mencatat nomor seri segel, dan melampirkan lembar deklarasi *Marine Cargo Policy*.
3. **Pemberitahuan Transparan ke Konsumen**: Sistem memberikan status peringatan kuning pada resi customer: *"Tiba di Pelabuhan dengan Berita Acara Kerusakan Parsial"*. Customer langsung dihubungi oleh dispatcher operator setempat.
4. **Eskalasi ke Admin**: Karena nilai estimasi kerugian mencapai Rp 180.000.000 (melebihi batas wewenang lokal), tiket dieskalasikan ke Superadmin.
5. **Penanganan Asuransi oleh Admin**: Superadmin meneruskan dokumen digital ke perusahaan asuransi rekanan (*Underwriter*) melalui portal admin. Surveyor asuransi turun memeriksa barang di depo Batam.
6. **Pencairan & Retensi Pelanggan**: Setelah klaim disetujui asuransi, dana diteruskan ke rekening pelanggan sesuai ketentuan polis, menjaga kepercayaan pelanggan terhadap SoraCargo.

---

## 5. Manajemen Perangkat Gateway (Admin Only)

Untuk menjamin kedaulatan data dan mencegah penyalahgunaan nomor resmi perusahaan:
- **Hak Akses**: Halaman manajemen WhatsApp Gateway dan Email SMTP hanya tersedia di dashboard **`apps/admin`** (`/admin/settings/gateways`).
- **Fitur Khusus Admin**:
  - Scan QR Code untuk menautkan nomor WhatsApp resmi (*Multi-device pairing*).
  - Monitoring status online/offline koneksi WhatsApp socket Baileys.
  - Restart service WhatsApp Gateway tanpa mengganggu container aplikasi utama.
  - Pengaturan kuota kirim per jam (*rate-limiting*) untuk mencegah nomor WhatsApp terblokir oleh Meta.
  - Pengaturan template pesan otomatis (OTP, Booking Confirmed, Delivery Order Ready).

