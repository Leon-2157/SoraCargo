@extends('layouts.app')

@section('title', 'Rekening Bersama & Escrow')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Rekening Bersama &amp; Escrow</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="vault" size="0.85rem" class="me-1" /> Governance Keuangan
            </span>
        </div>
        <p class="text-muted small mb-0">Tata kelola dana penampungan konsumen, rilis bertahap termin pelayaran (30% - 40% - 30%), bagi hasil platform SoraCargo, dan mitigasi penahanan sengketa.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <span class="badge bg-light text-secondary border d-flex align-items-center px-3 py-2">
            <x-icon name="shield-check" class="text-success me-2" /> Otorisasi Hibrida: Otomatis &amp; Superadmin Override
        </span>
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
    <!-- Card 1: Escrow Held -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Dana Escrow Mengendap</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalEscrowHeld, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">Penampungan dana aktif konsumen</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="vault" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Released to Operators -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Rilis Sukses ke Operator</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalReleasedToOperators, 0, ',', '.') }}</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Termin M1/M2/M3 Terbayar</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="wallet" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Platform Profit -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Laba Bersih SoraCargo</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalPlatformProfit, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">Rata-rata Platform Fee: 12.5%</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="coins" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Dispute Frozen -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-danger fw-bold text-xs mb-1">Saldo Dibekukan (Dispute)</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalDisputeFrozen, 0, ',', '.') }}</div>
                        <span class="text-danger text-xs fw-semibold"><x-icon name="alert-triangle" size="0.75rem" /> {{ $disputeCount }} Kasus Ditahan</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="shield-alert" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold d-flex align-items-center">
            <x-icon name="landmark" class="me-2" />Daftar Rekening Bersama &amp; Pembagian Bagi Hasil
        </h6>
        <span class="badge bg-light text-primary border">Sistem Escrow Multi-Milestone</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="escrowFilterTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'all' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.finance.escrow', ['filter' => 'all', 'search' => $search]) }}">
                    <x-icon name="layers" class="me-1" /> Semua Rekening ({{ $counts['all'] }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'held' ? 'active' : '' }} py-1 px-3 small fw-bold text-primary" href="{{ route('admin.finance.escrow', ['filter' => 'held', 'search' => $search]) }}">
                    <x-icon name="clock" class="me-1" /> Dana Mengendap ({{ $counts['held'] }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'partial' ? 'active' : '' }} py-1 px-3 small fw-bold text-info" href="{{ route('admin.finance.escrow', ['filter' => 'partial', 'search' => $search]) }}">
                    <x-icon name="refresh-cw" class="me-1" /> Rilis Bertahap ({{ $counts['partial'] }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'settled' ? 'active' : '' }} py-1 px-3 small fw-bold text-success" href="{{ route('admin.finance.escrow', ['filter' => 'settled', 'search' => $search]) }}">
                    <x-icon name="check-circle" class="me-1" /> Lunas Selesai ({{ $counts['settled'] }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $filter === 'frozen' ? 'active' : '' }} py-1 px-3 small fw-bold text-danger" href="{{ route('admin.finance.escrow', ['filter' => 'frozen', 'search' => $search]) }}">
                    <x-icon name="shield-alert" class="me-1" /> Dibekukan ({{ $counts['frozen'] }})
                </a>
            </li>
        </ul>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.finance.escrow') }}" class="row mb-3 g-2">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <div class="col-md-9 col-lg-10">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari nomor resi / booking, nama pengirim, atau nama perusahaan..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                @if($search)
                    <a href="{{ route('admin.finance.escrow', ['filter' => $filter]) }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- Escrow Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="escrowTable">
                <thead class="table-light">
                    <tr>
                        <th>Resi &amp; Booking</th>
                        <th>Pengirim / Klien</th>
                        <th>Mitra Operator</th>
                        <th>Nilai Escrow</th>
                        <th>Progres Rilis Termin</th>
                        <th>Bagi Hasil SoraCargo</th>
                        <th>Status Escrow</th>
                        <th class="text-center">Aksi Superadmin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($escrows as $item)
                        @php
                            $booking = $item->cargoBooking;
                            $split = $booking?->revenueSplit;
                            $m1Released = !is_null($item->milestone_1_released_at);
                            $m2Released = !is_null($item->milestone_2_released_at);
                            $m3Released = !is_null($item->milestone_3_released_at);
                        @endphp
                        <tr>
                            <!-- 1. Resi & Booking -->
                            <td>
                                <div class="fw-bold text-primary font-monospace">{{ $booking?->tracking_number ?? 'N/A' }}</div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <span class="badge bg-light text-secondary border text-xs">{{ $booking?->booking_type ?? 'RETAIL' }}</span>
                                    <span class="text-muted text-xs">{{ $item->created_at?->format('d M Y') }}</span>
                                </div>
                            </td>

                            <!-- 2. Pengirim / Klien -->
                            <td>
                                @if($booking?->company)
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        <x-icon name="building-2" size="0.85rem" class="text-primary me-1" />
                                        {{ $booking->company->company_name }}
                                    </div>
                                    <div class="text-muted text-xs">PIC: {{ $booking->shipper?->name ?? 'N/A' }}</div>
                                @else
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        <x-icon name="user" size="0.85rem" class="text-secondary me-1" />
                                        {{ $booking?->shipper?->name ?? 'Pengirim Retail' }}
                                    </div>
                                    <div class="text-muted text-xs">{{ $booking?->shipper?->email ?? '-' }}</div>
                                @endif
                                <div class="text-xs text-muted mt-1">
                                    <x-icon name="map-pin" size="0.75rem" /> {{ $booking?->route?->origin_port_code ?? 'CGK' }} &rarr; {{ $booking?->route?->destination_port_code ?? 'SUB' }}
                                </div>
                            </td>

                            <!-- 3. Mitra Operator -->
                            <td>
                                @if($booking?->assignedOperator)
                                    <div class="fw-semibold text-dark d-flex align-items-center">
                                        <x-icon name="ship" size="0.85rem" class="text-info me-1" />
                                        {{ $booking->assignedOperator->company?->company_name ?? $booking->assignedOperator->user?->name }}
                                    </div>
                                    <div class="text-muted text-xs">Armada: {{ $booking->assignedOperator->fleet_type ?? 'Kapal Kargo' }}</div>
                                @else
                                    <span class="badge bg-light text-muted border">Belum Ditugaskan</span>
                                @endif
                            </td>

                            <!-- 4. Nilai Escrow -->
                            <td>
                                <div class="fw-bold text-dark">Rp {{ number_format($item->total_paid_amount, 0, ',', '.') }}</div>
                                <span class="badge bg-light text-muted border text-xs">100% Prepaid Safe</span>
                            </td>

                            <!-- 5. Progres Rilis Termin (M1, M2, M3) -->
                            <td style="min-width: 220px;">
                                <div class="d-flex justify-content-between text-xs fw-semibold mb-1">
                                    <span class="{{ $m1Released ? 'text-success' : 'text-muted' }}">M1 30%</span>
                                    <span class="{{ $m2Released ? 'text-success' : 'text-muted' }}">M2 40%</span>
                                    <span class="{{ $m3Released ? 'text-success' : 'text-muted' }}">M3 30%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $m1Released ? 'bg-success' : 'bg-light border' }}" role="progressbar" style="width: 30%" title="Milestone 1: Gate-In"></div>
                                    <div class="progress-bar {{ $m2Released ? 'bg-success' : 'bg-light border' }}" role="progressbar" style="width: 40%" title="Milestone 2: Sailing"></div>
                                    <div class="progress-bar {{ $m3Released ? 'bg-success' : 'bg-light border' }}" role="progressbar" style="width: 30%" title="Milestone 3: Delivered"></div>
                                </div>
                                <div class="d-flex justify-content-between text-xs text-muted mt-1">
                                    <span>{{ $m1Released ? 'Gate-In OK' : 'Pending' }}</span>
                                    <span>{{ $m2Released ? 'Sailing OK' : 'Pending' }}</span>
                                    <span>{{ $m3Released ? 'Delivered OK' : 'Pending' }}</span>
                                </div>
                            </td>

                            <!-- 6. Bagi Hasil SoraCargo & Operator -->
                            <td>
                                @if($split)
                                    <div class="text-xs">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Net Profit:</span>
                                            <strong class="text-info">Rp {{ number_format($split->net_platform_profit, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Hak Operator:</span>
                                            <strong class="text-dark">Rp {{ number_format($split->operator_share_amount, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted text-xs fst-italic">Kalkulasi Otomatis</span>
                                @endif
                            </td>

                            <!-- 7. Status Escrow -->
                            <td>
                                @if($item->escrow_status === 'HELD_IN_ESCROW')
                                    <span class="badge bg-primary text-white">
                                        <x-icon name="lock" size="0.75rem" class="me-1" /> Mengendap Penuh
                                    </span>
                                @elseif($item->escrow_status === 'PARTIALLY_RELEASED')
                                    <span class="badge bg-info text-dark">
                                        <x-icon name="refresh-cw" size="0.75rem" class="me-1" /> Rilis Bertahap
                                    </span>
                                @elseif($item->escrow_status === 'SETTLED')
                                    <span class="badge bg-success text-white">
                                        <x-icon name="check-circle" size="0.75rem" class="me-1" /> Lunas Selesai
                                    </span>
                                @elseif($item->escrow_status === 'DISPUTE_FROZEN')
                                    <span class="badge bg-danger text-white">
                                        <x-icon name="shield-alert" size="0.75rem" class="me-1" /> Dibekukan
                                    </span>
                                @elseif($item->escrow_status === 'REFUNDED_SETTLED')
                                    <span class="badge bg-secondary text-white">
                                        <x-icon name="coins" size="0.75rem" class="me-1" /> Refund Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white">{{ $item->escrow_status }}</span>
                                @endif
                            </td>

                            <!-- 8. Aksi Superadmin -->
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Kelola
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Otorisasi Finansial</h6></li>
                                        <li>
                                            <button class="dropdown-item small text-primary" type="button"
                                                onclick="openForceReleaseModal('{{ $item->id }}', '{{ $booking?->tracking_number }}', {{ $m1Released ? 'true' : 'false' }}, {{ $m2Released ? 'true' : 'false' }}, {{ $m3Released ? 'true' : 'false' }})">
                                                <x-icon name="wallet" class="me-2" size="0.85rem" /> Rilis Manual Termin
                                            </button>
                                        </li>
                                        @if($item->escrow_status === 'DISPUTE_FROZEN')
                                            <li>
                                                <button class="dropdown-item small text-success" type="button"
                                                    onclick="openToggleFreezeModal('{{ $item->id }}', '{{ $booking?->tracking_number }}', 'UNFREEZE')">
                                                    <x-icon name="unlock" class="me-2" size="0.85rem" /> Buka Gembok Sengketa
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item small text-danger fw-bold" type="button"
                                                    onclick="openDisputeModal('{{ $item->id }}', '{{ $booking?->tracking_number }}', '{{ $item->total_paid_amount }}')">
                                                    <x-icon name="gavel" class="me-2" size="0.85rem" /> Resolusi Sengketa (Refund/Klaim)
                                                </button>
                                            </li>
                                        @else
                                            <li>
                                                <button class="dropdown-item small text-danger" type="button"
                                                    onclick="openToggleFreezeModal('{{ $item->id }}', '{{ $booking?->tracking_number }}', 'FREEZE')">
                                                    <x-icon name="shield-alert" class="me-2" size="0.85rem" /> Bekukan Saldo (Dispute)
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <x-icon name="vault" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada catatan transaksi rekening bersama pada kriteria ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($escrows->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $escrows->firstItem() }} - {{ $escrows->lastItem() }} dari {{ $escrows->total() }} rekening
                </div>
                <div>
                    {{ $escrows->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL 1: Force-Release Milestone Override -->
<div class="modal fade" id="forceReleaseModal" tabindex="-1" aria-labelledby="forceReleaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="forceReleaseForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="forceReleaseModalLabel">
                        <x-icon name="wallet" class="me-2" /> Otorisasi Rilis Manual Termin
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border small text-muted mb-3">
                        Otorisasi ini melewati trigger status otomatis dan mencairkan hak dana operator secara langsung atas izin Superadmin.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nomor Resi / Booking</label>
                        <input type="text" id="modalReleaseTracking" class="form-control form-control-sm font-monospace" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Pilih Termin Pencairan <span class="text-danger">*</span></label>
                        <select name="milestone" id="modalMilestoneSelect" class="form-select form-select-sm" required>
                            <option value="1" id="optMilestone1">Termin 1 (30% - Saat Kargo Tiba di Depo / Gate-In)</option>
                            <option value="2" id="optMilestone2">Termin 2 (40% - Saat Kapal Berlayar / Sailing)</option>
                            <option value="3" id="optMilestone3">Termin 3 (30% - Saat Kargo Diterima / Delivered Settlement)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Alasan Override Superadmin <span class="text-danger">*</span></label>
                        <textarea name="override_reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Bukti Surat Jalan (POD) telah divalidasi manual via WhatsApp oleh Supervisor Finance..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Konfirmasi Pencairan Dana
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Toggle Freeze / Unfreeze -->
<div class="modal fade" id="toggleFreezeModal" tabindex="-1" aria-labelledby="toggleFreezeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="toggleFreezeForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header text-white" id="freezeHeader">
                    <h5 class="modal-title fw-bold" id="toggleFreezeModalLabel">
                        <x-icon name="shield-alert" class="me-2" /> Gembok Saldo Escrow
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="freezeActionInput" value="FREEZE">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nomor Resi / Booking</label>
                        <input type="text" id="freezeTrackingInput" class="form-control form-control-sm font-monospace" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Alasan Tindakan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Jelaskan dasar pembekuan atau pembukaan gembok dana..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm" id="freezeSubmitBtn">Konfirmasi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 3: Comprehensive Dispute Resolution -->
<div class="modal fade" id="disputeResolutionModal" tabindex="-1" aria-labelledby="disputeResolutionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="disputeResolutionForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="disputeResolutionModalLabel">
                        <x-icon name="gavel" class="me-2" /> Sidang Resolusi Sengketa Rekening Bersama
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nomor Resi / Booking</label>
                            <input type="text" id="disputeTrackingInput" class="form-control form-control-sm font-monospace" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Total Dana Tertahan di Escrow</label>
                            <input type="text" id="disputeTotalEscrowInput" class="form-control form-control-sm fw-bold text-danger" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Pilihan Putusan Superadmin <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="form-check border rounded p-3 h-100 bg-light">
                                    <input class="form-check-input" type="radio" name="resolution_type" id="resRefund" value="REFUND_TO_SHIPPER" checked>
                                    <label class="form-check-label fw-bold small text-dark" for="resRefund">
                                        <x-icon name="coins" class="text-danger me-1" /> Refund Pengirim
                                    </label>
                                    <p class="text-xs text-muted mb-0 mt-1">Kembalikan dana ke saldo konsumen akibat kelalaian kargo/rusak.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check border rounded p-3 h-100 bg-light">
                                    <input class="form-check-input" type="radio" name="resolution_type" id="resPayout" value="PAYOUT_TO_OPERATOR">
                                    <label class="form-check-label fw-bold small text-dark" for="resPayout">
                                        <x-icon name="wallet" class="text-success me-1" /> Payout Operator
                                    </label>
                                    <p class="text-xs text-muted mb-0 mt-1">Cairkan sisa saldo ke operator pelayaran setelah investigasi aman.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check border rounded p-3 h-100 bg-light">
                                    <input class="form-check-input" type="radio" name="resolution_type" id="resInsurance" value="ESCALATE_INSURANCE">
                                    <label class="form-check-label fw-bold small text-dark" for="resInsurance">
                                        <x-icon name="shield" class="text-info me-1" /> Klaim Asuransi
                                    </label>
                                    <p class="text-xs text-muted mb-0 mt-1">Alihkan klaim ke pihak asuransi rekanan kargo SoraCargo.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nominal Penyesuaian / Ganti Rugi (Rp)</label>
                        <input type="number" step="0.01" name="adjustment_amount" id="disputeAdjustAmount" class="form-control form-control-sm" placeholder="Opsional jika refund sebagian">
                        <span class="text-xs text-muted">Kosongkan jika melakukan refund 100% penuh.</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Catatan Berita Acara &amp; Dasar Putusan <span class="text-danger">*</span></label>
                        <textarea name="resolution_notes" class="form-control form-control-sm" rows="3" placeholder="Tuliskan nomor BAP, hasil mediasi antara Pengirim dan Operator, serta persetujuan direksi..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <x-icon name="gavel" class="me-1" /> Eksekusi Putusan Sengketa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openForceReleaseModal(id, tracking, m1, m2, m3) {
        document.getElementById('forceReleaseForm').action = '/admin/finance/escrow/' + id + '/release';
        document.getElementById('modalReleaseTracking').value = tracking;
        
        var select = document.getElementById('modalMilestoneSelect');
        var opt1 = document.getElementById('optMilestone1');
        var opt2 = document.getElementById('optMilestone2');
        var opt3 = document.getElementById('optMilestone3');

        opt1.disabled = m1;
        opt1.text = 'Termin 1 (30% - Gate-In) ' + (m1 ? '[SUDAH DICAIRKAN]' : '');
        opt2.disabled = m2;
        opt2.text = 'Termin 2 (40% - Sailing) ' + (m2 ? '[SUDAH DICAIRKAN]' : '');
        opt3.disabled = m3;
        opt3.text = 'Termin 3 (30% - Delivered) ' + (m3 ? '[SUDAH DICAIRKAN]' : '');

        // Auto select first available
        if (!m1) select.value = "1";
        else if (!m2) select.value = "2";
        else if (!m3) select.value = "3";

        var modal = new bootstrap.Modal(document.getElementById('forceReleaseModal'));
        modal.show();
    }

    function openToggleFreezeModal(id, tracking, action) {
        document.getElementById('toggleFreezeForm').action = '/admin/finance/escrow/' + id + '/freeze';
        document.getElementById('freezeTrackingInput').value = tracking;
        document.getElementById('freezeActionInput').value = action;

        var header = document.getElementById('freezeHeader');
        var btn = document.getElementById('freezeSubmitBtn');
        var title = document.getElementById('toggleFreezeModalLabel');

        if (action === 'FREEZE') {
            header.className = 'modal-header bg-danger text-white';
            title.innerHTML = '<svg class="lucide-icon inline-block align-middle me-2" xmlns="http://www.w3.org/2000/svg" width="1.1rem" height="1.1rem" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg> Bekukan Saldo Escrow';
            btn.className = 'btn btn-sm btn-danger';
            btn.innerText = 'Bekukan Rekening';
        } else {
            header.className = 'modal-header bg-success text-white';
            title.innerHTML = '<svg class="lucide-icon inline-block align-middle me-2" xmlns="http://www.w3.org/2000/svg" width="1.1rem" height="1.1rem" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg> Buka Gembok Sengketa';
            btn.className = 'btn btn-sm btn-success';
            btn.innerText = 'Buka Gembok (Unfreeze)';
        }

        var modal = new bootstrap.Modal(document.getElementById('toggleFreezeModal'));
        modal.show();
    }

    function openDisputeModal(id, tracking, totalAmount) {
        document.getElementById('disputeResolutionForm').action = '/admin/finance/escrow/' + id + '/resolve';
        document.getElementById('disputeTrackingInput').value = tracking;
        document.getElementById('disputeTotalEscrowInput').value = 'Rp ' + Number(totalAmount).toLocaleString('id-ID');
        document.getElementById('disputeAdjustAmount').placeholder = 'Maksimal Rp ' + Number(totalAmount).toLocaleString('id-ID');

        var modal = new bootstrap.Modal(document.getElementById('disputeResolutionModal'));
        modal.show();
    }
</script>
@endpush
@endsection

