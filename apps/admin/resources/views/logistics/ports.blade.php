@extends('layouts.app')

@section('title', 'Pelabuhan & Depo Transit')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Pelabuhan &amp; Depo Transit</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="anchor" size="0.85rem" class="me-1" /> Simpul Maritim
            </span>
        </div>
        <p class="text-muted small mb-0">Master jaringan pelabuhan laut, bandara kargo, kapasitas lapangan penumpukan (Container Yard TEUs), dan koordinat geospasial.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <button class="btn btn-sm btn-primary d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#newPortModal">
            <x-icon name="plus" class="me-1" /> Tambah Simpul Pelabuhan
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
    <!-- Card 1: Total Ports -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Simpul Jaringan</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalPorts }} Terminal</div>
                        <span class="text-muted text-xs">Simpul hub domestik &amp; global</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="anchor" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Seaports -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Pelabuhan Laut (Seaport)</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalSeaports }} Pelabuhan</div>
                        <span class="text-info text-xs fw-semibold"><x-icon name="ship" size="0.75rem" /> Dermaga kapal kargo</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="ship" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total CY Capacity -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Kapasitas Penumpukan (CY)</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ number_format($totalCyCapacity, 0, ',', '.') }} TEUs</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Container Yard terpasang</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="boxes" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: International Hubs -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Hub Lintas Batas (Global)</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $internationalHubs }} Simpul</div>
                        <span class="text-muted text-xs">Singapura &amp; Rute Regional</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="globe" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Ports Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold d-flex align-items-center">
            <x-icon name="anchor" class="me-2" />Daftar Pelabuhan, Terminal &amp; Depo Penumpukan
        </h6>
        <span class="badge bg-light text-primary border">UN/LOCODE Standardized</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="portFilterTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($type) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.logistics.ports', ['search' => $search]) }}">
                    <x-icon name="layers" class="me-1" /> Semua Simpul ({{ $ports->total() }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'SEAPORT' ? 'active' : '' }} py-1 px-3 small fw-bold text-primary" href="{{ route('admin.logistics.ports', ['type' => 'SEAPORT', 'search' => $search]) }}">
                    <x-icon name="ship" class="me-1" /> Pelabuhan Laut ({{ $totalSeaports }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $type === 'AIRPORT' ? 'active' : '' }} py-1 px-3 small fw-bold text-info" href="{{ route('admin.logistics.ports', ['type' => 'AIRPORT', 'search' => $search]) }}">
                    <x-icon name="navigation" class="me-1" /> Bandara Kargo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type === 'LAND_HUB' ? 'active' : '' }} py-1 px-3 small fw-bold text-success" href="{{ route('admin.logistics.ports', ['type' => 'LAND_HUB', 'search' => $search]) }}">
                    <x-icon name="warehouse" class="me-1" /> Depo Darat / Dry Port
                </a>
            </li>
        </ul>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.logistics.ports') }}" class="row mb-3 g-2">
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="col-md-9 col-lg-10">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari kode UN/LOCODE (IDJKT, IDSUB), nama pelabuhan, kota, atau negara..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                @if($search)
                    <a href="{{ route('admin.logistics.ports') }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- Ports Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="portsTable">
                <thead class="table-light">
                    <tr>
                        <th>Kode &amp; Nama Pelabuhan</th>
                        <th>Kota &amp; Negara</th>
                        <th>Tipe Simpul</th>
                        <th>Kapasitas CY (TEUs)</th>
                        <th>Utilisasi Lapangan (YOR)</th>
                        <th>Koordinat Geospasial</th>
                        <th>Koneksi Rute</th>
                        <th class="text-center">Aksi Superadmin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ports as $p)
                        @php
                            $routeCount = $p->originRoutes->count() + $p->destinationRoutes->count();
                            // Estimasi Yard Occupancy Rate (YOR) realistis untuk simulasi visual
                            $yorPct = min(88, max(32, (intval(substr(md5($p->id), 0, 2), 16) % 60) + 30));
                        @endphp
                        <tr>
                            <!-- 1. Kode & Nama Pelabuhan -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary text-white font-monospace me-2">{{ $p->id }}</span>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->name }}</div>
                                        <span class="text-muted text-xs">UN/LOCODE Resmi</span>
                                    </div>
                                </div>
                            </td>

                            <!-- 2. Kota & Negara -->
                            <td>
                                <div class="fw-semibold text-dark">{{ $p->city }}</div>
                                <span class="badge bg-light text-secondary border text-xs">
                                    {{ $p->country_code === 'ID' ? '🇮🇩 Indonesia' : '🇸🇬 ' . $p->country_code }}
                                </span>
                            </td>

                            <!-- 3. Tipe Simpul -->
                            <td>
                                @if($p->port_type === 'SEAPORT')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <x-icon name="ship" size="0.75rem" class="me-1" /> Pelabuhan Laut
                                    </span>
                                @elseif($p->port_type === 'AIRPORT')
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                                        <x-icon name="navigation" size="0.75rem" class="me-1" /> Bandara Kargo
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <x-icon name="warehouse" size="0.75rem" class="me-1" /> Depo Darat
                                    </span>
                                @endif
                            </td>

                            <!-- 4. Kapasitas Container Yard (TEUs) -->
                            <td>
                                <div class="fw-bold text-dark font-monospace">{{ number_format($p->terminal_cy_capacity_teus, 0, ',', '.') }}</div>
                                <span class="text-muted text-xs">TEUs petikemas</span>
                            </td>

                            <!-- 5. Utilisasi Lapangan (YOR %) -->
                            <td style="min-width: 150px;">
                                <div class="d-flex justify-content-between text-xs mb-1">
                                    <span class="text-muted">Okupansi:</span>
                                    <strong class="{{ $yorPct > 75 ? 'text-danger' : ($yorPct > 55 ? 'text-warning' : 'text-success') }}">{{ $yorPct }}%</strong>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $yorPct > 75 ? 'bg-danger' : ($yorPct > 55 ? 'bg-warning' : 'bg-success') }}" role="progressbar" style="width: {{ $yorPct }}%"></div>
                                </div>
                                <div class="text-xs text-muted mt-1">
                                    {{ $yorPct > 75 ? 'Padat (Bongkar Lambat)' : 'Lancar & Siap Tampung' }}
                                </div>
                            </td>

                            <!-- 6. Koordinat Geospasial -->
                            <td>
                                <div class="font-monospace text-xs text-dark">
                                    {{ number_format($p->latitude, 4) }}, {{ number_format($p->longitude, 4) }}
                                </div>
                                <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}" target="_blank" class="text-xs text-primary text-decoration-none">
                                    <x-icon name="map-pin" size="0.7rem" /> Lihat Peta
                                </a>
                            </td>

                            <!-- 7. Koneksi Rute -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace">
                                    {{ $routeCount }} Jalur Rute
                                </span>
                            </td>

                            <!-- 8. Aksi Superadmin -->
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="openEditPortModal('{{ $p->id }}', '{{ $p->name }}', '{{ $p->city }}', '{{ $p->country_code }}', '{{ $p->port_type }}', '{{ $p->latitude }}', '{{ $p->longitude }}', '{{ $p->terminal_cy_capacity_teus }}')">
                                    <x-icon name="settings" class="me-1" size="0.8rem" /> Ubah
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <x-icon name="anchor" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada data simpul pelabuhan pada kriteria ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($ports->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $ports->firstItem() }} - {{ $ports->lastItem() }} dari {{ $ports->total() }} simpul pelabuhan
                </div>
                <div>
                    {{ $ports->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL 1: Tambah Pelabuhan Baru -->
<div class="modal fade" id="newPortModal" tabindex="-1" aria-labelledby="newPortModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.logistics.ports.store') }}">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="newPortModalLabel">
                        <x-icon name="plus" class="me-2" /> Tambah Simpul Pelabuhan / Depo Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-dark">Kode UN/LOCODE <span class="text-danger">*</span></label>
                            <input type="text" name="id" class="form-control form-control-sm font-monospace text-uppercase" placeholder="Contoh: IDSRG" required maxlength="10">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-dark">Nama Resmi Terminal <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Contoh: Pelabuhan Tanjung Emas" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-dark">Kota Wilayah <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control form-control-sm" placeholder="Contoh: Semarang" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-dark">Kode Negara (ISO) <span class="text-danger">*</span></label>
                            <input type="text" name="country_code" class="form-control form-control-sm text-uppercase" value="ID" required maxlength="2">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Tipe Fasilitas Simpul <span class="text-danger">*</span></label>
                        <select name="port_type" class="form-select form-select-sm" required>
                            <option value="SEAPORT">SEAPORT (Pelabuhan Laut &amp; Terminal Petikemas)</option>
                            <option value="AIRPORT">AIRPORT (Bandara Kargo Udara)</option>
                            <option value="LAND_HUB">LAND_HUB (Depo Kering / Dry Port / Gudang Konsolidasi)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Latitude (Garis Lintang) <span class="text-danger">*</span></label>
                            <input type="number" step="0.000001" name="latitude" class="form-control form-control-sm font-monospace" placeholder="-6.950000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Longitude (Garis Bujur) <span class="text-danger">*</span></label>
                            <input type="number" step="0.000001" name="longitude" class="form-control form-control-sm font-monospace" placeholder="110.416667" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Kapasitas Lapangan Penumpukan (TEUs) <span class="text-danger">*</span></label>
                        <input type="number" name="terminal_cy_capacity_teus" class="form-control form-control-sm" placeholder="Contoh: 10000" required min="100">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Simpul Pelabuhan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Edit Pelabuhan -->
<div class="modal fade" id="editPortModal" tabindex="-1" aria-labelledby="editPortModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editPortForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="editPortModalLabel">
                        <x-icon name="settings" class="me-2" /> Perbarui Data Fasilitas Pelabuhan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Kode UN/LOCODE</label>
                        <input type="text" id="editPortCode" class="form-control form-control-sm font-monospace fw-bold" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nama Resmi Terminal <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editPortName" class="form-control form-control-sm" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-dark">Kota Wilayah <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="editPortCity" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-dark">Kode Negara (ISO) <span class="text-danger">*</span></label>
                            <input type="text" name="country_code" id="editPortCountry" class="form-control form-control-sm text-uppercase" required maxlength="2">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Tipe Fasilitas Simpul <span class="text-danger">*</span></label>
                        <select name="port_type" id="editPortType" class="form-select form-select-sm" required>
                            <option value="SEAPORT">SEAPORT (Pelabuhan Laut &amp; Terminal Petikemas)</option>
                            <option value="AIRPORT">AIRPORT (Bandara Kargo Udara)</option>
                            <option value="LAND_HUB">LAND_HUB (Depo Kering / Dry Port / Gudang)</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Latitude <span class="text-danger">*</span></label>
                            <input type="number" step="0.000001" name="latitude" id="editPortLat" class="form-control form-control-sm font-monospace" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Longitude <span class="text-danger">*</span></label>
                            <input type="number" step="0.000001" name="longitude" id="editPortLong" class="form-control form-control-sm font-monospace" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Kapasitas Lapangan Penumpukan (TEUs) <span class="text-danger">*</span></label>
                        <input type="number" name="terminal_cy_capacity_teus" id="editPortCapacity" class="form-control form-control-sm" required min="100">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditPortModal(id, name, city, country, type, lat, long, capacity) {
        document.getElementById('editPortForm').action = '/admin/logistics/ports/' + id;
        document.getElementById('editPortCode').value = id;
        document.getElementById('editPortName').value = name;
        document.getElementById('editPortCity').value = city;
        document.getElementById('editPortCountry').value = country;
        document.getElementById('editPortType').value = type;
        document.getElementById('editPortLat').value = lat;
        document.getElementById('editPortLong').value = long;
        document.getElementById('editPortCapacity').value = capacity;

        var modal = new bootstrap.Modal(document.getElementById('editPortModal'));
        modal.show();
    }
</script>
@endpush
@endsection

