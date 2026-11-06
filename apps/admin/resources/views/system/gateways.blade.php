@extends('layouts.app')

@section('title', 'Gerbang Pesan & Email')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Gerbang Pesan &amp; Email</h3>
            <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold px-2 py-1">
                <x-icon name="brand-whatsapp" size="0.85rem" class="me-1" /> Multi-Channel Dispatch
            </span>
        </div>
        <p class="text-muted small mb-0">Integrasi socket Baileys WhatsApp Multi-Device untuk notifikasi bot pelacakan kargo, tagihan jatuh tempo B2B, dan relay server SMTP email.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <form action="{{ route('admin.gateways.wa.reconnect') }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-outline-success d-flex align-items-center" type="submit">
                <x-icon name="refresh-cw" class="me-1" /> Ping Heartbeat WhatsApp
            </button>
        </form>
    </div>
</div>

<!-- Flash Notifications -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <x-icon name="check-circle" class="me-2 text-success flex-shrink-0" />
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <x-icon name="alert-circle" class="me-2 text-danger flex-shrink-0 mt-1" />
            <div>
                <strong>Validasi Gagal:</strong>
                <ul class="mb-0 ps-3 mt-1 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- 4 Small Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: WA Status -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Socket WhatsApp Bot</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $waStatus }}</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Baileys MD Paired</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="brand-whatsapp" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: WA Latency -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Latensi Jaringan Socket</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $waLatency }} ms</div>
                        <span class="text-muted text-xs">Respon instan real-time</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="clock" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Daily Quota -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Kuota Pesan Hari Ini</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ number_format($waSentToday) }} / {{ number_format($waQuota) }}</div>
                        <span class="text-muted text-xs">Sisa: {{ number_format($waQuota - $waSentToday) }} pesan</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="coins" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: SMTP Relay -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Relay Server SMTP</div>
                        <div class="text-dark fw-bold h5 mb-0">Port {{ $smtpPort }} TLS</div>
                        <span class="text-muted text-xs font-monospace">{{ $smtpHost }}</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="mail" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Two Cards Row: WhatsApp Baileys & SMTP Relay -->
<div class="row g-4">
    <!-- Card 1: WhatsApp Baileys Gateway -->
    <div class="col-lg-6">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="text-success m-0 fw-bold d-flex align-items-center">
                    <x-icon name="brand-whatsapp" class="me-2" />WhatsApp Gateway (Baileys Multi-Device)
                </h6>
                <span class="badge bg-success text-white">TERHUBUNG</span>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center p-3 bg-light rounded mb-3 border">
                    <div class="bg-success text-white rounded-circle p-2 me-3">
                        <x-icon name="phone" size="1.5rem" />
                    </div>
                    <div>
                        <div class="text-xs text-muted">Nomor WhatsApp Business Bot Resmi:</div>
                        <div class="fw-bold font-monospace h6 mb-0 text-dark">{{ $waPhone }}</div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle text-xs mt-1">
                            <x-icon name="check-circle" size="0.7rem" /> Multi-Device Session Active
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between text-xs mb-1">
                        <span class="text-muted">Penggunaan Kuota Pesan Harian:</span>
                        @php $usagePct = round(($waSentToday / $waQuota) * 100, 1); @endphp
                        <strong class="text-dark">{{ $usagePct }}% ({{ number_format($waSentToday) }} / {{ number_format($waQuota) }})</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $usagePct }}%"></div>
                    </div>
                </div>

                <h6 class="fw-bold text-dark small mt-4 mb-2">Automated Trigger Hooks Terdaftar:</h6>
                <ul class="list-group list-group-flush small mb-3 border rounded">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <span><x-icon name="check-circle" size="0.8rem" class="text-success me-1" /> Notifikasi Nomor Resi &amp; Booking Baru</span>
                        <span class="badge bg-light text-dark border">Aktif</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <span><x-icon name="check-circle" size="0.8rem" class="text-success me-1" /> Tracking Milestone Kapal (Gate-In / Sailing / Delivered)</span>
                        <span class="badge bg-light text-dark border">Aktif</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <span><x-icon name="check-circle" size="0.8rem" class="text-success me-1" /> Pengingat Tagihan Invoice B2B &amp; Surat Peringatan (SP)</span>
                        <span class="badge bg-light text-dark border">Aktif</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                        <span><x-icon name="check-circle" size="0.8rem" class="text-success me-1" /> Peringatan Cuaca Ekstrem BMKG &amp; Weather Hold</span>
                        <span class="badge bg-light text-dark border">Aktif</span>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    <form action="{{ route('admin.gateways.wa.reconnect') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success w-100">
                            <x-icon name="refresh-cw" class="me-1" /> Sinkronisasi Heartbeat Socket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: SMTP Relay Server Configuration -->
    <div class="col-lg-6">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="text-primary m-0 fw-bold d-flex align-items-center">
                    <x-icon name="mail" class="me-2" />Server Relay SMTP (Corporate Email)
                </h6>
                <span class="badge bg-primary text-white">READY</span>
            </div>
            <div class="card-body">
                <p class="text-muted small">Digunakan untuk pengiriman dokumen resmi bertanda tangan digital: Surat Jalan (POD), Invoice PDF, Bukti Potong Pajak, dan Berita Acara Kerusakan (BAP).</p>

                <form action="{{ route('admin.gateways.smtp.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Host Server SMTP <span class="text-danger">*</span></label>
                        <input type="text" name="smtp_host" class="form-control form-control-sm font-monospace" value="{{ $smtpHost }}" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Port Enkripsi <span class="text-danger">*</span></label>
                            <select name="smtp_port" class="form-select form-select-sm" required>
                                <option value="587" {{ $smtpPort == '587' ? 'selected' : '' }}>587 (TLS / STARTTLS - Rekomendasi)</option>
                                <option value="465" {{ $smtpPort == '465' ? 'selected' : '' }}>465 (SSL Direct)</option>
                                <option value="25" {{ $smtpPort == '25' ? 'selected' : '' }}>25 (Standard Non-SSL)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Protokol Keamanan</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="STARTTLS Enforced" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-dark">Alamat Email Pengirim Resmi <span class="text-danger">*</span></label>
                        <input type="email" name="smtp_sender_email" class="form-control form-control-sm font-monospace" value="{{ $smtpSender }}" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <x-icon name="check-circle" class="me-1" /> Simpan &amp; Uji Handshake SMTP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

