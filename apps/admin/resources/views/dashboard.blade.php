@extends('layouts.app')

@section('title', 'Menara Kendali Superadmin (Global Cockpit)')
@section('page_title', 'Menara Kendali Superadmin (Global Cockpit)')

@push('styles')
<!-- Leaflet.js CSS (Local Offline Asset) -->
<link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
<style>
    /* Styling Peta Cockpit Leaflet */
    #cockpitMap {
        height: 440px;
        width: 100%;
        border-radius: 0.5rem;
        z-index: 1;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        padding: 4px;
    }
    .leaflet-popup-content {
        margin: 10px 12px;
        line-height: 1.4;
        font-family: inherit;
    }
    .pulse-marker {
        display: block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #0284c7;
        box-shadow: 0 0 0 rgba(2, 132, 199, 0.4);
        animation: pulseAnimation 2s infinite;
        border: 2px solid #ffffff;
    }
    .pulse-marker.danger {
        background: #ef4444;
        box-shadow: 0 0 0 rgba(239, 68, 68, 0.4);
    }
    .pulse-marker.warning {
        background: #f59e0b;
        box-shadow: 0 0 0 rgba(245, 158, 11, 0.4);
    }
    @keyframes pulseAnimation {
        0% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.7); }
        70% { box-shadow: 0 0 0 12px rgba(2, 132, 199, 0); }
        100% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0); }
    }
    .vessel-icon {
        background-color: #1e293b;
        color: #ffffff;
        border: 2px solid #38bdf8;
        border-radius: 50%;
        text-align: center;
        line-height: 24px;
        width: 28px !important;
        height: 28px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
    }
    .leaflet-control-zoom-reset:hover {
        background-color: #f1f5f9 !important;
        color: #0284c7 !important;
    }
    .weather-pill {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
</style>
@endpush

@section('content')
<!-- MAIN COCKPIT 2-COLUMN GRID (Matching User Wireframe) -->
<div class="row g-4 align-items-stretch">
    <!-- ========================================== -->
    <!-- LEFT COLUMN: MAPS & REGIONAL CY CAPACITIES -->
    <!-- ========================================== -->
    <div class="col-xl-7 col-lg-12 d-flex flex-column">
        <!-- 1. LIVE INTERACTIVE MAPS (Leaflet + OpenStreetMap + OpenWeatherMap + OpenCage) -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-body p-2 position-relative">
                <!-- Map Container -->
                <div id="cockpitMap"></div>
            </div>
        </div>

        @if(isset($scope) && $scope === 'internasional')
        <!-- 2. PERKIRAAN CUACA 30 HARI & RISIKO METOCEAN RUTE GLOBAL (Khusus Internasional) -->
        <div class="card border-0 shadow-sm mb-4 flex-grow-1 d-flex flex-column">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="p-2 bg-danger-subtle text-danger rounded-circle">
                        <x-icon name="cloud-lightning" size="1.1rem" />
                    </span>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Perkiraan Cuaca 30 Hari Rute Global</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">Deteksi dini gelombang laut, siklon &amp; hak otoritas tahan rute pelayaran internasional</small>
                    </div>
                </div>
                <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1" style="font-size: 0.75rem;">
                    <x-icon name="alert-triangle" size="0.8rem" class="me-1" /> MetOcean Radar Active
                </span>
            </div>
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="row g-3">
                    @foreach($weatherRiskRoutes as $r)
                        <div class="col-md-6">
                            <div class="p-3 border rounded h-100 {{ $r['is_held'] ? 'border-danger bg-danger-subtle bg-opacity-25' : ($r['risk_level'] === 'DANGER' ? 'border-danger-subtle bg-danger-subtle bg-opacity-10' : ($r['risk_level'] === 'MODERATE' ? 'border-warning-subtle bg-warning-subtle bg-opacity-10' : 'border-success-subtle bg-light')) }}">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $r['name'] }}</div>
                                        <div class="text-muted small" style="font-size: 0.75rem;">{{ $r['flag_origin'] }} {{ $r['corridor'] }} {{ $r['flag_dest'] }}</div>
                                    </div>
                                    @if($r['is_held'])
                                        <span class="badge bg-danger text-white fw-bold px-2 py-1" style="font-size: 0.7rem;">
                                            WEATHER HOLD
                                        </span>
                                    @elseif($r['risk_level'] === 'DANGER')
                                        <span class="badge bg-danger-subtle text-danger border border-danger fw-bold px-2 py-1" style="font-size: 0.7rem;">
                                            BAHAYA SIKLON
                                        </span>
                                    @elseif($r['risk_level'] === 'MODERATE')
                                        <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1" style="font-size: 0.7rem;">
                                            WASPADA MONSUN
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1" style="font-size: 0.7rem;">
                                            AMAN BERLAYAR
                                        </span>
                                    @endif
                                </div>

                                <div class="my-2 py-1 px-2 rounded bg-white border d-flex justify-content-between align-items-center" style="font-size: 0.76rem;">
                                    <span>Prakiraan: <strong>{{ $r['high_risk_day'] }}</strong></span>
                                    <span class="{{ $r['risk_level'] === 'DANGER' ? 'text-danger fw-bold' : 'text-dark' }}">Gelombang: <strong>{{ $r['wave_height'] }}</strong> ({{ $r['wind_speed'] }})</span>
                                </div>

                                <p class="text-muted mb-2" style="font-size: 0.73rem; line-height: 1.35;">{{ $r['description'] }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-auto pt-1">
                                    <span class="text-muted" style="font-size: 0.72rem;">Armada di Rute: <strong>{{ $r['vessels_affected'] }} Kapal</strong></span>
                                    @if($r['is_held'])
                                        <button type="button" class="btn btn-xs btn-outline-success fw-semibold btn-lift-weather-hold" data-route-id="{{ $r['id'] }}">
                                            <x-icon name="check-circle" size="0.75rem" class="me-1" /> Cabut Hold
                                        </button>
                                    @elseif($r['risk_level'] === 'DANGER' || $r['risk_level'] === 'MODERATE')
                                        <button type="button" class="btn btn-xs btn-danger fw-semibold d-inline-flex align-items-center gap-1 shadow-xs btn-open-weather-hold" 
                                            data-route-id="{{ $r['id'] }}" 
                                            data-route-name="{{ $r['name'] }}" 
                                            data-corridor="{{ $r['corridor'] }}"
                                            data-wave="{{ $r['wave_height'] }}" 
                                            data-wind="{{ $r['wind_speed'] }}" 
                                            data-hazard="{{ $r['hazard_type'] }}">
                                            <x-icon name="cloud-lightning" size="0.75rem" /> Tahan Rute (Weather Hold)
                                        </button>
                                    @else
                                        <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.7rem;">Normal 30 Hari</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <!-- 2. KAPASITAS DEPO & TERMINAL PETIKEMAS REGIONAL (Domestik) -->
        <div class="card border-0 shadow-sm mb-4 flex-grow-1 d-flex flex-column">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="p-2 bg-info-subtle text-info rounded-circle">
                        <x-icon name="boxes" size="1.1rem" />
                    </span>
                    <h6 class="fw-bold text-dark mb-0">Kapasitas Depo &amp; Terminal Petikemas Regional</h6>
                </div>
                <a href="{{ route('admin.logistics.ports') }}" class="btn btn-xs btn-outline-primary fw-semibold">
                    Kelola Semua Pelabuhan &rarr;
                </a>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="row g-4">
                    @php
                        // Simulasi Yard Occupancy Rate (YOR) realistis untuk pelabuhan Indonesia
                        $yorData = [
                            'IDJKT' => ['yor' => 78, 'occupied' => 11700, 'status' => 'Waspada (Tinggi)'],
                            'IDSUB' => ['yor' => 64, 'occupied' => 7680, 'status' => 'Optimal'],
                            'IDBTM' => ['yor' => 45, 'occupied' => 3600, 'status' => 'Lancar'],
                            'IDMAK' => ['yor' => 88, 'occupied' => 6600, 'status' => 'Kritis (Congestion)'],
                        ];
                    @endphp

                    @foreach($ports->take(4) as $port)
                        @php
                            $code = $port->id;
                            $info = $yorData[$code] ?? ['yor' => 55, 'occupied' => (int)($port->terminal_cy_capacity_teus * 0.55), 'status' => 'Normal'];
                            $yor = $info['yor'];
                            $barClass = $yor > 80 ? 'bg-danger' : ($yor > 70 ? 'bg-warning' : 'bg-primary');
                        @endphp
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $port->name }}</div>
                                        <div class="text-muted small">{{ $port->city }} ({{ $port->id }})</div>
                                    </div>
                                    <span class="badge {{ $yor > 80 ? 'bg-danger text-white' : ($yor > 70 ? 'bg-warning text-dark' : 'bg-success text-white') }}">
                                        YOR {{ $yor }}%
                                    </span>
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar {{ $barClass }}" role="progressbar" style="width: {{ $yor }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.75rem;">
                                    <span>Terisi: <strong>{{ number_format($info['occupied']) }} TEUs</strong></span>
                                    <span>Pagu: <strong>{{ number_format($port->terminal_cy_capacity_teus) }} TEUs</strong></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- ======================================================== -->
    <!-- RIGHT COLUMN: 4 KPI STATS, CARGO TREND, URGENT & MODES   -->
    <!-- ======================================================== -->
    <div class="col-xl-5 col-lg-12 d-flex flex-column">
        <!-- 1. 4 KPI STATS IN A 2x2 GRID (Preserving wireframe box layout) -->
        <div class="row g-3 mb-4">
            <!-- Top-Left: Margin Platform (Bulan Ini) -->
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
                    <div class="card-body p-3">
                        <div class="text-uppercase text-muted fw-bold text-xs">Margin Platform (Bulan Ini)</div>
                        <h4 class="fw-bold text-primary mb-0 mt-1 money-amount" data-amount-idr="{{ $totalPlatformProfit }}">Rp {{ number_format($totalPlatformProfit, 0, ',', '.') }}</h4>
                        <div class="small text-success mt-1">
                            <x-icon name="arrow-up" size="0.75rem" /> <strong>12.5%</strong> rata-rata take-rate
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top-Right: Dana Terkunci di Escrow -->
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
                    <div class="card-body p-3">
                        <div class="text-uppercase text-muted fw-bold text-xs">Dana Terkunci di Escrow</div>
                        <h4 class="fw-bold text-success mb-0 mt-1 money-amount" data-amount-idr="{{ $totalEscrowHeld }}">Rp {{ number_format($totalEscrowHeld, 0, ',', '.') }}</h4>
                        <div class="small text-muted mt-1">
                            <x-icon name="shield-check" size="0.75rem" /> Rekening Bersama M1–M3
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom-Left: Armada Aktif di Laut/Darat -->
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm border-start border-4 border-info h-100">
                    <div class="card-body p-3">
                        <div class="text-uppercase text-muted fw-bold text-xs">Armada Aktif di Laut/Darat</div>
                        <h4 class="fw-bold text-dark mb-0 mt-1">{{ $activeFleetsCount }} <span class="fs-6 fw-normal text-muted">Manifes</span></h4>
                        <div class="small text-muted mt-1">
                            <x-icon name="boxes" size="0.75rem" /> Kapal Tol Laut &amp; Truk Trans
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom-Right: Tiket Eskalasi Kritis -->
            <div class="col-sm-6">
                <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                    <div class="card-body p-3">
                        <div class="text-uppercase text-muted fw-bold text-xs">Tiket Eskalasi Kritis</div>
                        <h4 class="fw-bold {{ $criticalEscalationsCount > 0 ? 'text-danger' : 'text-dark' }} mb-0 mt-1">
                            {{ $criticalEscalationsCount }} <span class="fs-6 fw-normal text-muted">Kasus</span>
                        </h4>
                        <div class="small {{ $criticalEscalationsCount > 0 ? 'text-danger' : 'text-muted' }} mt-1">
                            <x-icon name="shield-alert" size="0.75rem" /> Butuh disposisi darurat
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. TREN VOLUME MUATAN KARGO (Line Chart) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">Tren Volume Muatan Kargo</h6>
                <div class="btn-group btn-group-sm" role="group" id="cargoModalityFilter">
                    <button type="button" class="btn btn-primary active py-0 px-2 fw-semibold" data-mode="all" style="font-size: 0.75rem;">Semua</button>
                    <button type="button" class="btn btn-outline-primary py-0 px-2 fw-semibold" data-mode="sea" style="font-size: 0.75rem;">Kapal</button>
                    <button type="button" class="btn btn-outline-primary py-0 px-2 fw-semibold" data-mode="truck" style="font-size: 0.75rem;">Truk</button>
                    <button type="button" class="btn btn-outline-primary py-0 px-2 fw-semibold" data-mode="air" style="font-size: 0.75rem;">Pesawat</button>
                </div>
            </div>
            <div class="card-body p-3">
                <div style="height: 200px; position: relative;">
                    <canvas id="cargoVolumeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 3. DUA KARTU SEJAJAR: TINDAKAN MENDESAK & DISTRIBUSI MODA PENGIRIMAN -->
        <div class="row g-3 mb-4 flex-grow-1">
            <!-- Left: Tindakan Mendesak Superadmin -->
            <div class="col-md-7 d-flex flex-column">
                <div class="card border-0 shadow-sm h-100 d-flex flex-column">
                    <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">Tindakan Mendesak</h6>
                        <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">
                            {{ $pendingEscalations->count() + $pendingKyc->count() }} Menunggu
                        </span>
                    </div>
                    <div class="list-group list-group-flush flex-grow-1 d-flex flex-column justify-content-around" style="font-size: 0.8rem;">
                        @foreach($pendingEscalations as $esc)
                            <div class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center">
                                <div class="pe-2">
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-1" style="font-size: 0.65rem;">ESKALASI</span>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 140px;" title="{{ $esc->incident_ticket_no }}">
                                        {{ $esc->incident_ticket_no }}
                                    </div>
                                    <div class="text-muted money-amount" style="font-size: 0.7rem;" data-amount-idr="{{ $esc->requested_amount ?? 0 }}">Rp {{ number_format($esc->requested_amount ?? 0, 0, ',', '.') }}</div>
                                </div>
                                <a href="{{ route('admin.escalations.index') }}" class="btn btn-xs btn-outline-danger">Review</a>
                            </div>
                        @endforeach

                        @foreach($pendingKyc as $kyc)
                            <div class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center">
                                <div class="pe-2">
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-1" style="font-size: 0.65rem;">KYC_B2B</span>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 140px;" title="{{ $kyc->company?->company_name }}">
                                        {{ $kyc->company?->company_name ?? 'Perusahaan' }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.7rem;">TOP {{ $kyc->top_days }} Hari</div>
                                </div>
                                <a href="{{ route('admin.customers.corporate') }}" class="btn btn-xs btn-outline-primary">Periksa</a>
                            </div>
                        @endforeach

                        @if($pendingEscalations->isEmpty() && $pendingKyc->isEmpty())
                            <div class="list-group-item text-center py-4 text-muted flex-grow-1 d-flex flex-column align-items-center justify-content-center">
                                <x-icon name="check-circle" size="1.4rem" class="text-success mb-1" />
                                <div>Semua tugas operasional tuntas.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Koneksi Sistem & Infrastruktur (Mission Control NOC) -->
            <div class="col-md-5 d-flex flex-column">
                <div class="card border-0 shadow-sm h-100 d-flex flex-column">
                    <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge bg-success-subtle text-success p-1 rounded-circle d-flex align-items-center">
                                <span class="pulse-marker" style="width: 8px; height: 8px; background: #10b981;"></span>
                            </span>
                            <h6 class="fw-bold text-dark mb-0 ms-1" style="font-size: 0.85rem;">Koneksi Sistem</h6>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold" style="font-size: 0.68rem;">4/4 Online</span>
                    </div>
                    <div class="card-body p-2.5 d-flex flex-column justify-content-between flex-grow-1">
                        <div class="d-flex flex-column gap-2">
                            @foreach($systemHealth as $sys)
                                <div class="p-2 border rounded bg-light d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                        <div class="p-1.5 rounded-circle bg-white border text-primary flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                            <x-icon name="{{ $sys['icon'] }}" size="0.85rem" />
                                        </div>
                                        <div class="text-truncate">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.78rem;" title="{{ $sys['name'] }}">{{ $sys['name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.68rem;">{{ $sys['details'] }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">
                                            {{ $sys['status_label'] }}
                                        </span>
                                        @if($sys['action_url'] !== '#')
                                            <a href="{{ $sys['action_url'] }}" class="btn btn-xs btn-light border text-primary p-1 rounded" title="Kelola / Periksa">
                                                <x-icon name="arrow-up-right" size="0.75rem" />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.68rem;">Infrastruktur Server Cloud</span>
                            <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2 fw-semibold" id="btnRefreshHealth" style="font-size: 0.68rem;">
                                <x-icon name="refresh-cw" size="0.65rem" class="me-1" id="iconRefreshHealth" /> Ping Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- FLOATING AI COPILOT (SORABOT) POP-UP WIDGET              -->
<!-- ======================================================== -->
<style>
    /* Sembunyikan default scroll-to-top di dashboard agar digantikan tombol AI */
    .scroll-to-top {
        display: none !important;
    }
</style>

<!-- Modal Weather Hold Konfirmasi Cepat -->
<div class="modal fade" id="weatherHoldModal" tabindex="-1" aria-labelledby="weatherHoldModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom bg-danger text-white px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <x-icon name="alert-triangle" size="1.25rem" class="text-white" />
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="weatherHoldModalLabel" style="font-size: 1.1rem;">Disposisi Penahanan Rute (Weather Hold)</h5>
                        <p class="mb-0 text-white-50 small" style="font-size: 0.78rem;">Pemberhentian sementara pelayaran armada laut akibat anomali cuaca ekstrem</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <form id="weatherHoldForm">
                    <input type="hidden" id="whRouteId" name="route_id">

                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="text-muted small">Koridor Pelayaran Terdampak:</div>
                        <div class="fw-bold text-dark fs-6" id="whRouteName">-</div>
                        <div class="text-primary small mb-2" id="whCorridor">-</div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-danger-subtle text-danger border border-danger" id="whWaveMetric">Gelombang: -</span>
                            <span class="badge bg-danger-subtle text-danger border border-danger" id="whWindMetric">Angin: -</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Durasi Penahanan Pelayaran <span class="text-danger">*</span></label>
                        <select id="whDuration" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="24">24 Jam (Evaluasi Besok Pagi)</option>
                            <option value="48" selected>48 Jam (Rekomendasi Standar MetOcean)</option>
                            <option value="72">72 Jam (Siklon Kategori 2+)</option>
                            <option value="120">Sampai Pencabutan Peringatan Resmi BMKG</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Alasan Penahanan &amp; Dasar Disposisi <span class="text-danger">*</span></label>
                        <textarea id="whReason" class="form-control" rows="3" style="border-radius: 8px; font-size: 0.85rem;">Peringatan Dini MetOcean/BMKG: Siklon tropis dan tinggi gelombang melebihi 4.5 meter di koridor pelayaran. Demi keselamatan awak kapal dan muatan kargo, rute ditahan sementara (Weather Hold).</textarea>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="whNotifyCheck" checked>
                        <label class="form-check-label small text-muted" for="whNotifyCheck">
                            Kirim notifikasi WhatsApp &amp; Email darurat otomatis ke seluruh agen pelayaran, nakhoda kapal, dan shipper dengan muatan aktif di koridor ini.
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top px-4 py-3 d-flex justify-content-between">
                <button type="button" class="btn btn-light border text-secondary px-3 py-2 fw-medium" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="button" class="btn btn-danger d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm" id="btnConfirmWeatherHold" style="border-radius: 8px;">
                    <x-icon name="shield-alert" size="1rem" id="iconConfirmWh" />
                    <span id="textConfirmWh">Konfirmasi Tahan Rute</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet.js JS (Local Offline Asset) -->
<script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ========================================================
    // 1. INISIALISASI PETA TACTICAL COCKPIT (Leaflet + OpenStreetMap)
    // ========================================================
    const openWeatherKey = "{{ $openWeatherKey }}";
    const openCageKey = "{{ $openCageKey }}";

    const currentScope = "{{ $scope }}";
    const defaultCenter = (currentScope === 'internasional') ? [3.2, 110.0] : [-2.2, 118.0];
    const defaultZoom = (currentScope === 'internasional') ? 4 : 5;
    const map = L.map('cockpitMap', {
        center: defaultCenter,
        zoom: defaultZoom,
        minZoom: 3,
        maxZoom: 18,
        zoomControl: true
    });

    // Layer Utama: OpenStreetMap Standar
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Layer Satelit Cuaca OpenWeatherMap (Presipitasi / Hujan)
    const owmRainLayer = L.tileLayer(`https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=${openWeatherKey}`, {
        attribution: '&copy; OpenWeatherMap Radar',
        opacity: 0.65
    }).addTo(map);

    // Tombol Reset Tampilan Peta tepat di bawah tombol minus (-) zoom control
    const zoomContainer = document.querySelector('.leaflet-control-zoom');
    if (zoomContainer) {
        const resetBtn = document.createElement('a');
        resetBtn.className = 'leaflet-control-zoom-reset';
        resetBtn.href = '#';
        resetBtn.title = (currentScope === 'internasional') ? 'Reset Pandangan Global' : 'Reset Pandangan Nusantara';
        resetBtn.role = 'button';
        resetBtn.innerHTML = '&#x21bb;'; // ↻ Unicode refresh/reset symbol
        resetBtn.style.cssText = 'display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:bold; color:#333; text-decoration:none; cursor:pointer; width:30px; height:30px; background:#fff; border-top:1px solid #ccc;';
        
        resetBtn.addEventListener('click', function (e) {
            e.preventDefault();
            map.setView(defaultCenter, defaultZoom, { animate: true });
        });
        
        zoomContainer.appendChild(resetBtn);
    }

    // Floating Search Bar Control di Pojok Kanan Atas Peta (topright)
    const searchControl = L.control({ position: 'topright' });
    searchControl.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'leaflet-bar map-search-box');
        div.style.cssText = 'position:relative; border:none; background:transparent; box-shadow:none; width:280px; max-width:calc(100vw - 120px);';
        div.innerHTML = `
            <div style="background:#ffffff; border-radius:6px; box-shadow:0 3px 10px rgba(0,0,0,0.2); padding:3px; display:flex; align-items:center; border:1px solid rgba(0,0,0,0.15); position:relative; z-index:1001;">
                <input type="text" id="mapSearchInput" placeholder="Cari pelabuhan/kota..." autocomplete="off" style="border:none; outline:none; font-size:12px; padding:4px 8px; flex:1; background:transparent;">
                <button type="button" id="mapSearchBtn" style="border:none; background:#0284c7; color:#fff; border-radius:4px; width:26px; height:26px; display:flex; align-items:center; justify-content:center; cursor:pointer;" title="Cari Lokasi via OpenCage">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
            <div id="mapSearchSuggestions" style="display:none; position:absolute; top:36px; left:0; width:100%; background:#ffffff; border-radius:6px; box-shadow:0 8px 24px rgba(0,0,0,0.22); border:1px solid rgba(0,0,0,0.12); max-height:250px; overflow-y:auto; z-index:10002; font-size:12px;"></div>
        `;
        L.DomEvent.disableClickPropagation(div);
        L.DomEvent.disableScrollPropagation(div);
        return div;
    };
    searchControl.addTo(map);

    // ========================================================
    // 2. RENDERING TITIK PELABUHAN DENGAN FETCH CUACA REAL-TIME OWM
    // ========================================================
    const portsData = @json($ports);

    portsData.forEach(port => {
        const lat = parseFloat(port.latitude);
        const lng = parseFloat(port.longitude);
        if (isNaN(lat) || isNaN(lng)) return;

        // Custom pulsing dot icon
        const portIcon = L.divIcon({
            className: 'custom-port-marker',
            html: `<div class="pulse-marker" title="${port.name}"></div>`,
            iconSize: [14, 14],
            iconAnchor: [7, 7]
        });

        const marker = L.marker([lat, lng], { icon: portIcon }).addTo(map);

        // Siapkan template popup dengan placeholder cuaca
        const popupId = `port-weather-${port.id}`;
        const popupContent = `
            <div style="min-width: 200px;">
                <div class="fw-bold text-primary mb-1">${port.name}</div>
                <div class="small text-muted mb-2">${port.city} (${port.id})</div>
                <div class="small mb-2">
                    Kapasitas CY: <strong>${Number(port.terminal_cy_capacity_teus).toLocaleString('id-ID')} TEUs</strong>
                </div>
                <div id="${popupId}" class="weather-pill">
                    <span class="spinner-border spinner-border-sm text-secondary" style="width: 0.7rem; height: 0.7rem;"></span>
                    <span>Memuat cuaca laut...</span>
                </div>
            </div>
        `;

        marker.bindPopup(popupContent);

        // Saat popup dibuka, panggil API OpenWeatherMap untuk data suhu & angin laut saat ini
        marker.on('popupopen', function () {
            const container = document.getElementById(popupId);
            if (!container || container.dataset.loaded === 'true') return;

            fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&appid=${openWeatherKey}&units=metric&lang=id`)
                .then(res => res.json())
                .then(data => {
                    if (data.cod === 200) {
                        const temp = Math.round(data.main.temp);
                        const desc = data.weather[0]?.description || 'Cerah';
                        const windSpeed = data.wind?.speed || 0;
                        const iconCode = data.weather[0]?.icon || '01d';
                        
                        container.innerHTML = `
                            <img src="https://openweathermap.org/img/wn/${iconCode}.png" width="20" height="20" alt="weather">
                            <strong>${temp}&deg;C</strong>, ${desc} &bull; Angin: ${windSpeed} m/s
                        `;
                        container.dataset.loaded = 'true';
                    } else {
                        container.innerHTML = `<span>Cuaca: ${data.message || 'N/A'}</span>`;
                    }
                })
                .catch(() => {
                    container.innerHTML = `<span>Cuaca live tidak tersedia</span>`;
                });
        });
    });

    // ========================================================
    // 3. RENDERING RUTE MANIFES & KAPAL BERLAYAR (Polylines)
    // ========================================================
    const manifestRoutes = @json($manifestRoutes);

    manifestRoutes.forEach(r => {
        const origCoords = r.origin_coords;
        const destCoords = r.destination_coords;
        const vesselCoords = r.vessel_coords;

        const isWeatherHold = r.status === 'WEATHER_HOLD';
        const isIntl = r.is_international;
        const routeColor = isWeatherHold ? '#f59e0b' : (isIntl ? '#10b981' : '#0284c7');
        const routeDash = isWeatherHold ? '6, 8' : (isIntl ? '5, 5' : '4, 4');
        const routeWeight = isIntl ? 3.5 : 3;

        // Buat garis kurva lintasan kapal dari Origin ke Posisi Kapal ke Destinasi
        const latlngs = [origCoords, vesselCoords, destCoords];
        const polyline = L.polyline(latlngs, {
            color: routeColor,
            weight: routeWeight,
            dashArray: routeDash,
            opacity: 0.88
        }).addTo(map);

        // Marker Kapal Berlayar di tengah rute
        const shipHtml = `<div class="vessel-icon" title="${r.vessel}" style="position:relative;">🚢${isIntl ? '<span style="position:absolute; bottom:-3px; right:-3px; font-size:10px;">🌐</span>' : ''}</div>`;
        const shipIcon = L.divIcon({
            className: 'custom-ship-marker',
            html: shipHtml,
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        const shipMarker = L.marker(vesselCoords, { icon: shipIcon }).addTo(map);
        
        const shipPopup = `
            <div style="min-width: 240px; font-family: inherit;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="badge ${isWeatherHold ? 'bg-warning text-dark' : (isIntl ? 'bg-success text-white' : 'bg-primary')} px-2 py-1">
                        ${isWeatherHold ? '⚠️ TAHAN CUACA (BMKG)' : (isIntl ? '🌍 FEEDER INTERNASIONAL' : '🚢 SEDANG BERLAYAR')}
                    </span>
                    <small class="font-monospace text-muted">${r.voyage}</small>
                </div>
                <h6 class="fw-bold text-dark mb-1 mt-2">${r.vessel}</h6>
                <div class="small font-monospace text-primary mb-2">${r.manifest_number}</div>
                <div class="small text-muted mb-1">
                    Rute: <strong>${r.origin_flag || ''} ${r.origin_name} (${r.origin_code})</strong> &rarr; <strong>${r.destination_flag || ''} ${r.destination_name} (${r.destination_code})</strong>
                </div>
                <div class="small text-muted">
                    ETA Tiba: <strong>${r.arrival_eta}</strong>
                </div>
            </div>
        `;
        shipMarker.bindPopup(shipPopup);
    });

    // ========================================================
    // 4. PENCARIAN GEOCODING OPENCAGE DENGAN SARAN AUTOCOMPLETE & BENDERA
    // ========================================================
    let searchMarker = null;
    let searchDebounceTimer = null;

    // Database Master Lokasi Terpadu (Pelabuhan, Hub Logistik & Kota Utama Nusantara)
    const baseLocations = [
        { name: 'Ambon', region: 'Maluku', flag: '🇮🇩', lat: -3.6959, lng: 128.1788 },
        { name: 'Ampenan', region: 'Lombok, NTB', flag: '🇮🇩', lat: -8.5728, lng: 116.0833 },
        { name: 'Amurang', region: 'Minahasa Selatan, Sulut', flag: '🇮🇩', lat: 1.1897, lng: 124.5714 },
        { name: 'Tanjung Priok', region: 'Jakarta Utara, DKI Jakarta', flag: '🇮🇩', lat: -6.1033, lng: 106.8828 },
        { name: 'Tanjung Perak', region: 'Surabaya, Jawa Timur', flag: '🇮🇩', lat: -7.2025, lng: 112.7306 },
        { name: 'Batu Ampar', region: 'Batam, Kepri', flag: '🇮🇩', lat: 1.1575, lng: 103.9961 },
        { name: 'Soekarno Hatta (Makassar)', region: 'Makassar, Sulsel', flag: '🇮🇩', lat: -5.1167, lng: 119.4167 },
        { name: 'Tanjung Emas', region: 'Semarang, Jawa Tengah', flag: '🇮🇩', lat: -6.9532, lng: 110.4285 },
        { name: 'Belawan', region: 'Medan, Sumatera Utara', flag: '🇮🇩', lat: 3.7833, lng: 98.6833 },
        { name: 'Semayang', region: 'Balikpapan, Kaltim', flag: '🇮🇩', lat: -1.2783, lng: 116.8122 },
        { name: 'Trisakti', region: 'Banjarmasin, Kalsel', flag: '🇮🇩', lat: -3.3289, lng: 114.5681 },
        { name: 'Dwikora', region: 'Pontianak, Kalbar', flag: '🇮🇩', lat: -0.0263, lng: 109.3425 },
        { name: 'Palaran', region: 'Samarinda, Kaltim', flag: '🇮🇩', lat: -0.5786, lng: 117.1642 },
        { name: 'Boom Baru', region: 'Palembang, Sumsel', flag: '🇮🇩', lat: -2.9733, lng: 104.7761 },
        { name: 'Panjang', region: 'Bandar Lampung, Lampung', flag: '🇮🇩', lat: -5.4667, lng: 105.3167 },
        { name: 'Teluk Bayur', region: 'Padang, Sumbar', flag: '🇮🇩', lat: -0.9997, lng: 100.3700 },
        { name: 'Dumai', region: 'Riau', flag: '🇮🇩', lat: 1.6778, lng: 101.4467 },
        { name: 'Malahayati', region: 'Banda Aceh, Aceh', flag: '🇮🇩', lat: 5.5897, lng: 95.5186 },
        { name: 'Benoa', region: 'Denpasar, Bali', flag: '🇮🇩', lat: -8.7508, lng: 115.2150 },
        { name: 'Tenau', region: 'Kupang, NTT', flag: '🇮🇩', lat: -10.1833, lng: 123.5333 },
        { name: 'Lembar', region: 'Lombok Barat, NTB', flag: '🇮🇩', lat: -8.7294, lng: 116.0758 },
        { name: 'Bitung', region: 'Sulawesi Utara', flag: '🇮🇩', lat: 1.4404, lng: 125.1889 },
        { name: 'Manado', region: 'Sulawesi Utara', flag: '🇮🇩', lat: 1.4748, lng: 124.8428 },
        { name: 'Pantoloan', region: 'Palu, Sulawesi Tengah', flag: '🇮🇩', lat: -0.7100, lng: 119.8569 },
        { name: 'Kendari', region: 'Sulawesi Tenggara', flag: '🇮🇩', lat: -3.9878, lng: 122.6056 },
        { name: 'Gorontalo', region: 'Gorontalo', flag: '🇮🇩', lat: 0.5167, lng: 123.0667 },
        { name: 'Jayapura', region: 'Papua', flag: '🇮🇩', lat: -2.5333, lng: 140.7167 },
        { name: 'Sorong', region: 'Papua Barat Daya', flag: '🇮🇩', lat: -0.8794, lng: 131.2581 },
        { name: 'Merauke', region: 'Papua Selatan', flag: '🇮🇩', lat: -8.4933, lng: 140.3956 },
        { name: 'Manokwari', region: 'Papua Barat', flag: '🇮🇩', lat: -0.8615, lng: 134.0620 },
        { name: 'Biak', region: 'Papua', flag: '🇮🇩', lat: -1.1764, lng: 136.0825 },
        { name: 'Ternate', region: 'Maluku Utara', flag: '🇮🇩', lat: 0.7850, lng: 127.3883 },
        { name: 'Cilegon', region: 'Banten', flag: '🇮🇩', lat: -6.0167, lng: 105.9500 },
        { name: 'Cirebon', region: 'Jawa Barat', flag: '🇮🇩', lat: -6.7167, lng: 108.5667 },
        { name: 'Cilacap', region: 'Jawa Tengah', flag: '🇮🇩', lat: -7.7333, lng: 109.0167 },
        { name: 'Bontang', region: 'Kalimantan Timur', flag: '🇮🇩', lat: 0.1333, lng: 117.5000 },
        { name: 'Tarakan', region: 'Kalimantan Utara', flag: '🇮🇩', lat: 3.3000, lng: 117.6333 },
        { name: 'Yogyakarta', region: 'DI Yogyakarta', flag: '🇮🇩', lat: -7.7956, lng: 110.3695 },
        { name: 'Bandung', region: 'Jawa Barat', flag: '🇮🇩', lat: -6.9175, lng: 107.6191 },
        { name: 'Surakarta / Solo', region: 'Jawa Tengah', flag: '🇮🇩', lat: -7.5755, lng: 110.8243 },
        { name: 'Port of Singapore', region: 'Singapore', flag: '🇸🇬', lat: 1.2644, lng: 103.8400 },
        { name: 'Port Klang', region: 'Selangor, Malaysia', flag: '🇲🇾', lat: 2.9999, lng: 101.3928 }
    ];

    // Gabungkan dengan data port aktif database
    if (typeof portsData !== 'undefined' && Array.isArray(portsData)) {
        portsData.forEach(p => {
            const lat = parseFloat(p.latitude);
            const lng = parseFloat(p.longitude);
            if (!isNaN(lat) && !isNaN(lng)) {
                const exists = baseLocations.some(l => Math.abs(l.lat - lat) < 0.05 && Math.abs(l.lng - lng) < 0.05);
                if (!exists) {
                    baseLocations.push({
                        name: p.name,
                        region: p.city || 'Indonesia',
                        flag: p.country_code === 'SG' ? '🇸🇬' : (p.country_code === 'MY' ? '🇲🇾' : '🇮🇩'),
                        lat: lat,
                        lng: lng
                    });
                }
            }
        });
    }

    function renderMapSuggestions(items) {
        const container = document.getElementById('mapSearchSuggestions');
        if (!container) return;

        if (!items || items.length === 0) {
            container.innerHTML = `
                <div style="padding: 9px 12px; color: #94a3b8; font-size: 11px; text-align: center;">
                    Tidak ada saran lokasi langsung. Tekan Enter untuk cari via OpenCage.
                </div>
            `;
            container.style.display = 'block';
            return;
        }

        let html = '';
        items.slice(0, 6).forEach(item => {
            html += `
                <div class="map-suggestion-item" data-lat="${item.lat}" data-lng="${item.lng}" data-name="${item.name}" data-region="${item.region || ''}" data-flag="${item.flag || '🇮🇩'}" style="padding: 8px 12px; cursor: pointer; display: flex; align-items: center; border-bottom: 1px solid #f1f5f9; background: #ffffff; transition: background 0.15s ease;">
                    <span style="font-size: 16px; margin-right: 8px; line-height: 1;">${item.flag || '🇮🇩'}</span>
                    <span style="color: #cbd5e1; margin-right: 8px; font-weight: 300;">|</span>
                    <div style="flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <span style="color: #0f172a; font-weight: 600; font-size: 12px;">${item.name}</span>
                        ${item.region ? `<span style="color: #64748b; font-size: 11px; margin-left: 6px;">(${item.region})</span>` : ''}
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        container.style.display = 'block';

        container.querySelectorAll('.map-suggestion-item').forEach(el => {
            el.addEventListener('mouseenter', () => el.style.background = '#f0f9ff');
            el.addEventListener('mouseleave', () => el.style.background = '#ffffff');
            el.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                selectMapLocation({
                    lat: parseFloat(this.getAttribute('data-lat')),
                    lng: parseFloat(this.getAttribute('data-lng')),
                    name: this.getAttribute('data-name'),
                    region: this.getAttribute('data-region'),
                    flag: this.getAttribute('data-flag')
                });
            });
        });
    }

    function selectMapLocation(item) {
        const input = document.getElementById('mapSearchInput');
        const container = document.getElementById('mapSearchSuggestions');
        if (input) {
            input.value = item.name + (item.region ? ', ' + item.region : '');
        }
        if (container) {
            container.style.display = 'none';
        }

        map.setView([item.lat, item.lng], 11, { animate: true });

        if (searchMarker) {
            map.removeLayer(searchMarker);
        }

        const markerIcon = L.divIcon({
            className: 'search-result-marker',
            html: `<div style="background:#0284c7; color:#fff; width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 8px rgba(0,0,0,0.3); border:2px solid #fff; font-size:14px;">${item.flag || '📍'}</div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        searchMarker = L.marker([item.lat, item.lng], { icon: markerIcon })
            .addTo(map)
            .bindPopup(`
                <div style="min-width: 160px; font-family: inherit;">
                    <div style="font-size: 13px; font-weight: bold; color: #0284c7; display: flex; align-items: center; gap: 6px;">
                        <span>${item.flag || '🇮🇩'}</span>
                        <span>${item.name}</span>
                    </div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 3px;">${item.region || 'Wilayah Logistik'}</div>
                    <div style="font-size: 10px; color: #94a3b8; font-family: monospace; margin-top: 5px;">
                        Koordinat: ${item.lat.toFixed(4)}, ${item.lng.toFixed(4)}
                    </div>
                </div>
            `)
            .openPopup();
    }

    function handleMapSearchInput(query) {
        const q = query.trim().toLowerCase();
        const container = document.getElementById('mapSearchSuggestions');
        if (!container) return;

        if (!q) {
            container.style.display = 'none';
            return;
        }

        // Prioritaskan yang namanya berawalan huruf pencarian (e.g. "am" -> "Ambon")
        const startsWith = [];
        const contains = [];

        baseLocations.forEach(item => {
            const nameLower = item.name.toLowerCase();
            const regionLower = (item.region || '').toLowerCase();
            if (nameLower.startsWith(q)) {
                startsWith.push(item);
            } else if (nameLower.includes(q) || regionLower.includes(q)) {
                contains.push(item);
            }
        });

        const localMatches = [...startsWith, ...contains];
        renderMapSuggestions(localMatches);

        // Fetch dinamis via OpenCage Geocoding API Global (Seluruh Dunia) dengan Debounce 300ms
        clearTimeout(searchDebounceTimer);
        if (q.length >= 2) {
            searchDebounceTimer = setTimeout(() => {
                fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(query)}&key=${openCageKey}&limit=5&no_annotations=0`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            const remoteItems = data.results.map(r => {
                                const city = r.components.city || r.components.town || r.components.municipality || r.components.county || r.components.state || r.formatted.split(',')[0];
                                const country = r.components.country || '';
                                const state = r.components.state && r.components.state !== city ? r.components.state : '';
                                const regionText = [state, country].filter(Boolean).join(', ');
                                
                                return {
                                    name: city,
                                    region: regionText,
                                    flag: r.annotations?.flag || (r.components.country_code ? r.components.country_code.toUpperCase().replace(/./g, char => String.fromCodePoint(127397 + char.charCodeAt())) : '🌐'),
                                    lat: r.geometry.lat,
                                    lng: r.geometry.lng
                                };
                            });

                            // Jika hasil remote berawalan sama dengan query, beri prioritas atas
                            const exactOrStartsRemote = remoteItems.filter(ri => ri.name.toLowerCase().startsWith(q));
                            const otherRemote = remoteItems.filter(ri => !ri.name.toLowerCase().startsWith(q));

                            const combined = [...exactOrStartsRemote, ...localMatches, ...otherRemote];
                            
                            // Hapus duplikasi berdasarkan kedekatan koordinat / nama
                            const uniqueItems = [];
                            const seen = new Set();
                            combined.forEach(item => {
                                const key = (item.name + '_' + item.region).toLowerCase();
                                if (!seen.has(key)) {
                                    seen.add(key);
                                    uniqueItems.push(item);
                                }
                            });

                            renderMapSuggestions(uniqueItems);
                        }
                    })
                    .catch(() => {});
            }, 300);
        }
    }

    function executeMapSearch() {
        const input = document.getElementById('mapSearchInput');
        const btn = document.getElementById('mapSearchBtn');
        const container = document.getElementById('mapSearchSuggestions');
        if (!input) return;
        const query = input.value.trim();
        if (!query) return;

        if (container) container.style.display = 'none';

        // Cek apakah ada yang cocok persis di lokal
        const exactLocal = baseLocations.find(l => l.name.toLowerCase() === query.toLowerCase());
        if (exactLocal) {
            selectMapLocation(exactLocal);
            return;
        }

        btn.innerHTML = `<span class="spinner-border spinner-border-sm text-white" style="width: 10px; height: 10px;"></span>`;

        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(query)}&key=${openCageKey}&limit=1&no_annotations=0`)
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>`;
                if (data.results && data.results.length > 0) {
                    const result = data.results[0];
                    const city = result.components.city || result.components.town || result.components.municipality || result.components.county || result.formatted.split(',')[0];
                    const country = result.components.country || '';
                    const state = result.components.state && result.components.state !== city ? result.components.state : '';
                    const flag = result.annotations?.flag || (result.components.country_code ? result.components.country_code.toUpperCase().replace(/./g, char => String.fromCodePoint(127397 + char.charCodeAt())) : '🌐');

                    selectMapLocation({
                        lat: result.geometry.lat,
                        lng: result.geometry.lng,
                        name: city,
                        region: [state, country].filter(Boolean).join(', '),
                        flag: flag
                    });
                } else {
                    alert('Lokasi tidak ditemukan. Coba nama kota atau negara lain.');
                }
            })
            .catch(() => {
                btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>`;
                alert('Gagal menghubungi layanan OpenCage Geocoding.');
            });
    }

    // Event Listener Real-time Input & Klik
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'mapSearchInput') {
            handleMapSearchInput(e.target.value);
        }
    });

    document.addEventListener('focusin', function(e) {
        if (e.target && e.target.id === 'mapSearchInput' && e.target.value.trim().length > 0) {
            handleMapSearchInput(e.target.value);
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target && (e.target.id === 'mapSearchBtn' || e.target.closest('#mapSearchBtn'))) {
            executeMapSearch();
        }
        // Sembunyikan saran jika klik di luar search box
        const searchBox = document.querySelector('.map-search-box');
        const container = document.getElementById('mapSearchSuggestions');
        if (container && searchBox && !searchBox.contains(e.target)) {
            container.style.display = 'none';
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.target && e.target.id === 'mapSearchInput' && e.key === 'Enter') {
            e.preventDefault();
            // Jika ada saran pertama, pilih langsung saran pertama
            const container = document.getElementById('mapSearchSuggestions');
            const firstSuggestion = container ? container.querySelector('.map-suggestion-item') : null;
            if (firstSuggestion && container.style.display !== 'none') {
                firstSuggestion.click();
            } else {
                executeMapSearch();
            }
        }
    });

    // Helper Fungsi Zoom Cepat Regional
    window.zoomToRegion = function (region) {
        if (region === 'jawa') {
            map.setView([-6.8, 110.0], 7);
        } else if (region === 'sumatera') {
            map.setView([0.5, 102.0], 6);
        } else if (region === 'sulawesi') {
            map.setView([-2.5, 121.0], 6);
        } else {
            map.setView(indonesiaCenter, 5);
        }
    };

    // ========================================================
    // 5. CHART.JS: TREN VOLUME MUATAN KARGO (Line Chart)
    // ========================================================
    const ctxVolume = document.getElementById("cargoVolumeChart");
    if (ctxVolume) {
        const modalityDataSets = {
            all: {
                label: "Semua Moda (TEUs & Ton)",
                data: [1240, 1420, 1680, 1590, 1840, 2150],
                borderColor: "#0284c7",
                backgroundColor: "rgba(2, 132, 199, 0.08)",
                pointBackgroundColor: "#0284c7"
            },
            sea: {
                label: "Kapal Tol Laut (TEUs)",
                data: [750, 880, 1050, 990, 1180, 1390],
                borderColor: "#0ea5e9",
                backgroundColor: "rgba(14, 165, 233, 0.08)",
                pointBackgroundColor: "#0ea5e9"
            },
            truck: {
                label: "Truk Trans Antarmoda (Ritase)",
                data: [340, 390, 450, 420, 480, 560],
                borderColor: "#10b981",
                backgroundColor: "rgba(16, 185, 129, 0.08)",
                pointBackgroundColor: "#10b981"
            },
            air: {
                label: "Pesawat Kargo Udara (Ton)",
                data: [150, 150, 180, 180, 180, 200],
                borderColor: "#f59e0b",
                backgroundColor: "rgba(245, 158, 11, 0.08)",
                pointBackgroundColor: "#f59e0b"
            }
        };

        const volumeChart = new Chart(ctxVolume, {
            type: 'line',
            data: {
                labels: ["Jun", "Jul", "Ags", "Sep", "Okt", "Nov"],
                datasets: [{
                    label: modalityDataSets.all.label,
                    data: modalityDataSets.all.data,
                    backgroundColor: modalityDataSets.all.backgroundColor,
                    borderColor: modalityDataSets.all.borderColor,
                    borderWidth: 2,
                    pointBackgroundColor: modalityDataSets.all.pointBackgroundColor,
                    pointRadius: 3,
                    lineTension: 0.35,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        gridLines: { display: false }
                    }],
                    yAxes: [{
                        ticks: { maxTicksLimit: 5 }
                    }]
                },
                legend: { display: false },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return (data.datasets[tooltipItem.datasetIndex].label || '') + ': ' + tooltipItem.yLabel.toLocaleString();
                        }
                    }
                }
            }
        });

        // Event listener filter moda: Semua / Kapal / Truk / Pesawat
        const filterContainer = document.getElementById('cargoModalityFilter');
        if (filterContainer) {
            filterContainer.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', function() {
                    filterContainer.querySelectorAll('button').forEach(b => {
                        b.classList.remove('btn-primary', 'active');
                        b.classList.add('btn-outline-primary');
                    });
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary', 'active');

                    const mode = this.getAttribute('data-mode') || 'all';
                    const activeSet = modalityDataSets[mode] || modalityDataSets.all;

                    volumeChart.data.datasets[0].label = activeSet.label;
                    volumeChart.data.datasets[0].data = activeSet.data;
                    volumeChart.data.datasets[0].borderColor = activeSet.borderColor;
                    volumeChart.data.datasets[0].backgroundColor = activeSet.backgroundColor;
                    volumeChart.data.datasets[0].pointBackgroundColor = activeSet.pointBackgroundColor;
                    volumeChart.update();
                });
            });
        }
    }

    // ========================================================
    // 6. CHART.JS: DISTRIBUSI MODA PENGIRIMAN (Donut Chart)
    // ========================================================
    const ctxModality = document.getElementById("modalityChart");
    if (ctxModality) {
        new Chart(ctxModality, {
            type: 'doughnut',
            data: {
                labels: ["Kapal Tol Laut", "Truk Trans", "Air Freight"],
                datasets: [{
                    data: [{{ $seaCount }}, {{ $truckCount }}, {{ $airCount }}],
                    backgroundColor: ['#0284c7', '#10b981', '#f59e0b'],
                    borderWidth: 2
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: { display: false }
            }
        });
    }

    // ========================================================
    // 8. LOGIKA MULTI-CURRENCY GLOBAL (IDR / USD SPOT RATE)
    // ========================================================
    const SPOT_USD_RATE = 16250; // Spot JISDOR: 1 USD = Rp 16.250

    function formatCurrencyVal(amountIdr, currency) {
        if (currency === 'USD') {
            const usd = amountIdr / SPOT_USD_RATE;
            return '$ ' + usd.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        } else {
            return 'Rp ' + Number(amountIdr).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
    }

    function setGlobalCurrency(currency) {
        document.querySelectorAll('.money-amount').forEach(el => {
            const idr = parseFloat(el.getAttribute('data-amount-idr')) || 0;
            el.textContent = formatCurrencyVal(idr, currency);
        });

        const switcher = document.getElementById('globalCurrencySwitcher');
        if (switcher) {
            switcher.querySelectorAll('button').forEach(btn => {
                if (btn.getAttribute('data-currency') === currency) {
                    btn.classList.add('btn-primary', 'active');
                    btn.classList.remove('btn-outline-primary');
                } else {
                    btn.classList.remove('btn-primary', 'active');
                    btn.classList.add('btn-outline-primary');
                }
            });
        }

        try {
            localStorage.setItem('soracargo_global_currency', currency);
        } catch(e) {}
    }

    // Event listener klik tombol switcher mata uang
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('#globalCurrencySwitcher button');
        if (btn) {
            const curr = btn.getAttribute('data-currency');
            if (curr) {
                setGlobalCurrency(curr);
            }
        }
    });

    // Inisialisasi mata uang tersimpan
    try {
        const savedCurr = localStorage.getItem('soracargo_global_currency') || 'IDR';
        if (savedCurr === 'USD') {
            setGlobalCurrency('USD');
        }
    } catch(e) {}

    // ========================================================
    // 7. WEATHER HOLD MODAL & DISPOSISI PENAHANAN RUTE GLOBAL
    // ========================================================
    const weatherHoldModalEl = document.getElementById('weatherHoldModal');
    let weatherHoldModalInstance = null;
    if (weatherHoldModalEl && typeof bootstrap !== 'undefined') {
        weatherHoldModalInstance = new bootstrap.Modal(weatherHoldModalEl);
    }

    // Buka Modal Weather Hold dengan data rute
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-open-weather-hold');
        if (btn) {
            const routeId = btn.getAttribute('data-route-id') || '';
            const routeName = btn.getAttribute('data-route-name') || '';
            const corridor = btn.getAttribute('data-corridor') || '';
            const wave = btn.getAttribute('data-wave') || '';
            const wind = btn.getAttribute('data-wind') || '';

            const whRouteId = document.getElementById('whRouteId');
            const whRouteName = document.getElementById('whRouteName');
            const whCorridor = document.getElementById('whCorridor');
            const whWaveMetric = document.getElementById('whWaveMetric');
            const whWindMetric = document.getElementById('whWindMetric');

            if (whRouteId) whRouteId.value = routeId;
            if (whRouteName) whRouteName.textContent = routeName;
            if (whCorridor) whCorridor.textContent = corridor;
            if (whWaveMetric) whWaveMetric.textContent = 'Gelombang: ' + wave;
            if (whWindMetric) whWindMetric.textContent = 'Angin: ' + wind;

            if (weatherHoldModalInstance) {
                weatherHoldModalInstance.show();
            }
        }
    });

    // Konfirmasi Eksekusi Tahan Rute
    const btnConfirmWeatherHold = document.getElementById('btnConfirmWeatherHold');
    if (btnConfirmWeatherHold) {
        btnConfirmWeatherHold.addEventListener('click', async function() {
            const routeId = document.getElementById('whRouteId').value;
            const duration = document.getElementById('whDuration').value;
            const reason = document.getElementById('whReason').value;

            btnConfirmWeatherHold.disabled = true;
            btnConfirmWeatherHold.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menerapkan Weather Hold...`;

            try {
                const response = await fetch("{{ route('admin.routes.weather_hold') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        route_id: routeId,
                        duration_hours: parseInt(duration),
                        reason: reason,
                        action: 'hold'
                    })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    if (weatherHoldModalInstance) weatherHoldModalInstance.hide();
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal menerapkan Weather Hold: ' + (data.message || 'Terjadi kesalahan sistem.'));
                }
            } catch(err) {
                alert('Kesalahan jaringan saat memproses permintaan.');
            } finally {
                btnConfirmWeatherHold.disabled = false;
                btnConfirmWeatherHold.innerHTML = `<svg class="lucide-icon inline-block align-middle me-1" width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> Konfirmasi Tahan Rute`;
            }
        });
    }

    // Cabut Status Weather Hold
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.btn-lift-weather-hold');
        if (btn) {
            const routeId = btn.getAttribute('data-route-id');
            if (!confirm('Apakah Anda yakin ingin mencabut status Weather Hold dan mengizinkan pelayaran kembali pada rute ini?')) {
                return;
            }

            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status"></span> Memproses...`;

            try {
                const response = await fetch("{{ route('admin.routes.weather_hold') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        route_id: routeId,
                        action: 'lift'
                    })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Gagal mencabut hold: ' + (data.message || 'Terjadi kesalahan.'));
                    btn.disabled = false;
                }
            } catch(err) {
                alert('Kesalahan koneksi.');
                btn.disabled = false;
            }
        }
    });

    // ========================================================
    // 8. SYSTEM HEALTH PING REFRESH WIDGET
    // ========================================================
    const btnRefreshHealth = document.getElementById('btnRefreshHealth');
    const iconRefreshHealth = document.getElementById('iconRefreshHealth');
    if (btnRefreshHealth && iconRefreshHealth) {
        btnRefreshHealth.addEventListener('click', function() {
            iconRefreshHealth.classList.add('fa-spin', 'rotate-center');
            btnRefreshHealth.disabled = true;
            btnRefreshHealth.innerHTML = `<span class="spinner-border spinner-border-sm me-1" style="width:0.65rem;height:0.65rem;"></span> Menguji...`;

            setTimeout(function() {
                btnRefreshHealth.disabled = false;
                btnRefreshHealth.innerHTML = `<svg class="lucide-icon inline-block align-middle me-1" width="0.65rem" height="0.65rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg> Terverifikasi`;
                setTimeout(() => {
                    btnRefreshHealth.innerHTML = `<svg class="lucide-icon inline-block align-middle me-1" width="0.65rem" height="0.65rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg> Ping Ulang`;
                }, 2000);
            }, 600);
        });
    }
});
</script>
@endpush
