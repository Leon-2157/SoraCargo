@extends('layouts.app')

@section('title', 'Pelacakan & Manifes Muatan')

@section('content')
<!-- Page Header & Actions -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Pelacakan Armada &amp; Manifes Muatan</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary fw-semibold px-2 py-1">
                <x-icon name="satellite" size="0.85rem" class="me-1" /> Radar Maritim
            </span>
        </div>
        <p class="text-muted small mb-0">Radar pemantauan armada kapal, pelacakan kontainer di laut, dan penerbitan surat manifes resmi pelabuhan (voyage).</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <button class="btn btn-primary btn-sm shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#createManifestModal">
            <x-icon name="plus" size="0.9rem" class="me-1" /> + Terbitkan Manifes Baru
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
    <!-- Card 1: Active Sailing -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-primary shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Armada Sedang Berlayar</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $activeSailingCount }} Armada</div>
                        <div class="text-muted text-xs mt-1">
                            <span class="text-primary fw-semibold"><x-icon name="navigation" size="0.75rem" /> Live Radar:</span> Di laut lepas
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-primary-subtle p-3 rounded-circle text-primary">
                            <x-icon name="ship" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Preparing / Staging -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-warning shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Persiapan &amp; Segel CY</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $preparingCount }} Kapal</div>
                        <div class="text-muted text-xs mt-1">
                            Pemuatan petikemas di dermaga
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-warning-subtle p-3 rounded-circle text-warning">
                            <x-icon name="anchor" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Arrived in Port -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-success shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Armada Sandar / Tiba</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $arrivedCount }} Kapal</div>
                        <div class="text-muted text-xs mt-1">
                            Siap proses bongkar muat
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-success-subtle p-3 rounded-circle text-success">
                            <x-icon name="check-circle" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Containers Monitored -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-info shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Petikemas Termonitor</div>
                        <div class="text-dark fw-bold h4 mb-0">{{ $totalContainersCount }} Unit ISO</div>
                        <div class="text-muted text-xs mt-1">
                            <span class="text-info fw-semibold">Segel Resmi:</span> Terdata di manifes
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-info-subtle p-3 rounded-circle text-info">
                            <x-icon name="boxes" size="1.5rem" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card: Manifes Pelayaran Register -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold">
            <x-icon name="satellite" class="me-2" />Daftar Manifes Pelayaran &amp; Muatan Aktif
        </h6>
        <span class="badge bg-light text-primary border">Total {{ $manifests->total() }} Manifes Terdaftar</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters (Semua, Sedang Berlayar, Persiapan CY, Sandar/Tiba) -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="fleetTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($status) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.fleets.index', array_filter(['hub' => $hubId, 'search' => $search])) }}">
                    Semua Manifes ({{ $manifests->total() }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $status === 'SAILING' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.fleets.index', array_filter(['status' => 'SAILING', 'hub' => $hubId, 'search' => $search])) }}">
                    <x-icon name="ship" class="me-1" /> Sedang Berlayar ({{ $activeSailingCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $status === 'PREPARING' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.fleets.index', array_filter(['status' => 'PREPARING', 'hub' => $hubId, 'search' => $search])) }}">
                    <x-icon name="anchor" class="me-1" /> Persiapan CY ({{ $preparingCount }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status === 'ARRIVED' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.fleets.index', array_filter(['status' => 'ARRIVED', 'hub' => $hubId, 'search' => $search])) }}">
                    <x-icon name="check-circle" class="me-1" /> Tiba di Pelabuhan ({{ $arrivedCount }})
                </a>
            </li>
        </ul>

        <!-- Filter & Search Controls Form -->
        <form method="GET" action="{{ route('admin.fleets.index') }}" class="row mb-3 g-2">
            @if(!empty($status))
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="col-md-4 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Filter Hub:</label>
                    <select name="hub" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" {{ empty($hubId) || $hubId === 'all' ? 'selected' : '' }}>Semua Pelabuhan Hub</option>
                        @foreach($ports as $port)
                            <option value="{{ $port->id }}" {{ $hubId === $port->id ? 'selected' : '' }}>
                                {{ $port->name }} ({{ $port->id }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari nomor manifes, nama kapal, voyage, nomor kontainer..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                    @if(!empty($search) || (!empty($hubId) && $hubId !== 'all'))
                        <a href="{{ route('admin.fleets.index', array_filter(['status' => $status])) }}" class="btn btn-outline-danger" title="Reset Filter">
                            <x-icon name="x" />
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="manifestsTable">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Manifes &amp; Voyage</th>
                        <th>Armada Kapal / Kendaraan</th>
                        <th>Rute Pelabuhan</th>
                        <th>Jadwal Keberangkatan &amp; ETA</th>
                        <th>Muatan Petikemas</th>
                        <th>Status Siklus</th>
                        <th class="text-center">Aksi Manifes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($manifests as $item)
                        @php
                            $origin = $item->originPort;
                            $destination = $item->destinationPort;
                            $itemsCount = $item->items->count();
                        @endphp
                        <tr>
                            <!-- 1. Nomor Manifes & Voyage -->
                            <td>
                                <div class="fw-bold font-monospace text-primary">{{ $item->manifest_number }}</div>
                                <div class="mt-1">
                                    <span class="badge bg-light text-dark border font-monospace">Voyage: {{ $item->voyage_number }}</span>
                                </div>
                                <div class="text-muted text-xs mt-1">
                                    <x-icon name="clock" size="0.75rem" class="me-1" />
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                                </div>
                            </td>

                            <!-- 2. Armada Kapal -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="p-2 bg-light rounded-circle me-2 text-primary">
                                        <x-icon name="ship" size="1.25rem" />
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->vessel_or_vehicle_name }}</div>
                                        <div class="text-muted text-xs">Kapal Kargo Kontainer</div>
                                    </div>
                                </div>
                            </td>

                            <!-- 3. Rute Pelabuhan -->
                            <td>
                                <div>
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->origin_port_id }} &rarr; {{ $item->destination_port_id }}
                                    </span>
                                </div>
                                <div class="text-muted text-xs mt-1">
                                    {{ $origin ? $origin->name : '-' }} ke {{ $destination ? $destination->name : '-' }}
                                </div>
                            </td>

                            <!-- 4. Jadwal Keberangkatan & ETA -->
                            <td>
                                <div class="small">
                                    <span class="text-muted">ETD:</span> <strong>{{ $item->departure_eta ? $item->departure_eta->format('d M H:i') : '-' }}</strong>
                                </div>
                                <div class="small mt-1">
                                    <span class="text-muted">ETA:</span> <strong class="text-primary">{{ $item->arrival_eta ? $item->arrival_eta->format('d M H:i') : '-' }}</strong>
                                </div>
                                <div class="text-muted text-xs mt-1">
                                    @if($item->arrival_eta && $item->arrival_eta->isFuture())
                                        Tiba dalam {{ $item->arrival_eta->diffForHumans(null, true) }}
                                    @else
                                        Sudah Melewati ETA
                                    @endif
                                </div>
                            </td>

                            <!-- 5. Muatan Petikemas & Nomor Segel -->
                            <td>
                                <div class="d-flex align-items-center mb-1">
                                    <button class="btn btn-xs btn-outline-info py-0 px-2 fw-semibold me-2" type="button"
                                        onclick="openManifestContainersModal('{{ $item->id }}', '{{ $item->manifest_number }}')">
                                        <x-icon name="boxes" size="0.75rem" class="me-1" /> {{ $itemsCount }} Petikemas
                                    </button>
                                    <button class="btn btn-xs btn-outline-primary py-0 px-1" type="button" 
                                        onclick="openAttachContainerModal('{{ $item->id }}', '{{ $item->manifest_number }}')"
                                        title="Muat Kontainer Baru ke Manifes">
                                        <x-icon name="plus" size="0.7rem" /> Muat
                                    </button>
                                </div>
                                @if($itemsCount > 0)
                                    <div class="d-flex flex-column gap-1 mt-1">
                                        @foreach($item->items->take(2) as $cItem)
                                            <div class="d-flex align-items-center gap-1 font-monospace" style="font-size: 0.72rem;">
                                                <span class="badge bg-dark-subtle text-dark border px-1" title="Tipe: {{ $cItem->container_type }}">
                                                    {{ str_replace(['DRY_', '_'], ['', ' '], $cItem->container_type ?? '20FT') }}
                                                </span>
                                                <span class="fw-bold text-primary">{{ $cItem->container_serial_number }}</span>
                                                <span class="text-muted" title="Nomor Segel Bea Cukai / Pelayaran">
                                                    <x-icon name="lock" size="0.65rem" class="text-success" /> {{ $cItem->seal_number ?? 'NO-SEAL' }}
                                                </span>
                                            </div>
                                        @endforeach
                                        @if($itemsCount > 2)
                                            <a href="javascript:void(0)" onclick="openManifestContainersModal('{{ $item->id }}', '{{ $item->manifest_number }}')" class="small text-decoration-none text-info text-xs">
                                                +{{ $itemsCount - 2 }} kontainer lainnya &rsaquo;
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-muted text-xs fst-italic">Belum ada kontainer</div>
                                @endif
                            </td>

                            <!-- 6. Status Siklus -->
                            <td>
                                @if($item->status === 'SAILING')
                                    <span class="badge badge-domestic">
                                        <x-icon name="ship" size="0.75rem" class="me-1" /> SAILING (Berlayar)
                                    </span>
                                @elseif($item->status === 'LOCKED_SEALED')
                                    <span class="badge bg-info text-white">
                                        <x-icon name="lock" size="0.75rem" class="me-1" /> TERSEGEL RESMI
                                    </span>
                                @elseif($item->status === 'PREPARING')
                                    <span class="badge bg-warning text-dark">
                                        <x-icon name="anchor" size="0.75rem" class="me-1" /> PEMUATAN CY
                                    </span>
                                @elseif($item->status === 'ARRIVED')
                                    <span class="badge badge-active">
                                        <x-icon name="check-circle" size="0.75rem" class="me-1" /> SANDAR DI PELABUHAN
                                    </span>
                                @elseif($item->status === 'UNLOADED')
                                    <span class="badge bg-secondary">
                                        <x-icon name="boxes" size="0.75rem" class="me-1" /> SELESAI BONGKAR
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </td>

                            <!-- 7. Aksi Manifes -->
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" type="button"
                                        onclick="openManifestContainersModal('{{ $item->id }}', '{{ $item->manifest_number }}')"
                                        title="Buka Daftar Kontainer & Segel">
                                        <x-icon name="boxes" size="0.8rem" class="me-1" /> Rincian
                                    </button>
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="openManifestStatusModal('{{ $item->id }}', '{{ $item->manifest_number }}', '{{ $item->status }}')"
                                        title="Ubah Status Siklus Pelayaran">
                                        <x-icon name="sliders-horizontal" size="0.8rem" class="me-1" /> Siklus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <x-icon name="ship" size="2.5rem" class="mb-2 text-secondary opacity-50" />
                                    <div class="fw-bold">Tidak ada manifes pelayaran ditemukan</div>
                                    <div class="small">Silakan terbitkan manifes baru atau sesuaikan filter pencarian Anda.</div>
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
                    Menampilkan {{ $manifests->firstItem() ?? 0 }} sampai {{ $manifests->lastItem() ?? 0 }} dari {{ $manifests->total() }} surat manifes armada
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                {{ $manifests->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: CREATE NEW MANIFEST -->
<div class="modal fade" id="createManifestModal" tabindex="-1" aria-labelledby="createManifestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="createManifestLabel">
                    <x-icon name="plus" class="me-2" />Terbitkan Surat Manifes Pelayaran Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.fleets.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <x-icon name="info" class="me-1" />
                        Manifes pelayaran mengikat seluruh petikemas kargo ke dalam satu nomor voyage resmi Syahbandar/KSOP sebelum Surat Persetujuan Berlayar (SPB) diterbitkan.
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Pelabuhan Asal Muat (Origin) <span class="text-danger">*</span></label>
                            <select name="origin_port_id" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Pelabuhan Asal --</option>
                                @foreach($ports as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Pelabuhan Tujuan Bongkar (Destination) <span class="text-danger">*</span></label>
                            <select name="destination_port_id" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Pelabuhan Tujuan --</option>
                                @foreach($ports as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->id }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Kapal / Kendaraan Armada <span class="text-danger">*</span></label>
                            <input type="text" name="vessel_or_vehicle_name" class="form-control form-control-sm" placeholder="Contoh: KM Sora Bahari 09" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor Pelayaran / Voyage Number <span class="text-danger">*</span></label>
                            <input type="text" name="voyage_number" class="form-control form-control-sm font-monospace text-uppercase" placeholder="Contoh: VOY-092/XI" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Estimasi Keberangkatan (ETD) <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="departure_eta" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Estimasi Kedatangan (ETA) <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="arrival_eta" class="form-control form-control-sm" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="plus" class="me-1" /> Terbitkan Manifes Pelayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: UPDATE MANIFEST STATUS -->
<div class="modal fade" id="updateManifestStatusModal" tabindex="-1" aria-labelledby="manifestStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="manifestStatusLabel">
                    <x-icon name="sliders-horizontal" class="me-2" />Perbarui Siklus Manifes: <span id="modalManifestTitle" class="font-monospace"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateManifestStatusForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <x-icon name="info" class="me-1" />
                        Mengubah status manifes ke <strong>SAILING</strong> akan secara otomatis memperbarui seluruh resi kargo yang ada di dalam petikemas kapal ini ke status berlayar.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Status Siklus Manifes</label>
                        <select name="status" id="modalManifestStatusSelect" class="form-select form-select-sm" required>
                            <option value="PREPARING">PREPARING (Pemuatan Petikemas di CY Depo)</option>
                            <option value="LOCKED_SEALED">LOCKED_SEALED (Terkunci &amp; Segel Resmi Terpasang)</option>
                            <option value="SAILING">SAILING (Kapal/Armada Sedang Berlayar di Laut)</option>
                            <option value="ARRIVED">ARRIVED (Kapal Sandar di Pelabuhan Tujuan)</option>
                            <option value="UNLOADED">UNLOADED (Proses Bongkar Petikemas Selesai)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Status Siklus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: ATTACH CONTAINER TO MANIFEST -->
<div class="modal fade" id="attachContainerModal" tabindex="-1" aria-labelledby="attachContainerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="attachContainerLabel">
                    <x-icon name="boxes" class="me-2" />Pasang Petikemas ke Manifes: <span id="modalAttachManifestTitle" class="font-monospace"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="attachContainerForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Resi Kargo yang Dimuat <span class="text-danger">*</span></label>
                        <select name="cargo_booking_id" class="form-select form-select-sm" required>
                            <option value="" disabled selected>-- Pilih Pesanan Kargo --</option>
                            @foreach($unmanifestedBookings as $ub)
                                <option value="{{ $ub->id }}">
                                    {{ $ub->tracking_number }} - {{ $ub->shipper ? $ub->shipper->name : '-' }} ({{ number_format($ub->total_weight_kg, 0, ',', '.') }} kg)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-7">
                            <label class="form-label small fw-bold">Nomor Seri Petikemas (ISO 6346) <span class="text-danger">*</span></label>
                            <input type="text" name="container_serial_number" class="form-control form-control-sm font-monospace text-uppercase" placeholder="SRAU-728192-0" required>
                        </div>
                        <div class="col-5">
                            <label class="form-label small fw-bold">Tipe Kontainer <span class="text-danger">*</span></label>
                            <select name="container_type" class="form-select form-select-sm" required>
                                <option value="DRY_20FT">Dry 20ft</option>
                                <option value="DRY_40FT">Dry 40ft</option>
                                <option value="REEFER_40HC">Reefer 40HC</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Segel KSOP / Bea Cukai <span class="text-danger">*</span></label>
                        <input type="text" name="seal_number" class="form-control form-control-sm font-monospace text-uppercase" placeholder="SRA-SEAL-88912" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="lock" class="me-1" /> Pasang Petikemas &amp; Segel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: RINCIAN PETIKEMAS & VERIFIKASI SEGEL MANIFES (ops.manifest_items) -->
<div class="modal fade" id="manifestContainersModal" tabindex="-1" aria-labelledby="manifestContainersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <x-icon name="boxes" size="1.25rem" class="text-info" />
                    <div>
                        <h6 class="modal-title fw-bold mb-0" id="manifestContainersModalLabel">
                            Daftar Petikemas &amp; Verifikasi Nomor Segel Manifes
                        </h6>
                        <span id="mcModalManifestNo" class="font-monospace small text-info"></span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="mcModalStatusBadge" class="badge"></span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <!-- Info Ringkasan Armada -->
                <div class="card border-0 bg-light mb-4 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center text-xs">
                            <div class="col-md-3">
                                <div class="text-muted text-uppercase fw-semibold">Armada &amp; Voyage</div>
                                <div class="fw-bold text-dark mt-1">
                                    <span id="mcModalVessel">-</span>
                                    <div class="text-muted font-monospace" id="mcModalVoyage">-</div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-muted text-uppercase fw-semibold">Rute Pelayaran</div>
                                <div class="fw-bold text-primary mt-1">
                                    <span id="mcModalOrigin">-</span> &rarr; <span id="mcModalDestination">-</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <button type="button" class="btn btn-sm btn-primary" onclick="triggerAttachFromDetail()">
                                    <x-icon name="plus" size="0.85rem" class="me-1" /> Muat Petikemas Baru
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Petikemas & Segel -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle border mb-0" id="manifestContainersTable">
                        <thead class="table-light">
                            <tr class="text-xs">
                                <th>No. Seri Kontainer (ISO 6346)</th>
                                <th>Tipe Petikemas</th>
                                <th>Nomor Segel (KSOP / Ditjen Cukai)</th>
                                <th>No. Resi &amp; Shipper</th>
                                <th>Bobot &amp; Kubikasi</th>
                                <th>Status Kargo</th>
                            </tr>
                        </thead>
                        <tbody id="mcTableBody">
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <span class="spinner-border spinner-border-sm text-primary me-2"></span> Memuat data petikemas...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="mcEmptyState" class="text-center py-5 bg-light rounded border mt-3" style="display: none;">
                    <x-icon name="package" size="2.5rem" class="text-muted opacity-50 mb-2" />
                    <div class="fw-semibold text-dark">Belum ada petikemas yang dipasang pada manifes ini</div>
                    <div class="text-muted text-xs mt-1">Gunakan tombol "Muat Petikemas Baru" untuk memasukkan kontainer dan segel resmi.</div>
                </div>
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentActiveManifestId = null;
let currentActiveManifestNo = null;

function openManifestStatusModal(id, manifestNo, currentStatus) {
    document.getElementById('modalManifestTitle').innerText = manifestNo;
    document.getElementById('modalManifestStatusSelect').value = currentStatus;
    document.getElementById('updateManifestStatusForm').action = '/admin/fleets/' + id + '/status';

    const modal = new bootstrap.Modal(document.getElementById('updateManifestStatusModal'));
    modal.show();
}

function openAttachContainerModal(id, manifestNo) {
    document.getElementById('modalAttachManifestTitle').innerText = manifestNo;
    document.getElementById('attachContainerForm').action = '/admin/fleets/' + id + '/attach';

    const modal = new bootstrap.Modal(document.getElementById('attachContainerModal'));
    modal.show();
}

function triggerAttachFromDetail() {
    if (!currentActiveManifestId || !currentActiveManifestNo) return;
    const detailModalEl = document.getElementById('manifestContainersModal');
    const detailModal = bootstrap.Modal.getInstance(detailModalEl);
    if (detailModal) detailModal.hide();

    openAttachContainerModal(currentActiveManifestId, currentActiveManifestNo);
}

function openManifestContainersModal(manifestId, manifestNo) {
    currentActiveManifestId = manifestId;
    currentActiveManifestNo = manifestNo;

    document.getElementById('mcModalManifestNo').innerText = manifestNo;
    document.getElementById('mcTableBody').innerHTML = `
        <tr>
            <td colspan="6" class="text-center py-4">
                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Memuat data petikemas &amp; nomor segel dari database...
            </td>
        </tr>
    `;
    document.getElementById('mcEmptyState').style.display = 'none';

    const modalEl = document.getElementById('manifestContainersModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();

    fetch('/admin/fleets/' + manifestId + '/containers')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.manifest) {
                const m = data.manifest;
                document.getElementById('mcModalVessel').innerText = m.vessel || '-';
                document.getElementById('mcModalVoyage').innerText = m.voyage || '-';
                document.getElementById('mcModalOrigin').innerText = m.origin || '-';
                document.getElementById('mcModalDestination').innerText = m.destination || '-';

                const badge = document.getElementById('mcModalStatusBadge');
                badge.innerText = m.status;
                badge.className = 'badge ' + (m.status === 'SAILING' ? 'bg-primary' : (m.status === 'ARRIVED' ? 'bg-success' : 'bg-info'));

                const items = data.items || [];
                if (items.length > 0) {
                    let html = '';
                    items.forEach(it => {
                        const typeBadge = it.container_type === 'REEFER_40HC' ? 'bg-info text-white' : (it.container_type === 'DRY_40FT' ? 'bg-dark text-white' : 'bg-secondary text-white');

                        html += `
                            <tr>
                                <td>
                                    <div class="fw-bold font-monospace text-primary" style="font-size: 0.9rem;">
                                        ${it.container_serial_number}
                                    </div>
                                    <div class="text-muted text-xs">ISO Container Validated</div>
                                </td>
                                <td>
                                    <span class="badge ${typeBadge} text-xs font-monospace">
                                        ${it.container_type.replace('_', ' ')}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 font-monospace fw-bold text-dark" style="font-size: 0.85rem;">
                                        <svg class="lucide-icon inline-block align-middle text-success" xmlns="http://www.w3.org/2000/svg" width="0.85rem" height="0.85rem" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                        <span>${it.seal_number}</span>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success text-xs mt-1">TERSEGEL RESMI</span>
                                </td>
                                <td>
                                    <div class="font-monospace fw-bold text-dark text-xs">${it.tracking_number}</div>
                                    <div class="text-muted text-xs">${it.shipper}</div>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-dark">${Number(it.weight).toLocaleString('id-ID')} kg</div>
                                    <div class="text-muted text-xs">${Number(it.volume).toLocaleString('id-ID')} CBM</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border text-xs font-monospace">
                                        ${it.cargo_status}
                                    </span>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById('mcTableBody').innerHTML = html;
                } else {
                    document.getElementById('mcTableBody').innerHTML = '';
                    document.getElementById('mcEmptyState').style.display = 'block';
                }
            }
        })
        .catch(() => {
            document.getElementById('mcTableBody').innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4 text-danger">
                        Gagal memuat data petikemas dari server.
                    </td>
                </tr>
            `;
        });
}
</script>
@endsection

