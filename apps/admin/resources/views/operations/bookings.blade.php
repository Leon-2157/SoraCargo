@extends('layouts.app')

@section('title', 'Daftar Booking & Pesanan')

@section('content')
<!-- Page Header & Actions -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Daftar Booking & Pesanan Pengiriman</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary fw-semibold px-2 py-1">
                <x-icon name="package" size="0.85rem" class="me-1" /> Logistik Masuk
            </span>
        </div>
        <p class="text-muted small mb-0">Monitoring seluruh order masuk dari shipper retail dan corporate B2B sebelum armada diberangkatkan.</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <button class="btn btn-primary btn-sm shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#createBookingModal">
            <x-icon name="plus" size="0.9rem" class="me-1" /> + Buat Booking Manual
        </button>
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

<!-- Radar KPI Summary Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Bookings -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-primary shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Booking Aktif</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $totalBookingsCount }} Pesanan</div>
                        <div class="text-muted text-xs mt-1">
                            Retail LCL &amp; B2B Kontainer
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-primary-subtle p-3 rounded-circle text-primary">
                            <x-icon name="package" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Cargo Weight -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-success shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Tonase Muatan Kargo</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ number_format($totalWeightKg / 1000, 1, ',', '.') }} Ton</div>
                        <div class="text-muted text-xs mt-1">
                            Total: {{ number_format($totalWeightKg, 0, ',', '.') }} kg terdaftar
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-success-subtle p-3 rounded-circle text-success">
                            <x-icon name="boxes" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Volume (CBM) -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-warning shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Kubikasi Petikemas</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ number_format($totalVolumeCbm, 1, ',', '.') }} CBM</div>
                        <div class="text-muted text-xs mt-1">
                            Ruang kapal &amp; CY Depo terpakai
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-warning-subtle p-3 rounded-circle text-warning">
                            <x-icon name="ship" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Protected Escrow Funds -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-info shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Saldo Dana Escrow</div>
                        <div class="text-dark fw-bold h4 mb-0">Rp {{ number_format($totalEscrowProtected, 0, ',', '.') }}</div>
                        <div class="text-muted text-xs mt-1">
                            <span class="text-success fw-semibold">100% Dijamin:</span> Rekening penampung
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-info-subtle p-3 rounded-circle text-info">
                            <x-icon name="vault" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card: Cargo Bookings Register -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold">
            <x-icon name="calendar-check" class="me-2" />Daftar Pesanan &amp; Surat Jalan Kargo
        </h6>
        <span class="badge bg-light text-primary border">Total {{ $totalBookingsCount }} Pesanan Terdata</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters (Semua, Retail LCL, Corporate FCL, Charter Truk) -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="bookingTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($type) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.bookings.index', array_filter(['status' => $status, 'channel' => $channel, 'search' => $search])) }}">
                    Semua Booking ({{ $totalBookingsCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'RETAIL_LCL' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.bookings.index', array_filter(['type' => 'RETAIL_LCL', 'status' => $status, 'channel' => $channel, 'search' => $search])) }}">
                    <x-icon name="user" class="me-1" /> Retail LCL ({{ $retailCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'CORPORATE_FCL' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.bookings.index', array_filter(['type' => 'CORPORATE_FCL', 'status' => $status, 'channel' => $channel, 'search' => $search])) }}">
                    <x-icon name="building-2" class="me-1" /> Corporate FCL ({{ $corporateCount }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type === 'CHARTER_TRUCK' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.bookings.index', array_filter(['type' => 'CHARTER_TRUCK', 'status' => $status, 'channel' => $channel, 'search' => $search])) }}">
                    <x-icon name="truck" class="me-1" /> Charter Truk ({{ $charterCount }})
                </a>
            </li>
        </ul>

        <!-- Filter & Search Controls Form -->
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="row mb-3 g-2">
            @if(!empty($type))
                <input type="hidden" name="type" value="{{ $type }}">
            @endif
            <div class="col-md-3 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Status:</label>
                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" {{ empty($status) || $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="BOOKED" {{ $status === 'BOOKED' ? 'selected' : '' }}>BOOKED (Terdaftar)</option>
                        <option value="GATE_IN" {{ $status === 'GATE_IN' ? 'selected' : '' }}>GATE_IN (Depo CY)</option>
                        <option value="CUSTOMS_INSPECTION" {{ $status === 'CUSTOMS_INSPECTION' ? 'selected' : '' }}>CUSTOMS_INSPECTION (Cukai)</option>
                        <option value="SAILING" {{ $status === 'SAILING' ? 'selected' : '' }}>SAILING (Berlayar)</option>
                        <option value="DELIVERED" {{ $status === 'DELIVERED' ? 'selected' : '' }}>DELIVERED (Terkirim)</option>
                        <option value="WEATHER_HOLD" {{ $status === 'WEATHER_HOLD' ? 'selected' : '' }}>WEATHER_HOLD (Tahan Cuaca)</option>
                        <option value="CLAIM_HOLD" {{ $status === 'CLAIM_HOLD' ? 'selected' : '' }}>CLAIM_HOLD (Klaim Rusak)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Bea Cukai:</label>
                    <select name="channel" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" {{ empty($channel) || $channel === 'all' ? 'selected' : '' }}>Semua Jalur</option>
                        <option value="GREEN_CHANNEL" {{ $channel === 'GREEN_CHANNEL' ? 'selected' : '' }}>Jalur Hijau</option>
                        <option value="YELLOW_CHANNEL" {{ $channel === 'YELLOW_CHANNEL' ? 'selected' : '' }}>Jalur Kuning</option>
                        <option value="RED_CHANNEL" {{ $channel === 'RED_CHANNEL' ? 'selected' : '' }}>Jalur Merah (DG)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari resi, nama pengirim, atau nama perusahaan..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                    @if(!empty($search) || (!empty($status) && $status !== 'all') || (!empty($channel) && $channel !== 'all'))
                        <a href="{{ route('admin.bookings.index', array_filter(['type' => $type])) }}" class="btn btn-outline-danger" title="Reset Filter">
                            <x-icon name="x" />
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="bookingsTable">
                <thead class="table-light">
                    <tr>
                        <th>No. Resi &amp; Layanan</th>
                        <th>Shipper / Pengirim</th>
                        <th>Rute &amp; Moda</th>
                        <th>Muatan &amp; HS Code</th>
                        <th>Jalur Cukai</th>
                        <th>Status Kargo</th>
                        <th>Escrow Ledger</th>
                        <th class="text-center">Aksi Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $item)
                        @php
                            $route = $item->route;
                            $shipper = $item->shipper;
                            $company = $item->company;
                            $escrow = $item->escrowLedger;
                        @endphp
                        <tr>
                            <!-- 1. Resi & Layanan -->
                            <td>
                                <a href="javascript:void(0)" onclick="openTrackingModal('{{ $item->id }}', '{{ $item->tracking_number }}')" class="fw-bold font-monospace text-primary text-decoration-none" title="Buka Riwayat Pelacakan GPS & Checkpoint">
                                    {{ $item->tracking_number }}
                                </a>
                                <div class="mt-1">
                                    @if($item->booking_type === 'RETAIL_LCL')
                                        <span class="badge badge-retail">RETAIL_LCL</span>
                                    @elseif($item->booking_type === 'CORPORATE_FCL')
                                        <span class="badge badge-b2b">CORPORATE_FCL</span>
                                    @else
                                        <span class="badge bg-info text-white">CHARTER_TRUCK</span>
                                    @endif
                                </div>
                                <div class="text-muted text-xs mt-1">
                                    <x-icon name="clock" size="0.75rem" class="me-1" />
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>

                            <!-- 2. Shipper / Pengirim -->
                            <td>
                                <div class="fw-semibold text-dark">{{ $shipper ? $shipper->name : '-' }}</div>
                                @if($company)
                                    <div class="text-primary small fw-bold">{{ $company->company_name }}</div>
                                @endif
                                <div class="text-muted text-xs">{{ $shipper ? $shipper->phone : '-' }}</div>
                            </td>

                            <!-- 3. Rute & Moda -->
                            <td>
                                @if($route)
                                    <div>
                                        <span class="badge bg-light text-dark border">
                                            {{ $route->origin_port_id }} &rarr; {{ $route->destination_port_id }}
                                        </span>
                                    </div>
                                    <div class="text-muted text-xs mt-1">
                                        @if($route->transport_mode === 'SEA_RORO')
                                            <x-icon name="ship" size="0.75rem" class="me-1" /> Kapal RORO (Nusantara)
                                        @elseif($route->transport_mode === 'SEA_CONTAINER')
                                            <x-icon name="ship" size="0.75rem" class="me-1" /> Kapal Kontainer FCL
                                        @else
                                            <x-icon name="truck" size="0.75rem" class="me-1" /> Ekspedisi Truk Darat
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- 4. Muatan & HS Code -->
                            <td>
                                <div class="fw-bold text-dark font-monospace small">
                                    {{ number_format($item->total_weight_kg, 0, ',', '.') }} kg / {{ $item->total_volume_cbm }} CBM
                                </div>
                                <div class="mt-1">
                                    @if($item->cargo_type === 'DANGEROUS_GOODS')
                                        <span class="badge bg-danger text-white">
                                            <x-icon name="alert-triangle" size="0.75rem" class="me-1" /> DG Class 3
                                        </span>
                                    @elseif($item->cargo_type === 'REEFER_PERISHABLE')
                                        <span class="badge bg-info text-white">Kargo Dingin</span>
                                    @else
                                        <span class="badge bg-secondary text-white">General Cargo</span>
                                    @endif
                                </div>
                                <div class="text-muted text-xs font-monospace mt-1">
                                    HS: {{ $item->hs_code ?? '0901.11.10' }}
                                </div>
                            </td>

                            <!-- 5. Jalur Cukai -->
                            <td>
                                @if($item->customs_channel === 'GREEN_CHANNEL')
                                    <span class="badge bg-success-subtle text-success border border-success">
                                        <x-icon name="shield-check" size="0.75rem" class="me-1" /> Jalur Hijau
                                    </span>
                                @elseif($item->customs_channel === 'YELLOW_CHANNEL')
                                    <span class="badge bg-warning-subtle text-warning border border-warning">
                                        <x-icon name="file-text" size="0.75rem" class="me-1" /> Jalur Kuning
                                    </span>
                                @elseif($item->customs_channel === 'RED_CHANNEL')
                                    <span class="badge bg-danger-subtle text-danger border border-danger">
                                        <x-icon name="alert-triangle" size="0.75rem" class="me-1" /> Jalur Merah
                                    </span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>

                            <!-- 6. Status Kargo -->
                            <td>
                                @if($item->cargo_status === 'BOOKED')
                                    <span class="badge bg-primary">BOOKED</span>
                                @elseif($item->cargo_status === 'GATE_IN')
                                    <span class="badge bg-info text-white">GATE_IN</span>
                                @elseif($item->cargo_status === 'CUSTOMS_INSPECTION')
                                    <span class="badge bg-warning text-dark">INSPECTION</span>
                                @elseif($item->cargo_status === 'SAILING')
                                    <span class="badge badge-domestic">SAILING</span>
                                @elseif($item->cargo_status === 'DELIVERED')
                                    <span class="badge badge-active">DELIVERED</span>
                                @elseif($item->cargo_status === 'WEATHER_HOLD')
                                    <span class="badge bg-danger text-white">WEATHER_HOLD</span>
                                @elseif($item->cargo_status === 'CLAIM_HOLD')
                                    <span class="badge badge-suspended">CLAIM_HOLD</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->cargo_status }}</span>
                                @endif
                            </td>

                            <!-- 7. Rekening Escrow -->
                            <td>
                                @if($escrow)
                                    <div class="fw-bold text-dark font-monospace small">
                                        Rp {{ number_format($escrow->total_paid_amount, 0, ',', '.') }}
                                    </div>
                                    <div class="mt-1">
                                        @if($escrow->escrow_status === 'HELD_IN_ESCROW')
                                            <span class="badge bg-secondary">Tertampung 100%</span>
                                        @elseif($escrow->escrow_status === 'PARTIALLY_RELEASED')
                                            <span class="badge bg-primary">Tahap Cair</span>
                                        @elseif($escrow->escrow_status === 'FULLY_SETTLED')
                                            <span class="badge bg-success">Lunas Tuntas</span>
                                        @elseif($escrow->escrow_status === 'DISPUTE_FROZEN')
                                            <span class="badge bg-danger">Dibekukan</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted text-xs">Belum Ada Escrow</span>
                                @endif
                            </td>

                            <!-- 8. Aksi Kelola Status & Lacak -->
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" type="button"
                                        onclick="openTrackingModal('{{ $item->id }}', '{{ $item->tracking_number }}')"
                                        title="Buka Riwayat Checkpoint & GPS Tracking">
                                        <x-icon name="map-pin" size="0.8rem" class="me-1" /> Lacak
                                    </button>
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="openStatusModal('{{ $item->id }}', '{{ $item->tracking_number }}', '{{ $item->cargo_status }}')"
                                        title="Ubah Status Kargo & Escrow">
                                        <x-icon name="sliders-horizontal" size="0.8rem" class="me-1" /> Status
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <x-icon name="package" size="2.5rem" class="mb-2 text-secondary opacity-50" />
                                    <div class="fw-bold">Tidak ada data pesanan booking ditemukan</div>
                                    <div class="small">Silakan ubah filter kategori atau kata kunci pencarian Anda.</div>
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
                    Menampilkan {{ $bookings->firstItem() ?? 0 }} sampai {{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} pesanan kargo
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: UPDATE CARGO STATUS -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="statusModalLabel">
                    <x-icon name="sliders-horizontal" class="me-2" />Perbarui Status Kargo: <span id="modalTrackingTitle" class="font-monospace"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <x-icon name="info" class="me-1" />
                        Perubahan status operasional akan secara otomatis memicu pelepasan bertahap (*milestone release*) dana rekening bersama Escrow kepada operator pelayaran.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Status Kargo Operasional</label>
                        <select name="cargo_status" id="modalStatusSelect" class="form-select form-select-sm" required>
                            <option value="BOOKED">BOOKED (Pesanan Terdaftar)</option>
                            <option value="GATE_IN">GATE_IN (Kargo Masuk Depo / CY) &rarr; Rilis 30% Escrow</option>
                            <option value="CUSTOMS_INSPECTION">CUSTOMS_INSPECTION (Pemeriksaan Bea Cukai)</option>
                            <option value="SAILING">SAILING (Kapal/Truk Berlayar) &rarr; Rilis 40% Escrow</option>
                            <option value="DELIVERED">DELIVERED (Muatan Diterima Konsumen) &rarr; Rilis 30% Selesai</option>
                            <option value="WEATHER_HOLD">WEATHER_HOLD (Tahan Cuaca Buruk BMKG)</option>
                            <option value="CLAIM_HOLD">CLAIM_HOLD (Bekukan Kasus Klaim Kerusakan)</option>
                            <option value="CANCELLED">CANCELLED (Batalkan Pengiriman)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Status Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: CREATE MANUAL BOOKING -->
<div class="modal fade" id="createBookingModal" tabindex="-1" aria-labelledby="createBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="createBookingModalLabel">
                    <x-icon name="plus" class="me-2" />Buat Pesanan Kargo Baru (Manual Dispatch)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <x-icon name="info" class="me-1" />
                        Formulir ini digunakan Superadmin untuk menginput order offline dari shipper korporat/retail dan langsung mengalokasikan akun penampung dana Escrow 3-tahap.
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Shipper Selection -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Shipper / Pelanggan Pengirim <span class="text-danger">*</span></label>
                            <select name="shipper_id" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Klien Terdaftar --</option>
                                @foreach($shippers as $shp)
                                    <option value="{{ $shp->id }}">
                                        {{ $shp->name }} ({{ $shp->email }}) [{{ $shp->user_type }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Route Selection -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Rute Pengiriman Pelabuhan <span class="text-danger">*</span></label>
                            <select name="route_id" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Rute Ekspedisi --</option>
                                @foreach($routes as $rt)
                                    <option value="{{ $rt->id }}">
                                        {{ $rt->originPort->name }} ({{ $rt->origin_port_id }}) &rarr; {{ $rt->destinationPort->name }} ({{ $rt->destination_port_id }}) [{{ $rt->transport_mode }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Booking Type -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tipe Booking <span class="text-danger">*</span></label>
                            <select name="booking_type" class="form-select form-select-sm" required>
                                <option value="RETAIL_LCL">RETAIL_LCL (Konsolidasi Muatan)</option>
                                <option value="CORPORATE_FCL">CORPORATE_FCL (Petikemas Penuh)</option>
                                <option value="CHARTER_TRUCK">CHARTER_TRUCK (Carter Truk Darat)</option>
                            </select>
                        </div>

                        <!-- Cargo Type -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kategori Kargo <span class="text-danger">*</span></label>
                            <select name="cargo_type" class="form-select form-select-sm" required>
                                <option value="GENERAL_CARGO">GENERAL_CARGO (Umum)</option>
                                <option value="DANGEROUS_GOODS">DANGEROUS_GOODS (DG Class 3)</option>
                                <option value="REEFER_PERISHABLE">REEFER_PERISHABLE (Kargo Dingin)</option>
                            </select>
                        </div>

                        <!-- HS Code -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kamus HS Code Bea Cukai</label>
                            <select name="hs_code" class="form-select form-select-sm">
                                <option value="">-- Pilih HS Code --</option>
                                @foreach($hsCodes as $hs)
                                    <option value="{{ $hs->code }}">
                                        {{ $hs->code }} - {{ Str::limit($hs->description_id, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Weight -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Bobot (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_weight_kg" class="form-control form-control-sm" placeholder="Contoh: 1500" required>
                        </div>

                        <!-- Volume -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Volume (CBM) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_volume_cbm" class="form-control form-control-sm" placeholder="Contoh: 4.5" required>
                        </div>

                        <!-- Declared Value -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Nilai Deklarasi Barang (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="1000" name="declared_goods_value" class="form-control form-control-sm" placeholder="Contoh: 50000000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Petugas Operator Regional Hub Penanggung Jawab</label>
                        <select name="assigned_operator_id" class="form-select form-select-sm">
                            <option value="">-- Tetapkan Operator Lapangan (Opsional) --</option>
                            @foreach($operators as $op)
                                <option value="{{ $op->id }}">
                                    {{ $op->user->name }} ({{ $op->employee_id }}) - {{ $op->hub ? $op->hub->name : '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="plus" class="me-1" /> Terbitkan Booking &amp; Buat Escrow
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: TIMELINE PELACAKAN MILESTONE & GPS CHECKPOINT (ops.tracking_events) -->
<div class="modal fade" id="trackingEventsModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <x-icon name="map-pin" size="1.25rem" class="text-info" />
                    <div>
                        <h6 class="modal-title fw-bold mb-0" id="trackingModalLabel">
                            Riwayat Pelacakan &amp; GPS Checkpoint
                        </h6>
                        <span id="trackModalNo" class="font-monospace small text-info"></span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="trackModalStatusBadge" class="badge"></span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <!-- Ringkasan Rute & Muatan -->
                <div class="card border-0 bg-light mb-4 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center text-xs">
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-semibold">Shipper / Pengirim</div>
                                <div id="trackShipper" class="fw-bold text-dark text-truncate mt-1">-</div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-muted text-uppercase fw-semibold">Rute Pelayaran / Ekspedisi</div>
                                <div class="fw-bold text-primary mt-1">
                                    <span id="trackOrigin">-</span> &rarr; <span id="trackDestination">-</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted text-uppercase fw-semibold">Bobot &amp; Volume</div>
                                <div id="trackSpecs" class="fw-bold text-dark mt-1">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Container -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">
                            <x-icon name="activity" size="1rem" class="me-1 text-primary" /> Jejak Riwayat Milestone Lapangan
                        </h6>
                        <span id="trackEventCount" class="badge bg-secondary">0 Checkpoint</span>
                    </div>

                    <div id="trackingTimelineLoading" class="text-center py-4">
                        <span class="spinner-border text-primary" style="width: 2rem; height: 2rem;"></span>
                        <div class="small text-muted mt-2">Memuat jejak koordinat dari database...</div>
                    </div>

                    <div id="trackingTimelineContent" class="tracking-timeline" style="display: none;">
                        <!-- Injected via JavaScript -->
                    </div>

                    <div id="trackingTimelineEmpty" class="text-center py-4 bg-light rounded border" style="display: none;">
                        <x-icon name="navigation" size="2rem" class="text-muted opacity-50 mb-2" />
                        <div class="fw-semibold text-dark small">Belum ada rekaman checkpoint GPS untuk resi ini</div>
                        <div class="text-muted text-xs">Gunakan form di bawah untuk mencatat milestone pertama.</div>
                    </div>
                </div>

                <!-- Form Tambah Checkpoint Baru -->
                <div class="card border-primary-subtle shadow-sm">
                    <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center cursor-pointer"
                        data-bs-toggle="collapse" data-bs-target="#collapseAddCheckpoint" aria-expanded="false" style="cursor: pointer;">
                        <div class="fw-bold text-primary small">
                            <x-icon name="plus-circle" size="0.9rem" class="me-1" /> Catat Checkpoint Lapangan Baru
                        </div>
                        <span class="text-muted text-xs">Klik untuk buka/tutup form &rsaquo;</span>
                    </div>
                    <div id="collapseAddCheckpoint" class="collapse">
                        <div class="card-body p-3">
                            <form id="addCheckpointForm">
                                <div class="mb-2">
                                    <label class="form-label text-xs fw-bold">Nama Checkpoint / Aktivitas Lapangan <span class="text-danger">*</span></label>
                                    <input type="text" id="cpEventName" class="form-control form-control-sm" placeholder="Contoh: Petikemas Masuk CY Dermaga Priok / Selesai Pemeriksaan Fisik Bea Cukai" required>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label text-xs fw-bold">Status Kargo Terkait</label>
                                        <select id="cpStatus" class="form-select form-select-sm">
                                            <option value="GATE_IN">GATE_IN (Masuk Depo/Dermaga)</option>
                                            <option value="CUSTOMS_INSPECTION">CUSTOMS_INSPECTION (Pemeriksaan Cukai)</option>
                                            <option value="SAILING">SAILING (Armada Berlayar)</option>
                                            <option value="DELIVERED">DELIVERED (Tiba di Tujuan)</option>
                                            <option value="WEATHER_HOLD">WEATHER_HOLD (Ditahan Cuaca)</option>
                                            <option value="CLAIM_HOLD">CLAIM_HOLD (Ditahan Klaim)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-xs fw-bold">Latitude (GPS)</label>
                                        <input type="number" step="0.000001" id="cpLatitude" class="form-control form-control-sm" placeholder="-6.1033">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-xs fw-bold">Longitude (GPS)</label>
                                        <input type="number" step="0.000001" id="cpLongitude" class="form-control form-control-sm" placeholder="106.8828">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" id="btnSubmitCheckpoint" class="btn btn-sm btn-primary">
                                        <x-icon name="check" size="0.85rem" class="me-1" /> Simpan Checkpoint ke Database
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.tracking-timeline {
    position: relative;
    padding-left: 28px;
    margin-left: 10px;
}
.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 8px;
    bottom: 8px;
    width: 2px;
    background: #e2e8f0;
}
.timeline-item {
    position: relative;
    padding-bottom: 24px;
}
.timeline-item:last-child {
    padding-bottom: 0;
}
.timeline-dot {
    position: absolute;
    left: -28px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #94a3b8;
    border: 3px solid #fff;
    box-shadow: 0 0 0 1px #cbd5e1;
}
.timeline-item.active .timeline-dot {
    background: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.25);
    animation: pulseDot 2s infinite;
}
@keyframes pulseDot {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script>
let currentActiveBookingId = null;

function openStatusModal(id, trackingNo, currentStatus) {
    document.getElementById('modalTrackingTitle').innerText = trackingNo;
    document.getElementById('modalStatusSelect').value = currentStatus;
    document.getElementById('updateStatusForm').action = '/admin/bookings/' + id + '/status';

    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

function openTrackingModal(bookingId, trackingNo) {
    currentActiveBookingId = bookingId;
    document.getElementById('trackModalNo').innerText = trackingNo;
    document.getElementById('trackingTimelineLoading').style.display = 'block';
    document.getElementById('trackingTimelineContent').style.display = 'none';
    document.getElementById('trackingTimelineEmpty').style.display = 'none';

    const modalEl = document.getElementById('trackingEventsModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();

    fetch('/admin/bookings/' + bookingId + '/tracking')
        .then(res => res.json())
        .then(data => {
            document.getElementById('trackingTimelineLoading').style.display = 'none';
            if (data.success && data.booking) {
                const b = data.booking;
                document.getElementById('trackShipper').innerText = b.shipper_name || '-';
                document.getElementById('trackOrigin').innerText = b.origin || '-';
                document.getElementById('trackDestination').innerText = b.destination || '-';
                document.getElementById('trackSpecs').innerText = Number(b.weight).toLocaleString('id-ID') + ' kg / ' + Number(b.volume).toLocaleString('id-ID') + ' CBM';

                // Status badge
                const badge = document.getElementById('trackModalStatusBadge');
                badge.innerText = b.cargo_status;
                badge.className = 'badge ' + (b.cargo_status === 'SAILING' ? 'bg-primary' : (b.cargo_status === 'DELIVERED' ? 'bg-success' : 'bg-info'));

                const events = data.events || [];
                document.getElementById('trackEventCount').innerText = events.length + ' Checkpoint';

                if (events.length > 0) {
                    renderTimeline(events);
                    document.getElementById('trackingTimelineContent').style.display = 'block';
                } else {
                    document.getElementById('trackingTimelineEmpty').style.display = 'block';
                }
            }
        })
        .catch(() => {
            document.getElementById('trackingTimelineLoading').style.display = 'none';
            document.getElementById('trackingTimelineEmpty').style.display = 'block';
        });
}

function renderTimeline(events) {
    const container = document.getElementById('trackingTimelineContent');
    let html = '';

    events.forEach((ev, idx) => {
        const isActive = idx === 0; // Paling atas adalah event terbaru
        const statusBadgeClass = ev.current_status === 'SAILING' ? 'bg-primary-subtle text-primary border border-primary' :
            (ev.current_status === 'DELIVERED' ? 'bg-success-subtle text-success border border-success' :
            (ev.current_status === 'WEATHER_HOLD' ? 'bg-danger-subtle text-danger border border-danger' : 'bg-light text-dark border'));

        let gpsHtml = '';
        if (ev.latitude && ev.longitude) {
            gpsHtml = `
                <a href="https://www.openstreetmap.org/?mlat=${ev.latitude}&mlon=${ev.longitude}#map=14/${ev.latitude}/${ev.longitude}" target="_blank" class="badge bg-light text-primary border text-decoration-none" title="Lihat di OpenStreetMap">
                    📍 ${ev.latitude.toFixed(4)}, ${ev.longitude.toFixed(4)}
                </a>
            `;
        }

        html += `
            <div class="timeline-item ${isActive ? 'active' : ''}">
                <div class="timeline-dot"></div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="badge ${statusBadgeClass} text-xs font-monospace px-2 py-0">${ev.current_status}</span>
                    <span class="text-muted text-xs">${ev.timestamp} (${ev.time_ago})</span>
                </div>
                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">${ev.event_name}</h6>
                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 0.75rem;">
                    ${gpsHtml}
                    <span class="text-muted">👤 ${ev.operator_name || 'Petugas Lapangan'}</span>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

// Handler Submit Checkpoint Baru
document.addEventListener('DOMContentLoaded', function () {
    const cpForm = document.getElementById('addCheckpointForm');
    if (cpForm) {
        cpForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!currentActiveBookingId) return;

            const nameInput = document.getElementById('cpEventName');
            const statusSelect = document.getElementById('cpStatus');
            const latInput = document.getElementById('cpLatitude');
            const lngInput = document.getElementById('cpLongitude');
            const submitBtn = document.getElementById('btnSubmitCheckpoint');

            const payload = {
                event_name: nameInput.value.trim(),
                current_status: statusSelect.value,
                latitude: latInput.value ? parseFloat(latInput.value) : null,
                longitude: lngInput.value ? parseFloat(lngInput.value) : null,
            };

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch('/admin/bookings/' + currentActiveBookingId + '/tracking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<x-icon name="check" size="0.85rem" class="me-1" /> Simpan Checkpoint ke Database';

                if (data.success) {
                    nameInput.value = '';
                    latInput.value = '';
                    lngInput.value = '';

                    // Tutup accordion
                    const collapseEl = document.getElementById('collapseAddCheckpoint');
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                    if (bsCollapse) bsCollapse.hide();

                    // Re-fetch dan render ulang timeline
                    openTrackingModal(currentActiveBookingId, document.getElementById('trackModalNo').innerText);
                } else {
                    alert('Gagal menyimpan checkpoint: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<x-icon name="check" size="0.85rem" class="me-1" /> Simpan Checkpoint ke Database';
                alert('Gagal menghubungi server.');
            });
        });
    }
});
</script>
@endsection

