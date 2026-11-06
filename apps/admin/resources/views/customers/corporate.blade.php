@extends('layouts.app')

@section('title', 'Mitra Corporate B2B')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Manajemen Mitra Corporate B2B</h3>
            <span class="badge badge-b2b fw-semibold px-2 py-1">
                <x-icon name="building-2" size="0.85rem" class="me-1" /> Klien Korporat
            </span>
        </div>
        <p class="text-muted small mb-0">Verifikasi legalitas Maker-Checker (NIB/NPWP/Akta), evaluasi risiko kredit, serta penetapan plafon &amp; termin TOP (Term of Payment 30–60 hari).</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <a href="{{ route('admin.customers.corporate.export') }}" class="btn btn-outline-success btn-sm shadow-sm">
            <x-icon name="file-spreadsheet" size="0.9rem" class="me-1" /> Ekspor Rekap Kredit (CSV)
        </a>
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
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Quick Antrean Action Bar (Jika ada pending approval) -->
@if($pendingMakerCount > 0 || $pendingCheckerCount > 0)
    <div class="alert alert-warning border-start border-4 border-warning shadow-sm mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <x-icon name="clock" class="text-warning flex-shrink-0" />
                <div>
                    <strong>Pemberitahuan Antrean Persetujuan (Maker-Checker):</strong>
                    <span class="ms-2 small text-dark">
                        @if($pendingMakerCount > 0)
                            <span class="badge bg-warning text-dark me-1">{{ $pendingMakerCount }} Menunggu Validasi Legalitas (Maker)</span>
                        @endif
                        @if($pendingCheckerCount > 0)
                            <span class="badge bg-info text-white">{{ $pendingCheckerCount }} Menunggu Penetapan Plafon (Checker)</span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                @if($pendingMakerCount > 0)
                    <a href="{{ route('admin.customers.corporate', ['kyc' => 'PENDING_VERIFICATION']) }}" class="btn btn-sm btn-outline-dark fw-semibold">
                        Lihat Antrean Maker
                    </a>
                @endif
                @if($pendingCheckerCount > 0)
                    <a href="{{ route('admin.customers.corporate', ['kyc' => 'LEGALITY_VERIFIED']) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                        Lihat Antrean Checker
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- KPI Radar Korporat B2B Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Total Mitra Perusahaan</div>
                        <h4 class="fw-bold mb-0 mt-1">{{ number_format($totalCompaniesCount) }} <span class="fs-6 fw-normal text-muted">PT/CV</span></h4>
                        <div class="small text-success mt-1">
                            <x-icon name="badge-check" size="0.8rem" /> {{ $activeCorporateCount }} Aktif Terverifikasi
                        </div>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <x-icon name="building-2" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Total Plafon Disetujui</div>
                        <h4 class="fw-bold mb-0 mt-1 text-success">Rp {{ number_format($totalApprovedCredit / 1000000, 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">Juta</span></h4>
                        <div class="small text-muted mt-1">Plafon kredit B2B berjalan</div>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <x-icon name="coins" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-info h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Plafon Kredit Terpakai</div>
                        <h4 class="fw-bold mb-0 mt-1 text-info">Rp {{ number_format($totalUsedCredit / 1000000, 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">Juta</span></h4>
                        @php
                            $utilTotal = $totalApprovedCredit > 0 ? round(($totalUsedCredit / $totalApprovedCredit) * 100, 1) : 0;
                        @endphp
                        <div class="small text-muted mt-1">Utilisasi: <strong>{{ $utilTotal }}%</strong> dari total</div>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-circle">
                        <x-icon name="boxes" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Tunggakan Overdue / SP</div>
                        <h4 class="fw-bold mb-0 mt-1 {{ $overdueCount > 0 ? 'text-danger' : 'text-dark' }}">
                            {{ number_format($overdueCount) }} <span class="fs-6 fw-normal text-muted">Mitra</span>
                        </h4>
                        <div class="small {{ $overdueCount > 0 ? 'text-danger' : 'text-muted' }} mt-1">
                            <x-icon name="shield-alert" size="0.8rem" /> SP1 / SP2 Lock / SP3 Legal
                        </div>
                    </div>
                    <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                        <x-icon name="alert-triangle" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.customers.corporate') }}" class="row g-2 align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <x-icon name="search" size="0.85rem" class="text-muted" />
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari PT/CV, NIB, NPWP, PIC, atau Email..." value="{{ $search }}">
                </div>
            </div>

            <div class="col-lg-3 col-md-3">
                <select name="kyc" class="form-select form-select-sm">
                    <option value="all">Semua Status KYC / Approval</option>
                    <option value="PENDING_VERIFICATION" {{ $kyc === 'PENDING_VERIFICATION' ? 'selected' : '' }}>⏳ Tahap 1: Menunggu Validasi Legalitas (Maker)</option>
                    <option value="LEGALITY_VERIFIED" {{ $kyc === 'LEGALITY_VERIFIED' ? 'selected' : '' }}>📝 Tahap 2: Menunggu Plafon (Checker)</option>
                    <option value="VERIFIED_APPROVED" {{ $kyc === 'VERIFIED_APPROVED' ? 'selected' : '' }}>✅ Terverifikasi &amp; Plafon Aktif</option>
                    <option value="REJECTED" {{ $kyc === 'REJECTED' ? 'selected' : '' }}>❌ Berkas Ditolak</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-3">
                <select name="debt" class="form-select form-select-sm">
                    <option value="all">Semua Tahap Penagihan</option>
                    <option value="HEALTHY" {{ $debt === 'HEALTHY' ? 'selected' : '' }}>🟢 Lancar (Healthy)</option>
                    <option value="SP1_ISSUED" {{ $debt === 'SP1_ISSUED' ? 'selected' : '' }}>🟡 SP-1 (Overdue 1–6 Hari)</option>
                    <option value="SP2_LOCKED" {{ $debt === 'SP2_LOCKED' ? 'selected' : '' }}>🔴 SP-2 Booking Terkunci (Overdue 7+ Hari)</option>
                    <option value="SP3_LEGAL_COLLECTION" {{ $debt === 'SP3_LEGAL_COLLECTION' ? 'selected' : '' }}>⚫ SP-3 Kuasa Hukum / Sita Jaminan</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                    Filter
                </button>
                @if($search || ($kyc && $kyc !== 'all') || ($debt && $debt !== 'all'))
                    <a href="{{ route('admin.customers.corporate') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Corporate Clients Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-3 py-3">Nama Perusahaan &amp; Legalitas</th>
                    <th class="py-3">Kontak PIC</th>
                    <th class="py-3">Status Maker-Checker KYC</th>
                    <th class="py-3">Plafon Kredit &amp; TOP</th>
                    <th class="py-3">Tahap Penagihan</th>
                    <th class="py-3">Izin Booking</th>
                    <th class="pe-3 py-3 text-end">Aksi Terpadu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    @php
                        $credit = $company->credit;
                        $limit = $credit ? (float) $credit->credit_limit_amount : 0;
                        $used = $credit ? (float) $credit->used_credit_amount : 0;
                        $remaining = max(0, $limit - $used);
                        $utilPercent = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;
                        $isLocked = $company->user && $company->user->status === 'BOOKING_LOCKED';
                        
                        // Clean phone number for WhatsApp
                        $waPhone = preg_replace('/[^0-9]/', '', $company->pic_phone);
                        if (str_starts_with($waPhone, '0')) {
                            $waPhone = '62' . substr($waPhone, 1);
                        }
                    @endphp
                    <tr>
                        <!-- Perusahaan & NIB/NPWP -->
                        <td class="ps-3 py-3">
                            <div class="fw-bold text-dark">
                                <a href="{{ route('admin.customers.corporate.show', $company->id) }}" class="text-dark text-decoration-none hover-primary">
                                    {{ $company->company_name }}
                                </a>
                            </div>
                            <div class="small text-muted mt-1">
                                <span class="badge bg-light text-secondary border font-monospace">NIB: {{ $company->nib }}</span>
                                <span class="badge bg-light text-secondary border font-monospace ms-1">NPWP: {{ $company->npwp }}</span>
                            </div>
                            <div class="text-truncate small text-muted mt-1" style="max-width: 260px;" title="{{ $company->company_address }}">
                                <x-icon name="compass" size="0.75rem" /> {{ $company->company_address }}
                            </div>
                        </td>

                        <!-- Kontak PIC -->
                        <td class="py-3">
                            <div class="fw-semibold text-dark">{{ $company->pic_name }}</div>
                            <div class="small text-muted">{{ $company->user->email ?? '-' }}</div>
                            <div class="mt-1">
                                <a href="https://wa.me/{{ $waPhone }}?text=Halo%20{{ urlencode($company->pic_name) }}%20({{ urlencode($company->company_name) }}),%20kami%20dari%20Tim%20SoraCargo." 
                                   target="_blank" 
                                   class="btn btn-outline-success btn-xs py-0 px-2 rounded-pill shadow-xs" 
                                   title="Kirim pesan WhatsApp langsung ke PIC">
                                    <x-icon name="brand-whatsapp" size="0.75rem" class="me-1" /> {{ $company->pic_phone }}
                                </a>
                            </div>
                        </td>

                        <!-- Status KYC Maker-Checker -->
                        <td class="py-3">
                            @if(!$credit || $credit->kyc_status === 'PENDING_VERIFICATION')
                                <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1">
                                    ⏳ Menunggu Validasi Dokumen (Maker)
                                </span>
                                <div class="small text-muted mt-1">Staf Ops perlu cek NIB/NPWP</div>
                            @elseif($credit->kyc_status === 'LEGALITY_VERIFIED')
                                <span class="badge bg-info-subtle text-info border border-info fw-semibold px-2 py-1">
                                    📝 Berkas Sah - Menunggu Plafon (Checker)
                                </span>
                                <div class="small text-muted mt-1">
                                    Divalidasi oleh: {{ $credit->legalityVerifier->name ?? 'Ops Staff' }}
                                </div>
                            @elseif($credit->kyc_status === 'VERIFIED_APPROVED')
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    ✅ Terverifikasi &amp; Plafon Aktif
                                </span>
                                <div class="small text-muted mt-1">
                                    Disetujui: {{ $credit->creditApprover->name ?? $credit->verifiedBy->name ?? 'Finance Admin' }}
                                </div>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1">
                                    ❌ Berkas Ditolak
                                </span>
                            @endif
                        </td>

                        <!-- Plafon Kredit & TOP -->
                        <td class="py-3" style="min-width: 200px;">
                            @if($credit && $limit > 0)
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-muted">Limit: <strong>Rp {{ number_format($limit, 0, ',', '.') }}</strong></span>
                                    <span class="badge bg-secondary-subtle text-secondary border">TOP {{ $credit->top_days }} Hari</span>
                                </div>
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar {{ $utilPercent > 85 ? 'bg-danger' : ($utilPercent > 60 ? 'bg-warning' : 'bg-primary') }}" 
                                         role="progressbar" 
                                         style="width: {{ min(100, $utilPercent) }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1" style="font-size: 0.75rem;">
                                    <span class="text-danger">Terpakai: Rp {{ number_format($used, 0, ',', '.') }}</span>
                                    <span class="text-success">Sisa: Rp {{ number_format($remaining, 0, ',', '.') }} ({{ 100 - $utilPercent }}%)</span>
                                </div>
                            @else
                                <span class="text-muted small italic">Plafon belum ditetapkan</span>
                            @endif
                        </td>

                        <!-- Tahap Penagihan -->
                        <td class="py-3">
                            @php $stage = $credit->debt_enforcement_stage ?? 'HEALTHY'; @endphp
                            @if($stage === 'HEALTHY')
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    🟢 Lancar (Healthy)
                                </span>
                            @elseif($stage === 'SP1_ISSUED')
                                <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1">
                                    🟡 SP-1 (Overdue)
                                </span>
                            @elseif($stage === 'SP2_LOCKED')
                                <span class="badge bg-danger text-white fw-semibold px-2 py-1">
                                    🔴 SP-2 Locked
                                </span>
                            @elseif($stage === 'SP3_LEGAL_COLLECTION')
                                <span class="badge bg-dark text-white fw-semibold px-2 py-1">
                                    ⚫ SP-3 Kuasa Hukum
                                </span>
                            @endif

                            @if($credit && $credit->dispensation_notes)
                                <div class="small text-info mt-1" title="{{ $credit->dispensation_notes }}">
                                    <x-icon name="badge-check" size="0.75rem" /> Dispensasi Aktif
                                </div>
                            @endif
                        </td>

                        <!-- Izin Booking -->
                        <td class="py-3">
                            @if($isLocked)
                                <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1">
                                    <x-icon name="ban" size="0.75rem" /> Booking Dikunci
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    <x-icon name="check" size="0.75rem" /> Izin Aktif
                                </span>
                            @endif
                        </td>

                        <!-- Aksi Terpadu -->
                        <td class="pe-3 py-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.customers.corporate.show', $company->id) }}" class="btn btn-outline-primary btn-sm shadow-xs" title="Buka Detail Lengkap 360°">
                                    Detail 360°
                                </a>

                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-light btn-sm border shadow-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opsi
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <!-- Tahap 1: Validasi Maker -->
                                        <li>
                                            <button class="dropdown-item py-2 small" type="button" data-bs-toggle="modal" data-bs-target="#makerModal{{ $company->id }}">
                                                <x-icon name="file-check" size="0.85rem" class="me-2 text-warning" /> [Tahap 1] Validasi Legalitas (Maker)
                                            </button>
                                        </li>
                                        <!-- Tahap 2: Persetujuan Checker -->
                                        <li>
                                            <button class="dropdown-item py-2 small" type="button" data-bs-toggle="modal" data-bs-target="#checkerModal{{ $company->id }}">
                                                <x-icon name="shield-check" size="0.85rem" class="me-2 text-primary" /> [Tahap 2] Penetapan Plafon (Checker)
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <!-- Lock/Unlock Booking -->
                                        <li>
                                            <button class="dropdown-item py-2 small {{ $isLocked ? 'text-success' : 'text-danger' }}" type="button" data-bs-toggle="modal" data-bs-target="#lockModal{{ $company->id }}">
                                                <x-icon name="{{ $isLocked ? 'check-circle' : 'ban' }}" size="0.85rem" class="me-2" /> {{ $isLocked ? 'Buka Kunci Booking (Dispensasi)' : 'Kunci Izin Booking Kargo' }}
                                            </button>
                                        </li>
                                        <!-- Kirim SP WhatsApp -->
                                        <li>
                                            <button class="dropdown-item py-2 small text-warning" type="button" data-bs-toggle="modal" data-bs-target="#spModal{{ $company->id }}">
                                                <x-icon name="brand-whatsapp" size="0.85rem" class="me-2 text-success" /> Kirim Surat Peringatan (WhatsApp)
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- MODAL 1: Maker Validasi Legalitas -->
                    <div class="modal fade" id="makerModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
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
                                            <strong>{{ $company->company_name }}</strong><br>
                                            NIB: <code>{{ $company->nib }}</code> | NPWP: <code>{{ $company->npwp }}</code><br>
                                            PIC: {{ $company->pic_name }} ({{ $company->pic_phone }})
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
                    <div class="modal fade" id="checkerModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
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
                                            <strong>{{ $company->company_name }}</strong><br>
                                            Status Dokumen Maker: <strong>{{ $credit->kyc_status ?? 'PENDING' }}</strong><br>
                                            Catatan Maker: <em>{{ $credit->legality_notes ?? 'Belum ada catatan maker' }}</em>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Batas Plafon Kredit B2B (IDR) <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rp</span>
                                                <input type="number" step="1000000" name="credit_limit_amount" class="form-control" value="{{ $credit->credit_limit_amount ?? 500000000 }}" required>
                                            </div>
                                            <div class="form-text small">Nominal pagu kredit maksimum untuk penagihan berjangka.</div>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label small fw-bold">Term of Payment (TOP) <span class="text-danger">*</span></label>
                                                <select name="top_days" class="form-select form-select-sm" required>
                                                    <option value="14" {{ ($credit->top_days ?? 30) == 14 ? 'selected' : '' }}>14 Hari Kalender</option>
                                                    <option value="30" {{ ($credit->top_days ?? 30) == 30 ? 'selected' : '' }}>30 Hari Kalender (Standar)</option>
                                                    <option value="45" {{ ($credit->top_days ?? 30) == 45 ? 'selected' : '' }}>45 Hari Kalender</option>
                                                    <option value="60" {{ ($credit->top_days ?? 30) == 60 ? 'selected' : '' }}>60 Hari Kalender</option>
                                                    <option value="90" {{ ($credit->top_days ?? 30) == 90 ? 'selected' : '' }}>90 Hari (Prioritas Khusus)</option>
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
                                            <label class="form-label small fw-bold">Nomor Referensi Bank Guarantee (Jika Ada)</label>
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
                    <div class="modal fade" id="lockModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
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
                                            <p class="small text-muted mb-3">
                                                Mitra <strong>{{ $company->company_name }}</strong> saat ini terkunci. Memberikan dispensasi akan memulihkan izin pembuatan order booking petikemas baru bagi akun ini.
                                            </p>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Alasan Dispensasi Pemulihan <span class="text-danger">*</span></label>
                                                <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Telah ada surat pernyataan transfer bertahap dari Direktur Utama..." required></textarea>
                                            </div>
                                        @else
                                            <p class="small text-danger mb-3">
                                                Perhatian: Mengunci izin booking akan menolak semua pembuatan order pengiriman kargo baru dari mitra <strong>{{ $company->company_name }}</strong> secara instan.
                                            </p>
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
                    <div class="modal fade" id="spModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
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
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <x-icon name="building-2" size="2.5rem" class="text-secondary opacity-50 mb-2" />
                            <div class="fw-semibold">Tidak ada data mitra perusahaan yang sesuai dengan filter.</div>
                            <div class="small">Coba ubah kata kunci pencarian atau reset filter.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($companies->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan <strong>{{ $companies->firstItem() }}</strong> - <strong>{{ $companies->lastItem() }}</strong> dari <strong>{{ $companies->total() }}</strong> mitra
                </div>
                <div>
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
