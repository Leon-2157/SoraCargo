@extends('layouts.app')

@section('title', 'Pusat Darurat & Kendala (Incident Escalation)')

@section('content')
<!-- Page Header & Emergency Actions -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Pusat Darurat & Kendala Lapangan</h3>
            <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1">
                <x-icon name="shield-alert" size="0.85rem" class="me-1" /> Tanggap Risiko 24/7
            </span>
        </div>
        <p class="text-muted small mb-0">Disposisi cepat persetujuan biaya darurat hub, investigasi klaim kerusakan petikemas, dan kendali penahanan pelayaran cuaca buruk BMKG.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <button class="btn btn-outline-danger btn-sm shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#weatherHoldModal">
            <x-icon name="cloud-rain" size="0.9rem" class="me-1" /> Tahan Rute Pelayaran (BMKG Hold)
        </button>
    </div>
</div>

<!-- Notification / Flash Alerts -->
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
                <strong>Terjadi Kendala:</strong>
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

<!-- Active BMKG Weather Hold Warning Banner -->
@if($activeWeatherHoldRoutes->count() > 0)
    <div class="card border-danger bg-danger-subtle shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-danger text-white rounded-circle me-3">
                        <x-icon name="cloud-rain" size="1.25rem" />
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-danger">PERINGATAN DARURAT BMKG MARITIM AKTIF (WEATHER HOLD)</h6>
                        <div class="text-danger-emphasis small mt-1">
                            Sebanyak <strong>{{ $activeWeatherHoldRoutes->count() }} rute pelayaran</strong> saat ini ditahan dari keberangkatan akibat cuaca ekstrem / gelombang tinggi di laut lepas:
                            <span class="fw-bold">
                                @foreach($activeWeatherHoldRoutes as $wRoute)
                                    [{{ $wRoute->origin_port_id }} &rarr; {{ $wRoute->destination_port_id }}]{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#weatherHoldModal">
                        <x-icon name="sliders-horizontal" size="0.85rem" class="me-1" /> Kelola Rute Ditahan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Radar KPI Summary Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Pending Action Tickets -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-danger shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-danger fw-bold text-xs mb-1">Tiket Menunggu Tindakan</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $pendingCount }} Kasus</div>
                        <div class="text-muted text-xs mt-1">
                            <span class="text-danger fw-semibold"><x-icon name="alert-triangle" size="0.75rem" /> Mendesak:</span> Butuh keputusan Superadmin
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-danger-subtle p-3 rounded-circle text-danger">
                            <x-icon name="alert-triangle" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Pending Funds Requested -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-warning shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Dana Lapangan Diajukan</div>
                        <div class="text-dark fw-bold h4 mb-0">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</div>
                        <div class="text-muted text-xs mt-1">
                            Talangan kasbon dermaga & klaim
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-warning-subtle p-3 rounded-circle text-warning">
                            <x-icon name="wallet" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Weather Hold Active Routes -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-info shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Rute Ditahan Cuaca (BMKG)</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $weatherHoldRoutesCount }} Rute Laut</div>
                        <div class="text-muted text-xs mt-1">
                            Keberangkatan ditunda sementara
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-info-subtle p-3 rounded-circle text-info">
                            <x-icon name="cloud-rain" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Average SLA Response -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-success shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Rata-rata Waktu Respon</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $avgSlaMinutes }} Menit</div>
                        <div class="text-muted text-xs mt-1">
                            <span class="text-success fw-semibold">&lt; 30 Menit:</span> Standar toleransi maritim
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-success-subtle p-3 rounded-circle text-success">
                            <x-icon name="clock" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card: Incident Escalation Register -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold">
            <x-icon name="shield-alert" class="me-2" />Daftar Eskalasi Insiden Maritim & Lapangan
        </h6>
        <span class="badge bg-light text-primary border">Total {{ $totalCount }} Kasus Terekam</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters (Semua, Biaya Lapangan, Klaim Rusak, Cuaca BMKG, Pelanggaran SLA) -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="escalationTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($type) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.escalations.index', array_filter(['status' => $status, 'search' => $search])) }}">
                    Semua Insiden ({{ $totalCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'FIELD_COST' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.escalations.index', array_filter(['type' => 'FIELD_COST', 'status' => $status, 'search' => $search])) }}">
                    <x-icon name="wallet" class="me-1" /> Biaya Lapangan ({{ $fieldCostCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'DAMAGE_CLAIM' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.escalations.index', array_filter(['type' => 'DAMAGE_CLAIM', 'status' => $status, 'search' => $search])) }}">
                    <x-icon name="alert-triangle" class="me-1" /> Klaim Rusak ({{ $damageClaimCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'WEATHER_HOLD' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.escalations.index', array_filter(['type' => 'WEATHER_HOLD', 'status' => $status, 'search' => $search])) }}">
                    <x-icon name="cloud-rain" class="me-1" /> Cuaca BMKG ({{ $weatherHoldCount }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type === 'SLA_BREACH' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.escalations.index', array_filter(['type' => 'SLA_BREACH', 'status' => $status, 'search' => $search])) }}">
                    <x-icon name="clock" class="me-1" /> Pelanggaran SLA ({{ $slaBreachCount }})
                </a>
            </li>
        </ul>

        <!-- Filter & Search Controls -->
        <form method="GET" action="{{ route('admin.escalations.index') }}" class="row mb-3 g-2">
            @if(!empty($type))
                <input type="hidden" name="type" value="{{ $type }}">
            @endif
            <div class="col-md-4 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Status:</label>
                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" {{ empty($status) || $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="PENDING_REVIEW" {{ $status === 'PENDING_REVIEW' ? 'selected' : '' }}>Menunggu Review</option>
                        <option value="APPROVED_BY_ADMIN" {{ $status === 'APPROVED_BY_ADMIN' ? 'selected' : '' }}>Disetujui Admin</option>
                        <option value="INSURANCE_PROCESSED" {{ $status === 'INSURANCE_PROCESSED' ? 'selected' : '' }}>Proses Asuransi</option>
                        <option value="REJECTED" {{ $status === 'REJECTED' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari nomor tiket, resi muatan, nama pelapor..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                    @if(!empty($search) || (!empty($status) && $status !== 'all'))
                        <a href="{{ route('admin.escalations.index', array_filter(['type' => $type])) }}" class="btn btn-outline-danger" title="Reset Filter">
                            <x-icon name="x" />
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Responsive Escalations Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0">
                <thead class="table-light">
                    <tr>
                        <th>Tiket & Waktu</th>
                        <th>Resi & Rute Muatan</th>
                        <th>Pelapor & Hub</th>
                        <th>Jenis Insiden</th>
                        <th>Nominal Diajukan</th>
                        <th>Dokumen BAP</th>
                        <th>Status Verifikasi</th>
                        <th class="text-center">Aksi Review</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($escalations as $item)
                        @php
                            $booking = $item->cargoBooking;
                            $route = $booking ? $booking->route : null;
                            $reporter = $item->reporter;
                            $reporterUser = $reporter ? $reporter->user : null;
                            $reporterHub = $reporter ? $reporter->hub : null;
                            $avatarIndex = (abs(crc32($reporter ? $reporter->id : '0')) % 5) + 1;
                        @endphp
                        <tr>
                            <!-- 1. Tiket & Waktu -->
                            <td>
                                <div class="fw-bold font-monospace text-dark">{{ $item->incident_ticket_no }}</div>
                                <div class="text-muted text-xs">
                                    <x-icon name="clock" size="0.75rem" class="me-1" />
                                    {{ $item->created_at ? $item->created_at->diffForHumans() : '-' }}
                                </div>
                            </td>

                            <!-- 2. Resi & Rute -->
                            <td>
                                @if($booking)
                                    <div class="fw-bold text-primary font-monospace">{{ $booking->tracking_number }}</div>
                                    <div class="text-muted text-xs">
                                        {{ $booking->shipper ? $booking->shipper->name : '-' }}
                                    </div>
                                    @if($route)
                                        <div class="small mt-1">
                                            <span class="badge bg-light text-dark border">
                                                {{ $route->origin_port_id }} &rarr; {{ $route->destination_port_id }}
                                            </span>
                                            <span class="text-muted text-xs ms-1">({{ number_format($booking->total_weight_kg, 0, ',', '.') }} kg)</span>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- 3. Pelapor & Hub -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-2" width="32" height="32" src="{{ asset("assets/img/avatars/avatar{$avatarIndex}.jpeg") }}" alt="Avatar">
                                    <div>
                                        <div class="fw-semibold text-dark small">{{ $reporterUser ? $reporterUser->name : 'Operator Lapangan' }}</div>
                                        <div class="text-muted text-xs">{{ $reporterHub ? $reporterHub->name : '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- 4. Jenis Insiden -->
                            <td>
                                @if($item->incident_type === 'DAMAGE_CLAIM')
                                    <span class="badge bg-danger text-white">
                                        <x-icon name="alert-triangle" size="0.75rem" class="me-1" /> Klaim Kerusakan
                                    </span>
                                @elseif($item->incident_type === 'FIELD_COST')
                                    <span class="badge bg-purple text-white" style="background-color: #7c3aed;">
                                        <x-icon name="wallet" size="0.75rem" class="me-1" /> Biaya Lapangan
                                    </span>
                                @elseif($item->incident_type === 'WEATHER_HOLD')
                                    <span class="badge bg-info text-white">
                                        <x-icon name="cloud-rain" size="0.75rem" class="me-1" /> Cuaca BMKG
                                    </span>
                                @elseif($item->incident_type === 'SLA_BREACH')
                                    <span class="badge bg-warning text-dark">
                                        <x-icon name="clock" size="0.75rem" class="me-1" /> Pelanggaran SLA
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->incident_type }}</span>
                                @endif
                            </td>

                            <!-- 5. Nominal Diajukan -->
                            <td>
                                @if($item->requested_amount > 0)
                                    <div class="fw-bold text-dark font-monospace">Rp {{ number_format($item->requested_amount, 0, ',', '.') }}</div>
                                    <div class="text-muted text-xs">Dana Talangan</div>
                                @else
                                    <span class="badge bg-light text-secondary border">Hold Pelayaran</span>
                                @endif
                            </td>

                            <!-- 6. Dokumen BAP -->
                            <td>
                                @if(!empty($item->bap_document_path))
                                    <span class="badge bg-light text-primary border">
                                        <x-icon name="file-text" size="0.75rem" class="me-1" /> BAP Terlampir
                                    </span>
                                    <div class="text-muted text-xs font-monospace mt-1">{{ Str::limit($item->bap_document_path, 20) }}</div>
                                @else
                                    <span class="text-muted text-xs">Tanpa Berkas</span>
                                @endif
                            </td>

                            <!-- 7. Status Verifikasi -->
                            <td>
                                @if($item->approval_status === 'PENDING_REVIEW')
                                    <span class="badge badge-pending">
                                        <x-icon name="clock" size="0.75rem" class="me-1" /> PENDING_REVIEW
                                    </span>
                                    <div class="text-muted text-xs mt-1">SLA: {{ $item->sla_response_minutes }} Menit</div>
                                @elseif($item->approval_status === 'APPROVED_BY_ADMIN')
                                    <span class="badge badge-active">
                                        <x-icon name="check-circle" size="0.75rem" class="me-1" /> APPROVED
                                    </span>
                                    <div class="text-muted text-xs mt-1">Disetujui Admin</div>
                                @elseif($item->approval_status === 'INSURANCE_PROCESSED')
                                    <span class="badge bg-primary text-white">
                                        <x-icon name="shield-check" size="0.75rem" class="me-1" /> ASURANSI
                                    </span>
                                    <div class="text-muted text-xs mt-1">Klaim Asuransi</div>
                                @elseif($item->approval_status === 'REJECTED')
                                    <span class="badge badge-suspended">
                                        <x-icon name="ban" size="0.75rem" class="me-1" /> REJECTED
                                    </span>
                                    <div class="text-muted text-xs mt-1">Ditolak</div>
                                @else
                                    <span class="badge bg-secondary">{{ $item->approval_status }}</span>
                                @endif
                            </td>

                            <!-- 8. Aksi Review Superadmin -->
                            <td class="text-center">
                                @if($item->approval_status === 'PENDING_REVIEW')
                                    <button class="btn btn-sm btn-primary shadow-sm" type="button" 
                                        onclick="openReviewModal(
                                            '{{ $item->id }}',
                                            '{{ $item->incident_ticket_no }}',
                                            '{{ $booking ? $booking->tracking_number : '-' }}',
                                            '{{ $reporterUser ? $reporterUser->name : '-' }} ({{ $reporterHub ? $reporterHub->name : '-' }})',
                                            '{{ $item->incident_type }}',
                                            '{{ $item->requested_amount }}',
                                            '{{ addslashes($item->admin_notes ?? '') }}',
                                            '{{ $item->bap_document_path ?? '-' }}'
                                        )">
                                        <x-icon name="clipboard-check" size="0.85rem" class="me-1" /> Tinjau & Putuskan
                                    </button>
                                @else
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <x-icon name="more-horizontal" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <button class="dropdown-item" type="button" onclick="alert('Catatan Disposisi: {{ addslashes($item->admin_notes ?? 'Tidak ada catatan') }}')">
                                                    <x-icon name="file-text" class="me-2 text-primary" />Lihat Catatan Disposisi
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <x-icon name="shield-check" size="2.5rem" class="mb-2 text-success opacity-50" />
                                    <div class="fw-bold">Tidak ada insiden darurat yang ditemukan</div>
                                    <div class="small">Semua proses operasional maritim berjalan kondusif sesuai standar operasional.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="row mt-4 align-items-center">
            <div class="col-md-6">
                <p class="text-muted small mb-0">
                    Menampilkan {{ $escalations->firstItem() ?? 0 }} sampai {{ $escalations->lastItem() ?? 0 }} dari {{ $escalations->total() }} insiden terekam
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                {{ $escalations->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: REVIEW & DISPOSITION INCIDENT -->
<div class="modal fade" id="reviewIncidentModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="reviewModalLabel">
                    <x-icon name="clipboard-check" class="me-2" />Tinjau & Putuskan Insiden: <span id="modalTicketTitle" class="font-monospace"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Case Summary Header Card -->
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body p-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="text-muted text-xs">Nomor Resi / Kargo:</div>
                                <div class="fw-bold text-dark font-monospace" id="modalBooking"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted text-xs">Operator Pelapor & Hub:</div>
                                <div class="fw-semibold text-dark" id="modalReporter"></div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="text-muted text-xs">Klasifikasi Insiden:</div>
                                <div class="fw-bold" id="modalTypeBadge"></div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="text-muted text-xs">Nominal Diajukan Lapangan:</div>
                                <div class="fw-bold text-danger font-monospace h5 mb-0" id="modalRequestedAmountText"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAP Document Preview Section -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Dokumen Berita Acara Pemeriksaan (BAP)</label>
                    <div class="p-3 border rounded bg-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <x-icon name="file-text" size="1.5rem" class="text-danger me-2" />
                            <div>
                                <div class="fw-bold text-dark small" id="modalBapPath"></div>
                                <div class="text-muted text-xs">Dokumen Resmi Ditandatangani Operator & Petugas Hub</div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="alert('Membuka pratinjau dokumen BAP terverifikasi...')">
                            <x-icon name="eye" size="0.85rem" class="me-1" /> Lihat Dokumen
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Kronologi / Catatan Lapangan Operator</label>
                    <div class="p-2 border rounded bg-light small" id="modalDescription"></div>
                </div>

                <!-- Action Forms Container -->
                <hr class="my-3">
                <h6 class="fw-bold text-dark mb-3">Keputusan Superadmin</h6>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nominal Persetujuan Pencairan Dana (Rp)</label>
                    <input type="number" id="modalApprovedAmountInput" class="form-control form-control-sm font-monospace" step="1000">
                    <div class="form-text text-xs">Dapat disesuaikan jika nominal disetujui sebagian dari total pengajuan awal.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Catatan Disposisi & Instruksi Admin <span class="text-danger">*</span></label>
                    <textarea id="modalAdminNotesInput" class="form-control form-control-sm" rows="3" placeholder="Masukkan instruksi penanganan untuk operator dermaga atau pihak keuangan..." required></textarea>
                </div>
            </div>

            <!-- Footer with 3 Action Buttons -->
            <div class="modal-footer bg-light d-flex justify-content-between flex-wrap gap-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <div class="d-flex gap-2">
                    <!-- Reject Form Button -->
                    <form id="rejectForm" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan insiden ini?')">
                        @csrf
                        <input type="hidden" name="admin_notes" id="rejectNotesHidden">
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="syncNotes('reject')">
                            <x-icon name="ban" class="me-1" /> Tolak
                        </button>
                    </form>

                    <!-- Escalate Insurance Form Button -->
                    <form id="insuranceForm" method="POST" class="d-inline" onsubmit="return confirm('Alihkan penanganan insiden ini ke Klaim Asuransi Maritim?')">
                        @csrf
                        <input type="hidden" name="admin_notes" id="insuranceNotesHidden">
                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="syncNotes('insurance')">
                            <x-icon name="shield-check" class="me-1" /> Alihkan ke Asuransi
                        </button>
                    </form>

                    <!-- Approve Form Button -->
                    <form id="approveForm" method="POST" class="d-inline" onsubmit="return confirm('Setujui pengajuan insiden dan cairkan dana ke kasbon operasional hub?')">
                        @csrf
                        <input type="hidden" name="approved_amount" id="approveAmountHidden">
                        <input type="hidden" name="admin_notes" id="approveNotesHidden">
                        <button type="submit" class="btn btn-sm btn-success" onclick="syncNotes('approve')">
                            <x-icon name="check-circle" class="me-1" /> Setujui & Cairkan Kasbon
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: BMKG WEATHER HOLD EMERGENCY PROTOCOL -->
<div class="modal fade" id="weatherHoldModal" tabindex="-1" aria-labelledby="weatherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="weatherModalLabel">
                    <x-icon name="cloud-rain" class="me-2" />Protokol Darurat: Tahan Rute (BMKG Weather Hold)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.escalations.weather_hold') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-danger small py-2 mb-3">
                        <x-icon name="alert-triangle" class="me-1" />
                        <strong>Peringatan Keselamatan Maritim KSOP:</strong> Mengaktifkan <em>Weather Hold</em> akan membekukan seluruh jadwal pelayaran pada rute bersangkutan dan mengalihkan status seluruh kargo aktif ke status <code>WEATHER_HOLD</code>.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Rute Pelayaran / Ekspedisi <span class="text-danger">*</span></label>
                        <select name="route_id" class="form-select form-select-sm" required>
                            <option value="" disabled selected>-- Pilih Rute Maritim --</option>
                            @foreach($allRoutes as $r)
                                <option value="{{ $r->id }}">
                                    {{ $r->originPort->name }} ({{ $r->origin_port_id }}) &rarr; {{ $r->destinationPort->name }} ({{ $r->destination_port_id }})
                                    [{{ $r->transport_mode }}]
                                    {{ $r->is_weather_hold ? '🔴 SAAT INI DITAHAN' : '🟢 NORMAL' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Maklumat Cuaca BMKG / Alasan Penahanan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Peringatan Gelombang Tinggi BMKG Maritim No. ME-04/11 Selat Karimata 3.5 - 4.0 Meter. Penundaan SPB oleh Syahbandar Pelabuhan." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <x-icon name="shield-alert" class="me-1" /> Perbarui Status Tahan Rute
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentIncidentId = '';

function openReviewModal(id, ticketNo, bookingNo, reporterName, type, amount, description, bapPath) {
    currentIncidentId = id;
    document.getElementById('modalTicketTitle').innerText = ticketNo;
    document.getElementById('modalBooking').innerText = bookingNo;
    document.getElementById('modalReporter').innerText = reporterName;
    document.getElementById('modalTypeBadge').innerText = type;
    document.getElementById('modalRequestedAmountText').innerText = amount > 0 ? 'Rp ' + Number(amount).toLocaleString('id-ID') : 'Rp 0 (Hold Rute)';
    document.getElementById('modalBapPath').innerText = bapPath;
    document.getElementById('modalDescription').innerText = description || 'Tidak ada catatan kronologi tambahan dari operator.';

    document.getElementById('modalApprovedAmountInput').value = amount;
    document.getElementById('modalAdminNotesInput').value = '';

    // Set action URLs for the 3 forms
    document.getElementById('approveForm').action = '/admin/escalations/' + id + '/approve';
    document.getElementById('rejectForm').action = '/admin/escalations/' + id + '/reject';
    document.getElementById('insuranceForm').action = '/admin/escalations/' + id + '/insurance';

    const modal = new bootstrap.Modal(document.getElementById('reviewIncidentModal'));
    modal.show();
}

function syncNotes(actionType) {
    const notes = document.getElementById('modalAdminNotesInput').value || 'Disposisi Superadmin';
    const amount = document.getElementById('modalApprovedAmountInput').value || 0;

    if (actionType === 'approve') {
        document.getElementById('approveAmountHidden').value = amount;
        document.getElementById('approveNotesHidden').value = notes;
    } else if (actionType === 'reject') {
        document.getElementById('rejectNotesHidden').value = notes;
    } else if (actionType === 'insurance') {
        document.getElementById('insuranceNotesHidden').value = notes;
    }
}
</script>
@endsection

