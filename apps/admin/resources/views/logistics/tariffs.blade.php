@extends('layouts.app')

@section('title', 'Tarif & Rute Ekspedisi')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Tarif &amp; Rute Ekspedisi</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="tags" size="0.85rem" class="me-1" /> Master Logistik
            </span>
        </div>
        <p class="text-muted small mb-0">Konfigurasi ongkos kirim dasar per kg &amp; CBM, matriks surcharge kargo khusus, estimasi transit pelayaran, dan proteksi keselamatan cuaca BMKG.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <button class="btn btn-sm btn-primary d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#newRouteModal">
            <x-icon name="plus" class="me-1" /> Daftarkan Rute Baru
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

<!-- 4 Small Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Active Routes -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Rute Beroperasi Aktif</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalActiveRoutes }} Koridor</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Jalur pelayaran aman</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="compass" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Weather Hold Routes -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-danger fw-bold text-xs mb-1">Suspensi Cuaca (BMKG)</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalWeatherHoldRoutes }} Rute Ditutup</div>
                        <span class="text-danger text-xs fw-semibold"><x-icon name="cloud-rain" size="0.75rem" /> Peringatan gelombang tinggi</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="cloud-rain" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Avg Rate Per Kg -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Rata-rata Tarif Dasar / Kg</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($avgRatePerKg, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">Biaya dasar moda laut &amp; darat</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="tags" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Avg Transit Hours -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Rata-rata Waktu Transit</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ round($avgTransitHours, 1) }} Jam</div>
                        <span class="text-muted text-xs">&plusmn; {{ round($avgTransitHours / 24, 1) }} hari pelayaran</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="clock" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Routes & Tariffs Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold d-flex align-items-center">
            <x-icon name="compass" class="me-2" />Katalog Tarif Koridor Pelabuhan &amp; Matriks Surcharge
        </h6>
        <span class="badge bg-light text-primary border">SoraCargo Dynamic Tariff Engine</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="tariffFilterTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($mode) && empty($hold) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.logistics.tariffs', ['search' => $search]) }}">
                    <x-icon name="layers" class="me-1" /> Semua Rute ({{ $routes->total() }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $mode === 'SEA_CONTAINER' ? 'active' : '' }} py-1 px-3 small fw-bold text-primary" href="{{ route('admin.logistics.tariffs', ['mode' => 'SEA_CONTAINER', 'search' => $search]) }}">
                    <x-icon name="ship" class="me-1" /> Kontainer Laut (FCL/LCL)
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $mode === 'SEA_RORO' ? 'active' : '' }} py-1 px-3 small fw-bold text-info" href="{{ route('admin.logistics.tariffs', ['mode' => 'SEA_RORO', 'search' => $search]) }}">
                    <x-icon name="truck" class="me-1" /> Kapal Ro-Ro Cepat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $hold === 'held' ? 'active' : '' }} py-1 px-3 small fw-bold text-danger" href="{{ route('admin.logistics.tariffs', ['hold' => 'held', 'search' => $search]) }}">
                    <x-icon name="cloud-rain" class="me-1" /> Ditangguhkan Cuaca ({{ $totalWeatherHoldRoutes }})
                </a>
            </li>
        </ul>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.logistics.tariffs') }}" class="row mb-3 g-2">
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="hold" value="{{ $hold }}">
            <div class="col-md-9 col-lg-10">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari kode pelabuhan (IDJKT, IDSUB), nama kota, atau pelabuhan transit..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                @if($search)
                    <a href="{{ route('admin.logistics.tariffs') }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- Routes Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="tariffsTable">
                <thead class="table-light">
                    <tr>
                        <th>Koridor Asal &rarr; Tujuan</th>
                        <th>Moda Angkut</th>
                        <th>Tarif Dasar / Kg</th>
                        <th>Tarif Dasar / CBM</th>
                        <th>Waktu Tempuh</th>
                        <th>Matriks Surcharge Kargo Khusus</th>
                        <th>Status Keselamatan</th>
                        <th class="text-center">Aksi Superadmin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($routes as $r)
                        @php
                            $isHeld = $r->is_weather_hold;
                        @endphp
                        <tr class="{{ $isHeld ? 'table-danger-subtle' : '' }}">
                            <!-- 1. Koridor Asal -> Tujuan -->
                            <td>
                                <div class="fw-bold text-dark d-flex align-items-center">
                                    <span class="badge bg-primary text-white font-monospace me-1">{{ $r->origin_port_id }}</span>
                                    <x-icon name="arrow-right" size="0.75rem" class="text-muted mx-1" />
                                    <span class="badge bg-info text-dark font-monospace">{{ $r->destination_port_id }}</span>
                                </div>
                                <div class="text-muted text-xs mt-1">
                                    {{ $r->originPort?->city ?? 'Asal' }} &rarr; {{ $r->destinationPort?->city ?? 'Tujuan' }}
                                </div>
                                <div class="text-xs text-secondary">
                                    {{ $r->originPort?->name }} &rarr; {{ $r->destinationPort?->name }}
                                </div>
                            </td>

                            <!-- 2. Moda Angkut -->
                            <td>
                                <span class="badge bg-light text-secondary border">
                                    <x-icon name="{{ str_contains($r->transport_mode, 'SEA') ? 'ship' : 'truck' }}" size="0.75rem" class="me-1" />
                                    {{ $r->transport_mode }}
                                </span>
                            </td>

                            <!-- 3. Tarif Dasar / Kg -->
                            <td>
                                <div class="fw-bold text-primary font-monospace">Rp {{ number_format($r->base_rate_per_kg, 0, ',', '.') }}</div>
                                <span class="text-muted text-xs">per kilogram bersih</span>
                            </td>

                            <!-- 4. Tarif Dasar / CBM -->
                            <td>
                                <div class="fw-bold text-dark font-monospace">Rp {{ number_format($r->base_rate_per_cbm, 0, ',', '.') }}</div>
                                <span class="text-muted text-xs">per meter kubik (CBM)</span>
                            </td>

                            <!-- 5. Waktu Tempuh -->
                            <td>
                                <div class="fw-semibold text-dark">{{ $r->estimated_transit_hours }} Jam</div>
                                <span class="text-muted text-xs">&plusmn; {{ round($r->estimated_transit_hours / 24, 1) }} Hari</span>
                            </td>

                            <!-- 6. Matriks Surcharge Khusus -->
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border text-xs" title="Kargo Dingin / Suhu Terkendali">
                                        Reefer: +25%
                                    </span>
                                    <span class="badge bg-light text-danger border border-danger-subtle text-xs" title="Dangerous Goods IMO Class">
                                        DG IMO: +40%
                                    </span>
                                    <span class="badge bg-light text-success border border-success-subtle text-xs" title="Asuransi Premi Dasar">
                                        Asuransi: 0.2%
                                    </span>
                                </div>
                            </td>

                            <!-- 7. Status Keselamatan Cuaca -->
                            <td>
                                @if($isHeld)
                                    <span class="badge bg-danger text-white">
                                        <x-icon name="cloud-rain" size="0.75rem" class="me-1" /> Weather Hold BMKG
                                    </span>
                                    <div class="text-xs text-danger mt-1">Jalur ditutup sementara</div>
                                @else
                                    <span class="badge bg-success text-white">
                                        <x-icon name="check-circle" size="0.75rem" class="me-1" /> Aman Berlayar
                                    </span>
                                    <div class="text-xs text-muted mt-1">Kondisi ombak normal</div>
                                @endif
                            </td>

                            <!-- 8. Aksi Superadmin -->
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Kelola
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Manajemen Rute &amp; Tarif</h6></li>
                                        <li>
                                            <button class="dropdown-item small text-primary" type="button"
                                                onclick="openEditTariffModal('{{ $r->id }}', '{{ $r->origin_port_id }}', '{{ $r->destination_port_id }}', '{{ $r->transport_mode }}', '{{ $r->base_rate_per_kg }}', '{{ $r->base_rate_per_cbm }}', '{{ $r->estimated_transit_hours }}')">
                                                <x-icon name="tags" class="me-2" size="0.85rem" /> Perbarui Tarif Dasar
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item small {{ $isHeld ? 'text-success' : 'text-danger' }}" type="button"
                                                onclick="openWeatherHoldModal('{{ $r->id }}', '{{ $r->origin_port_id }} &rarr; {{ $r->destination_port_id }}', {{ $isHeld ? 'true' : 'false' }})">
                                                <x-icon name="{{ $isHeld ? 'compass' : 'cloud-rain' }}" class="me-2" size="0.85rem" />
                                                {{ $isHeld ? 'Buka Kembali Jalur Pelayaran' : 'Tutup Rute (Weather Hold BMKG)' }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <x-icon name="compass" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada rute ekspedisi yang cocok dengan kriteria pencarian.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($routes->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $routes->firstItem() }} - {{ $routes->lastItem() }} dari {{ $routes->total() }} rute
                </div>
                <div>
                    {{ $routes->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL 1: Tambah Rute Baru -->
<div class="modal fade" id="newRouteModal" tabindex="-1" aria-labelledby="newRouteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.logistics.tariffs.store') }}">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="newRouteModalLabel">
                        <x-icon name="plus" class="me-2" /> Daftarkan Rute &amp; Tarif Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Pelabuhan Asal <span class="text-danger">*</span></label>
                            <select name="origin_port_id" class="form-select form-select-sm" required>
                                <option value="">-- Pilih Asal --</option>
                                @foreach($ports as $p)
                                    <option value="{{ $p->id }}">{{ $p->id }} - {{ $p->name }} ({{ $p->city }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Pelabuhan Tujuan <span class="text-danger">*</span></label>
                            <select name="destination_port_id" class="form-select form-select-sm" required>
                                <option value="">-- Pilih Tujuan --</option>
                                @foreach($ports as $p)
                                    <option value="{{ $p->id }}">{{ $p->id }} - {{ $p->name }} ({{ $p->city }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Moda Transportasi Kargo <span class="text-danger">*</span></label>
                        <select name="transport_mode" class="form-select form-select-sm" required>
                            <option value="SEA_CONTAINER">SEA_CONTAINER (Kapal Kontainer Petikemas FCL/LCL)</option>
                            <option value="SEA_RORO">SEA_RORO (Kapal Ro-Ro Cepat &amp; Truk Terjadwal)</option>
                            <option value="LAND_TRUCK">LAND_TRUCK (Armada Truk Logistik Darat Antarpulau)</option>
                            <option value="AIR_FREIGHT">AIR_FREIGHT (Kargo Udara Kilat)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tarif Dasar / Kg (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="100" name="base_rate_per_kg" class="form-control form-control-sm" placeholder="Contoh: 3500" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tarif Dasar / CBM (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="1000" name="base_rate_per_cbm" class="form-control form-control-sm" placeholder="Contoh: 850000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Estimasi Waktu Tempuh (Jam) <span class="text-danger">*</span></label>
                        <input type="number" name="estimated_transit_hours" class="form-control form-control-sm" placeholder="Contoh: 48 (untuk 2 hari)" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Rute
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Edit Tarif Rute -->
<div class="modal fade" id="editTariffModal" tabindex="-1" aria-labelledby="editTariffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editTariffForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="editTariffModalLabel">
                        <x-icon name="tags" class="me-2" /> Perbarui Tarif Dasar Koridor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Koridor Rute</label>
                        <input type="text" id="editRouteLabel" class="form-control form-control-sm fw-bold font-monospace" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Moda Transportasi <span class="text-danger">*</span></label>
                        <select name="transport_mode" id="editTransportMode" class="form-select form-select-sm" required>
                            <option value="SEA_CONTAINER">SEA_CONTAINER (Kapal Kontainer Petikemas)</option>
                            <option value="SEA_RORO">SEA_RORO (Kapal Ro-Ro Cepat)</option>
                            <option value="LAND_TRUCK">LAND_TRUCK (Armada Truk Logistik)</option>
                            <option value="AIR_FREIGHT">AIR_FREIGHT (Kargo Udara Kilat)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tarif Dasar / Kg (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="50" name="base_rate_per_kg" id="editRatePerKg" class="form-control form-control-sm fw-bold" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tarif Dasar / CBM (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="1000" name="base_rate_per_cbm" id="editRatePerCbm" class="form-control form-control-sm fw-bold" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Estimasi Waktu Tempuh (Jam) <span class="text-danger">*</span></label>
                        <input type="number" name="estimated_transit_hours" id="editTransitHours" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Pembaruan Tarif
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 3: Saklar Weather Hold BMKG -->
<div class="modal fade" id="weatherHoldModal" tabindex="-1" aria-labelledby="weatherHoldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="weatherHoldForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header text-white" id="weatherHoldHeader">
                    <h5 class="modal-title fw-bold" id="weatherHoldModalLabel">
                        <x-icon name="cloud-rain" class="me-2" /> Saklar Cuaca BMKG
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Koridor Rute Pelayaran</label>
                        <input type="text" id="whRouteLabel" class="form-control form-control-sm fw-bold font-monospace" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Alasan Tindakan &amp; Referensi BMKG <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Peringatan Dini BMKG No. W-04/11/2026 gelombang mencapai 3.5 meter di Laut Jawa, seluruh keberangkatan ditunda demi keselamatan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm" id="whSubmitBtn">Konfirmasi</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditTariffModal(id, origin, destination, mode, rateKg, rateCbm, hours) {
        document.getElementById('editTariffForm').action = '/admin/logistics/tariffs/' + id;
        document.getElementById('editRouteLabel').value = origin + ' \u2192 ' + destination;
        document.getElementById('editTransportMode').value = mode;
        document.getElementById('editRatePerKg').value = rateKg;
        document.getElementById('editRatePerCbm').value = rateCbm;
        document.getElementById('editTransitHours').value = hours;

        var modal = new bootstrap.Modal(document.getElementById('editTariffModal'));
        modal.show();
    }

    function openWeatherHoldModal(id, routeLabel, isCurrentlyHeld) {
        document.getElementById('weatherHoldForm').action = '/admin/logistics/tariffs/' + id + '/weather-hold';
        document.getElementById('whRouteLabel').value = routeLabel;

        var header = document.getElementById('weatherHoldHeader');
        var btn = document.getElementById('whSubmitBtn');
        var title = document.getElementById('weatherHoldModalLabel');

        if (isCurrentlyHeld) {
            header.className = 'modal-header bg-success text-white';
            title.innerHTML = '<svg class="lucide-icon inline-block align-middle me-2" xmlns="http://www.w3.org/2000/svg" width="1.1rem" height="1.1rem" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg> Buka Kembali Jalur Pelayaran';
            btn.className = 'btn btn-sm btn-success';
            btn.innerText = 'Buka Jalur (Cabut Weather Hold)';
        } else {
            header.className = 'modal-header bg-danger text-white';
            title.innerHTML = '<svg class="lucide-icon inline-block align-middle me-2" xmlns="http://www.w3.org/2000/svg" width="1.1rem" height="1.1rem" viewBox="0 0 24 24"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M16 14v6"/><path d="M8 14v6"/><path d="M12 16v6"/></svg> Tutup Koridor (Weather Hold BMKG)';
            btn.className = 'btn btn-sm btn-danger';
            btn.innerText = 'Tutup Jalur Pelayaran';
        }

        var modal = new bootstrap.Modal(document.getElementById('weatherHoldModal'));
        modal.show();
    }
</script>
@endpush
@endsection

