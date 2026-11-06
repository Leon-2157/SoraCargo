@extends('layouts.app')

@section('title', 'Profil 360° Mitra: ' . $company->company_name)

@section('content')
<!-- Breadcrumbs & Quick Back -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dasbor</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.corporate') }}" class="text-decoration-none">Mitra Corporate B2B</a></li>
            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $company->company_name }}</li>
        </ol>
    </nav>
    <a href="{{ route('admin.customers.corporate') }}" class="btn btn-outline-secondary btn-sm shadow-xs">
        <x-icon name="arrow-left" size="0.85rem" class="me-1" /> Kembali ke Daftar Mitra
    </a>
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
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
    $credit = $company->credit;
    $limit = $credit ? (float) $credit->credit_limit_amount : 0;
    $used = $credit ? (float) $credit->used_credit_amount : 0;
    $remaining = max(0, $limit - $used);
    $utilPercent = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;
    $isLocked = $company->user && $company->user->status === 'BOOKING_LOCKED';
    $kycStatus = $credit->kyc_status ?? 'PENDING_VERIFICATION';

    $waPhone = preg_replace('/[^0-9]/', '', $company->pic_phone);
    if (str_starts_with($waPhone, '0')) {
        $waPhone = '62' . substr($waPhone, 1);
    }
@endphp

<!-- Company Hero Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div class="d-flex gap-3">
                <div class="bg-primary-subtle text-primary p-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <x-icon name="building-2" size="2rem" />
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h4 class="fw-bold text-dark mb-0">{{ $company->company_name }}</h4>
                        
                        <!-- KYC Status Badge -->
                        @if($kycStatus === 'PENDING_VERIFICATION')
                            <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1">
                                ⏳ Tahap 1: Menunggu Validasi Legalitas (Maker)
                            </span>
                        @elseif($kycStatus === 'LEGALITY_VERIFIED')
                            <span class="badge bg-info-subtle text-info border border-info px-2 py-1">
                                📝 Berkas Sah: Menunggu Plafon (Checker)
                            </span>
                        @elseif($kycStatus === 'VERIFIED_APPROVED')
                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1">
                                ✅ Terverifikasi &amp; Plafon Aktif
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">
                                ❌ Berkas Ditolak
                            </span>
                        @endif

                        <!-- Debt Enforcement Stage Badge -->
                        @php $stage = $credit->debt_enforcement_stage ?? 'HEALTHY'; @endphp
                        @if($stage === 'HEALTHY')
                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1">🟢 Lancar (Healthy)</span>
                        @elseif($stage === 'SP1_ISSUED')
                            <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1">🟡 SP-1 Overdue</span>
                        @elseif($stage === 'SP2_LOCKED')
                            <span class="badge bg-danger text-white px-2 py-1">🔴 SP-2 Locked</span>
                        @else
                            <span class="badge bg-dark text-white px-2 py-1">⚫ SP-3 Kuasa Hukum</span>
                        @endif

                        <!-- Booking Status Badge -->
                        @if($isLocked)
                            <span class="badge bg-danger text-white px-2 py-1">🔒 Booking Dikunci</span>
                        @else
                            <span class="badge bg-success text-white px-2 py-1">🔓 Izin Booking Aktif</span>
                        @endif
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mt-2">
                        <span><x-icon name="barcode" size="0.8rem" /> NIB: <strong class="text-dark">{{ $company->nib }}</strong></span>
                        <span>•</span>
                        <span><x-icon name="file-text" size="0.8rem" /> NPWP: <strong class="text-dark">{{ $company->npwp }}</strong></span>
                        <span>•</span>
                        <span><x-icon name="user" size="0.8rem" /> PIC: <strong class="text-dark">{{ $company->pic_name }}</strong></span>
                        <span>•</span>
                        <span><x-icon name="clock" size="0.8rem" /> Bergabung: {{ $company->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="small text-muted mt-1">
                        <x-icon name="compass" size="0.8rem" /> {{ $company->company_address }}
                    </div>
                </div>
            </div>

            <!-- Header Quick Action Buttons -->
            <div class="d-flex flex-wrap gap-2">
                <a href="https://wa.me/{{ $waPhone }}?text=Halo%20{{ urlencode($company->pic_name) }}%20({{ urlencode($company->company_name) }}),%20kami%20dari%20Tim%20SoraCargo." 
                   target="_blank" 
                   class="btn btn-outline-success btn-sm shadow-xs fw-semibold">
                    <x-icon name="brand-whatsapp" size="0.9rem" class="me-1 text-success" /> Hubungi PIC WhatsApp
                </a>

                <button class="btn btn-outline-warning btn-sm shadow-xs text-dark fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#detailMakerModal">
                    <x-icon name="file-check" size="0.9rem" class="me-1 text-warning" /> Validasi Maker (Ops)
                </button>

                <button class="btn btn-primary btn-sm shadow-xs fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#detailCheckerModal">
                    <x-icon name="shield-check" size="0.9rem" class="me-1" /> Penetapan Checker (Finance)
                </button>

                <button class="btn {{ $isLocked ? 'btn-success' : 'btn-outline-danger' }} btn-sm shadow-xs fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#detailLockModal">
                    <x-icon name="{{ $isLocked ? 'check-circle' : 'ban' }}" size="0.9rem" class="me-1" />
                    {{ $isLocked ? 'Dispensasi Buka Kunci' : 'Kunci Booking' }}
                </button>

                <button class="btn btn-warning btn-sm shadow-xs text-dark fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#detailSpModal">
                    <x-icon name="shield-alert" size="0.9rem" class="me-1" /> Kirim SP
                </button>
            </div>
        </div>

        <hr class="my-4">

        <!-- Stepper: Maker-Checker Governance Flow -->
        <div class="row text-center g-3">
            <!-- Step 1 -->
            <div class="col-md-3">
                <div class="p-3 rounded bg-light border border-success">
                    <div class="text-success fw-bold small text-uppercase mb-1">
                        <x-icon name="check-circle" size="0.9rem" class="me-1" /> 1. Registrasi Akun
                    </div>
                    <div class="small fw-semibold text-dark">Data PT &amp; Kontak PIC</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ $company->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-md-3">
                <div class="p-3 rounded bg-light border {{ in_array($kycStatus, ['LEGALITY_VERIFIED', 'VERIFIED_APPROVED']) ? 'border-success' : 'border-warning' }}">
                    <div class="{{ in_array($kycStatus, ['LEGALITY_VERIFIED', 'VERIFIED_APPROVED']) ? 'text-success' : 'text-warning' }} fw-bold small text-uppercase mb-1">
                        <x-icon name="{{ in_array($kycStatus, ['LEGALITY_VERIFIED', 'VERIFIED_APPROVED']) ? 'check-circle' : 'clock' }}" size="0.9rem" class="me-1" /> 
                        2. Validasi Maker (Ops)
                    </div>
                    <div class="small fw-semibold text-dark">Pemeriksaan NIB &amp; NPWP</div>
                    <div class="text-muted" style="font-size: 0.75rem;">
                        @if($credit && $credit->legalityVerifier)
                            Oleh: {{ $credit->legalityVerifier->name }} ({{ $credit->legality_verified_at ? $credit->legality_verified_at->format('d/m/Y') : '-' }})
                        @else
                            Menunggu Staf Operasional
                        @endif
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-3">
                <div class="p-3 rounded bg-light border {{ $kycStatus === 'VERIFIED_APPROVED' ? 'border-success' : ($kycStatus === 'LEGALITY_VERIFIED' ? 'border-primary' : 'border-secondary') }}">
                    <div class="{{ $kycStatus === 'VERIFIED_APPROVED' ? 'text-success' : ($kycStatus === 'LEGALITY_VERIFIED' ? 'text-primary' : 'text-muted') }} fw-bold small text-uppercase mb-1">
                        <x-icon name="{{ $kycStatus === 'VERIFIED_APPROVED' ? 'check-circle' : 'shield-check' }}" size="0.9rem" class="me-1" /> 
                        3. Checker (Finance Lead)
                    </div>
                    <div class="small fw-semibold text-dark">Limit Plafon &amp; TOP {{ $credit->top_days ?? 30 }} Hari</div>
                    <div class="text-muted" style="font-size: 0.75rem;">
                        @if($credit && $credit->creditApprover)
                            Oleh: {{ $credit->creditApprover->name }} ({{ $credit->credit_approved_at ? $credit->credit_approved_at->format('d/m/Y') : '-' }})
                        @else
                            Menunggu Finance Lead
                        @endif
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-md-3">
                <div class="p-3 rounded bg-light border {{ $kycStatus === 'VERIFIED_APPROVED' && !$isLocked ? 'border-success' : 'border-secondary' }}">
                    <div class="{{ $kycStatus === 'VERIFIED_APPROVED' && !$isLocked ? 'text-success' : 'text-muted' }} fw-bold small text-uppercase mb-1">
                        <x-icon name="boxes" size="0.9rem" class="me-1" /> 4. Operasional Berjalan
                    </div>
                    <div class="small fw-semibold text-dark">Izin Booking Kargo Aktif</div>
                    <div class="text-muted" style="font-size: 0.75rem;">
                        {{ $isLocked ? 'Saat Ini Dikunci' : 'Siap Order Petikemas' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial & Credit Utilization Radar -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Plafon Kredit Disetujui</div>
                <h4 class="fw-bold mb-0 mt-1 text-primary">Rp {{ number_format($limit, 0, ',', '.') }}</h4>
                <div class="small text-muted mt-1">Termin TOP: <strong>{{ $credit->top_days ?? 30 }} Hari Kalender</strong></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Plafon Kredit Terpakai</div>
                <h4 class="fw-bold mb-0 mt-1 text-dark">Rp {{ number_format($used, 0, ',', '.') }}</h4>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar {{ $utilPercent > 85 ? 'bg-danger' : 'bg-warning' }}" style="width: {{ min(100, $utilPercent) }}%;"></div>
                </div>
                <div class="small text-muted mt-1">Rasio Utilisasi: <strong>{{ $utilPercent }}%</strong></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Sisa Plafon Tersedia</div>
                <h4 class="fw-bold mb-0 mt-1 text-success">Rp {{ number_format($remaining, 0, ',', '.') }}</h4>
                <div class="small text-muted mt-1">Dapat digunakan untuk booking baru</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Faktur Belum Lunas (Unpaid)</div>
                <h4 class="fw-bold mb-0 mt-1 {{ $unpaidInvoicesCount > 0 ? 'text-danger' : 'text-dark' }}">
                    Rp {{ number_format($unpaidInvoicesTotal, 0, ',', '.') }}
                </h4>
                <div class="small {{ $unpaidInvoicesCount > 0 ? 'text-danger' : 'text-muted' }} mt-1">
                    {{ $unpaidInvoicesCount }} Tagihan Menunggu Pembayaran
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Tabs Navigation -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom p-0">
        <ul class="nav nav-tabs card-header-tabs m-0 px-3 border-0" id="corporateTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active py-3 fw-semibold" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">
                    <x-icon name="file-text" size="0.9rem" class="me-1 text-primary" /> Faktur &amp; Penagihan TOP ({{ $company->invoices->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 fw-semibold" id="cargo-tab" data-bs-toggle="tab" data-bs-target="#cargo" type="button" role="tab">
                    <x-icon name="boxes" size="0.9rem" class="me-1 text-success" /> Riwayat Kargo &amp; Booking ({{ $company->bookings->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 fw-semibold" id="legal-tab" data-bs-toggle="tab" data-bs-target="#legal" type="button" role="tab">
                    <x-icon name="badge-check" size="0.9rem" class="me-1 text-warning" /> Berkas Legalitas &amp; Dokumen OSS
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 fw-semibold" id="audit-tab" data-bs-toggle="tab" data-bs-target="#audit" type="button" role="tab">
                    <x-icon name="shield" size="0.9rem" class="me-1 text-danger" /> Catatan Audit Forensik ({{ $auditLogs->count() }})
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content" id="corporateTabContent">
            <!-- TAB 1: Faktur & Penagihan B2B -->
            <div class="tab-pane fade show active" id="invoices" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Daftar Faktur Tagihan Berjangka (TOP)</h6>
                    <a href="{{ route('admin.finance.invoices') }}" class="btn btn-outline-primary btn-sm">
                        Kelola Semua Faktur di Modul Keuangan
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th>No. Faktur</th>
                                <th>Nilai Tagihan (IDR)</th>
                                <th>Jatuh Tempo (Due Date)</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($company->invoices as $inv)
                                @php
                                    $isOverdue = $inv->payment_status === 'UNPAID' && \Carbon\Carbon::parse($inv->due_date)->isPast();
                                @endphp
                                <tr>
                                    <td class="fw-bold font-monospace text-primary">{{ $inv->invoice_number }}</td>
                                    <td class="fw-semibold">Rp {{ number_format($inv->total_invoice_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="{{ $isOverdue ? 'text-danger fw-bold' : 'text-dark' }}">
                                            {{ \Carbon\Carbon::parse($inv->due_date)->format('d M Y') }}
                                        </span>
                                        @if($isOverdue)
                                            <span class="badge bg-danger-subtle text-danger ms-1">Lewat Tempo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inv->payment_status === 'PAID')
                                            <span class="badge bg-success-subtle text-success border border-success">LUNAS</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning">BELUM DIBAYAR</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ $inv->paid_at ? \Carbon\Carbon::parse($inv->paid_at)->format('d/m/Y H:i') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada riwayat faktur tagihan untuk mitra ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: Riwayat Pengiriman Kargo & Booking -->
            <div class="tab-pane fade" id="cargo" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Riwayat Pesanan Pengiriman Petikemas &amp; Kargo</h6>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary btn-sm">
                        Buka Manajemen Kargo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th>No. Resi / Tracking</th>
                                <th>Tipe Kargo</th>
                                <th>Rute Pelabuhan</th>
                                <th>Volume &amp; Berat</th>
                                <th>Nilai Deklarasi</th>
                                <th>Status Terkini</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($company->bookings as $booking)
                                <tr>
                                    <td class="font-monospace fw-bold text-dark">{{ $booking->tracking_number }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $booking->cargo_type }}</span>
                                    </td>
                                    <td>
                                        {{ $booking->route->originPort->port_code ?? 'JKT' }} → {{ $booking->route->destinationPort->port_code ?? 'SUB' }}
                                        <div class="text-muted small">{{ $booking->route->originPort->port_name ?? 'Tanjung Priok' }}</div>
                                    </td>
                                    <td>
                                        {{ number_format($booking->total_weight_kg) }} kg / {{ number_format($booking->total_volume_cbm, 1) }} CBM
                                    </td>
                                    <td class="fw-semibold">Rp {{ number_format($booking->declared_goods_value, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary">
                                            {{ $booking->cargo_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada riwayat booking kargo dari mitra ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: Berkas Legalitas & Kepatuhan Dokumen -->
            <div class="tab-pane fade" id="legal" role="tabpanel">
                <h6 class="fw-bold text-dark mb-3">Informasi Legalitas &amp; Dokumen Kepatuhan</h6>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border bg-light h-100">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Identitas Badan Hukum</h6>
                                <table class="table table-sm table-borderless mb-0 small">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Nama Perusahaan:</td>
                                        <td class="fw-bold text-dark">{{ $company->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nomor Induk Berusaha (NIB):</td>
                                        <td><code>{{ $company->nib }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">NPWP Badan:</td>
                                        <td><code>{{ $company->npwp }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Alamat Domisili:</td>
                                        <td>{{ $company->company_address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border bg-light h-100">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Jaminan Finansial &amp; Riwayat Verifikasi</h6>
                                <table class="table table-sm table-borderless mb-0 small">
                                    <tr>
                                        <td class="text-muted" style="width: 170px;">Bank Guarantee Ref:</td>
                                        <td class="fw-bold text-dark">{{ $credit->bank_guarantee_ref ?? 'Tidak Ada (Unsecured TOP)' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Verifikator Maker (Ops):</td>
                                        <td>
                                            @if($credit && $credit->legalityVerifier)
                                                <span class="text-success fw-bold">{{ $credit->legalityVerifier->name }}</span> ({{ $credit->legality_verified_at->format('d/m/Y H:i') }})
                                            @else
                                                <span class="text-muted">Belum diverifikasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Catatan Maker:</td>
                                        <td class="text-dark"><em>{{ $credit->legality_notes ?? '-' }}</em></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Approver Checker (Finance):</td>
                                        <td>
                                            @if($credit && $credit->creditApprover)
                                                <span class="text-primary fw-bold">{{ $credit->creditApprover->name }}</span> ({{ $credit->credit_approved_at->format('d/m/Y H:i') }})
                                            @else
                                                <span class="text-muted">Belum disetujui</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($credit && $credit->dispensation_notes)
                                        <tr>
                                            <td class="text-danger fw-bold">Catatan Dispensasi:</td>
                                            <td class="text-danger">{{ $credit->dispensation_notes }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: Catatan Audit Forensik -->
            <div class="tab-pane fade" id="audit" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Catatan Aktivitas &amp; Log Perubahan Sistem (Immutable Audit Trail)</h6>
                    <a href="{{ route('admin.audit') }}" class="btn btn-outline-dark btn-sm">
                        Buka Pusat Audit Trail
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th>Waktu Kejadian</th>
                                <th>Staf Admin Pelaksana</th>
                                <th>Jenis Tindakan</th>
                                <th>Alamat IP</th>
                                <th>Detail Payload JSON</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auditLogs as $log)
                                <tr>
                                    <td class="text-muted small font-monospace">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ $log->adminUser->name ?? 'Sistem Otomatis' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary border font-monospace">
                                            {{ $log->action_type }}
                                        </span>
                                    </td>
                                    <td class="small text-muted font-monospace">{{ $log->ip_address }}</td>
                                    <td class="small">
                                        <pre class="bg-light p-2 rounded mb-0 text-muted" style="max-height: 80px; font-size: 0.75rem;">{{ json_encode($log->after_state_json ?? $log->before_state_json, JSON_PRETTY_PRINT) }}</pre>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada riwayat audit trail tercatat untuk mitra ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS FOR QUICK ACTIONS ON DETAIL PAGE -->

<!-- MODAL 1: Maker Validasi Legalitas -->
<div class="modal fade" id="detailMakerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.customers.corporate.verify_legality', $company->id) }}">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold fs-6">
                        <x-icon name="file-check" class="text-warning me-1" /> [Tahap 1 Maker] Validasi Legalitas Dokumen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-secondary small mb-3">
                        Perusahaan: <strong>{{ $company->company_name }}</strong><br>
                        NIB: <code>{{ $company->nib }}</code> | NPWP: <code>{{ $company->npwp }}</code>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Keputusan Validasi Berkas Operasional <span class="text-danger">*</span></label>
                        <select name="legality_status" class="form-select form-select-sm" required>
                            <option value="LEGALITY_VERIFIED" {{ ($credit->kyc_status ?? '') === 'LEGALITY_VERIFIED' ? 'selected' : '' }}>
                                ✅ Dokumen Sah &amp; Lengkap (Teruskan ke Checker Finance)
                            </option>
                            <option value="REJECTED" {{ ($credit->kyc_status ?? '') === 'REJECTED' ? 'selected' : '' }}>
                                ❌ Berkas Tidak Lengkap / Ditolak
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Catatan Hasil Pemeriksaan Legalitas <span class="text-danger">*</span></label>
                        <textarea name="legality_notes" class="form-control form-control-sm" rows="3" placeholder="Contoh: NIB dan NPWP telah dicocokkan via OSS Cloud. Akta Perusahaan sah..." required>{{ $credit->legality_notes ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold">Simpan Keputusan Maker</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: Checker Persetujuan Plafon Kredit -->
<div class="modal fade" id="detailCheckerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.customers.corporate.approve_credit', $company->id) }}">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold fs-6">
                        <x-icon name="shield-check" class="text-primary me-1" /> [Tahap 2 Checker] Penetapan Plafon Kredit &amp; TOP
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info small mb-3">
                        Status Dokumen Maker: <strong>{{ $credit->kyc_status ?? 'PENDING' }}</strong><br>
                        Catatan Maker: <em>{{ $credit->legality_notes ?? 'Belum ada catatan maker' }}</em>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Batas Plafon Kredit B2B (IDR) <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" step="1000000" name="credit_limit_amount" class="form-control" value="{{ $credit->credit_limit_amount ?? 500000000 }}" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Term of Payment (TOP) <span class="text-danger">*</span></label>
                            <select name="top_days" class="form-select form-select-sm" required>
                                <option value="14" {{ ($credit->top_days ?? 30) == 14 ? 'selected' : '' }}>14 Hari Kalender</option>
                                <option value="30" {{ ($credit->top_days ?? 30) == 30 ? 'selected' : '' }}>30 Hari Kalender (Standar)</option>
                                <option value="45" {{ ($credit->top_days ?? 30) == 45 ? 'selected' : '' }}>45 Hari Kalender</option>
                                <option value="60" {{ ($credit->top_days ?? 30) == 60 ? 'selected' : '' }}>60 Hari Kalender</option>
                                <option value="90" {{ ($credit->top_days ?? 30) == 90 ? 'selected' : '' }}>90 Hari</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tahap Penagihan Awal <span class="text-danger">*</span></label>
                            <select name="debt_enforcement_stage" class="form-select form-select-sm" required>
                                <option value="HEALTHY" {{ ($credit->debt_enforcement_stage ?? 'HEALTHY') === 'HEALTHY' ? 'selected' : '' }}>🟢 Lancar (Healthy)</option>
                                <option value="SP1_ISSUED" {{ ($credit->debt_enforcement_stage ?? '') === 'SP1_ISSUED' ? 'selected' : '' }}>🟡 SP-1 Overdue</option>
                                <option value="SP2_LOCKED" {{ ($credit->debt_enforcement_stage ?? '') === 'SP2_LOCKED' ? 'selected' : '' }}>🔴 SP-2 Locked</option>
                                <option value="SP3_LEGAL_COLLECTION" {{ ($credit->debt_enforcement_stage ?? '') === 'SP3_LEGAL_COLLECTION' ? 'selected' : '' }}>⚫ SP-3 Kuasa Hukum</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Referensi Bank Guarantee</label>
                        <input type="text" name="bank_guarantee_ref" class="form-control form-control-sm" placeholder="Contoh: BG-88291-MND" value="{{ $credit->bank_guarantee_ref ?? '' }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Catatan Evaluasi Risiko Kredit (Checker)</label>
                        <textarea name="checker_notes" class="form-control form-control-sm" rows="2" placeholder="Catatan persetujuan risiko keuangan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Setujui Plafon (Checker Final)</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: Kunci / Pulihkan Izin Booking -->
<div class="modal fade" id="detailLockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.customers.corporate.lock', $company->id) }}">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold fs-6">
                        <x-icon name="{{ $isLocked ? 'check-circle' : 'ban' }}" class="{{ $isLocked ? 'text-success' : 'text-danger' }} me-1" />
                        {{ $isLocked ? 'Buka Kunci Booking Kargo (Pemberian Dispensasi)' : 'Kunci Izin Booking Kargo (Lock Booking)' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if($isLocked)
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alasan Dispensasi Pemulihan <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Telah ada surat pernyataan transfer bertahap dari Direktur Utama..." required></textarea>
                        </div>
                    @else
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alasan Penguncian Akses</label>
                            <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Tagihan faktur INV-202611 melewati batas toleransi TOP (SP2)..."></textarea>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn {{ $isLocked ? 'btn-success' : 'btn-danger' }} btn-sm fw-bold">
                        {{ $isLocked ? 'Buka Kunci (Aktifkan Dispensasi)' : 'Konfirmasi Kunci Booking' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 4: Kirim SP WhatsApp -->
<div class="modal fade" id="detailSpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('admin.customers.corporate.send_warning', $company->id) }}">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold fs-6">
                        <x-icon name="brand-whatsapp" class="text-success me-1" /> Kirim Surat Peringatan Tagihan via WhatsApp
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-secondary small mb-3">
                        Tujuan: <strong>{{ $company->pic_name }}</strong> ({{ $company->pic_phone }})<br>
                        Perusahaan: {{ $company->company_name }}
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Tingkat Surat Peringatan <span class="text-danger">*</span></label>
                        <select name="sp_stage" class="form-select form-select-sm" required>
                            <option value="SP1_ISSUED">🟡 SP-1 (Peringatan Jatuh Tempo Hari ke-1)</option>
                            <option value="SP2_LOCKED">🔴 SP-2 (Toleransi Hari ke-7 &amp; Penahanan Booking)</option>
                            <option value="SP3_LEGAL_COLLECTION">⚫ SP-3 (Eskalasi Kuasa Hukum &amp; Sita Jaminan Bank)</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Catatan Tambahan untuk PIC</label>
                        <textarea name="custom_message" class="form-control form-control-sm" rows="3" placeholder="Pesan resmi akan diteruskan melalui Baileys WhatsApp Gateway terverifikasi SoraCargo..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm fw-bold">
                        <x-icon name="brand-whatsapp" size="0.85rem" class="me-1" /> Kirim Pesan Resmi Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
