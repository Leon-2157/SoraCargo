@extends('layouts.app')

@section('title', 'Pusat Laporan & Pajak')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Pusat Laporan &amp; Rekap Pajak</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="file-spreadsheet" size="0.85rem" class="me-1" /> Rekapitulasi Fiskal &amp; Akuntansi
            </span>
        </div>
        <p class="text-muted small mb-0">Dasbor konsolidasi pembukuan finansial: Laba Rugi Rute Pelayaran, Kepatuhan Pajak (PPN 11% &amp; PPh 23 Jasa Ekspedisi), dan Arus Kas Escrow.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <x-icon name="download" class="me-1" /> Unduh Laporan (CSV / Excel)
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">Pilih Format Laporan:</h6></li>
                <li>
                    <a class="dropdown-item small" href="{{ route('admin.finance.reports.export', ['type' => 'route_pnl']) }}">
                        <x-icon name="line-chart" class="me-2 text-primary" size="0.85rem" /> Ekspor Laba Rugi Rute (P&amp;L)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item small" href="{{ route('admin.finance.reports.export', ['type' => 'tax_summary']) }}">
                        <x-icon name="landmark" class="me-2 text-warning" size="0.85rem" /> Ekspor Rekap Pajak (PPN &amp; PPh 23)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item small" href="{{ route('admin.finance.reports.export', ['type' => 'escrow_flow']) }}">
                        <x-icon name="vault" class="me-2 text-success" size="0.85rem" /> Ekspor Mutasi Arus Kas Escrow
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- 4 Small Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Gross Merchandise Value (GMV) -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Gross Value Kargo (GMV)</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalGmv, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">Total nilai perputaran barang</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="boxes" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Laba Bersih Platform -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Laba Bersih SoraCargo</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalNetProfit, 0, ',', '.') }}</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Net Platform Fee: 12.5%</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="coins" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Pajak Terutang -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Estimasi Pajak (PPN+PPh)</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalTaxObligation, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">PPN 11% &amp; PPh 23 (Withholding)</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="landmark" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Saldo Escrow Mengendap -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Arus Masuk Escrow Konsumen</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($escrowInflow, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">Pencairan: Rp {{ number_format($escrowOutflow, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="vault" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main 3-Pillar Tabbed Report Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold d-flex align-items-center">
            <x-icon name="file-spreadsheet" class="me-2" />Dasbor Konsolidasi Pembukuan &amp; Pajak
        </h6>
        <span class="badge bg-light text-secondary border">Sesuai Regulasi PMK 71/2022 &amp; UU HPP</span>
    </div>

    <div class="card-body">
        <!-- 3 Pillars Nav Tabs -->
        <ul class="nav nav-pills mb-4 border-bottom pb-2" id="pillarTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ $activePillar === 'route_pnl' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.finance.reports', ['pillar' => 'route_pnl']) }}">
                    <x-icon name="line-chart" class="me-1" /> Pilar 1: Laba Rugi per Rute (Route P&amp;L)
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $activePillar === 'tax_summary' ? 'active' : '' }} py-1 px-3 small fw-bold text-warning" href="{{ route('admin.finance.reports', ['pillar' => 'tax_summary']) }}">
                    <x-icon name="landmark" class="me-1" /> Pilar 2: Rekapitulasi Pajak (PPN &amp; PPh 23)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activePillar === 'escrow_flow' ? 'active' : '' }} py-1 px-3 small fw-bold text-success" href="{{ route('admin.finance.reports', ['pillar' => 'escrow_flow']) }}">
                    <x-icon name="vault" class="me-1" /> Pilar 3: Arus Kas &amp; Mutasi Escrow
                </a>
            </li>
        </ul>

        <!-- PILAR 1 CONTENT: Route P&L -->
        @if($activePillar === 'route_pnl')
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0">Profitabilitas per Koridor Rute Pelayaran &amp; Angkutan</h6>
                    <span class="text-muted small">Perbandingan volume transaksi kargo, pembayaran hak operator kapal, retribusi dermaga, dan laba bersih platform.</span>
                </div>
                <a href="{{ route('admin.finance.reports.export', ['type' => 'route_pnl']) }}" class="btn btn-sm btn-outline-primary">
                    <x-icon name="download" class="me-1" /> Unduh CSV
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle my-0">
                    <thead class="table-light">
                        <tr>
                            <th>Koridor Rute (Asal &rarr; Tujuan)</th>
                            <th>Moda</th>
                            <th>Volume Booking</th>
                            <th>Total GMV Kargo</th>
                            <th>Hak Operator Armada</th>
                            <th>Retribusi Dermaga &amp; PNBP</th>
                            <th>Laba Bersih SoraCargo</th>
                            <th>Margin (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($routePnl as $pnl)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        <x-icon name="map-pin" size="0.85rem" class="text-primary me-1" />
                                        {{ $pnl->origin_code }} &rarr; {{ $pnl->destination_code }}
                                    </div>
                                    <div class="text-muted text-xs">{{ $pnl->origin }} ke {{ $pnl->destination }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border text-xs">
                                        <x-icon name="{{ $pnl->transport_mode === 'SEA' ? 'ship' : 'truck' }}" size="0.75rem" class="me-1" />
                                        {{ $pnl->transport_mode }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $pnl->total_bookings }}</span>
                                    <span class="text-muted text-xs">Pesanan</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">Rp {{ number_format($pnl->gmv, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <div class="text-dark">Rp {{ number_format($pnl->operator_share, 0, ',', '.') }}</div>
                                    <span class="text-muted text-xs">Beban armada</span>
                                </td>
                                <td>
                                    <div class="text-dark">Rp {{ number_format($pnl->port_dues, 0, ',', '.') }}</div>
                                    <span class="text-muted text-xs">CY &amp; Syahbandar</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">Rp {{ number_format($pnl->net_profit, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $pnl->margin_pct >= 10 ? 'bg-success' : 'bg-warning text-dark' }} text-xs">
                                        {{ $pnl->margin_pct }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada rute aktif tercatat dalam sistem.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="3" class="text-uppercase text-secondary">Total Konsolidasi Rute</td>
                            <td class="text-dark">Rp {{ number_format($totalGmv, 0, ',', '.') }}</td>
                            <td class="text-dark">Rp {{ number_format($totalOperatorPayout, 0, ',', '.') }}</td>
                            <td class="text-dark">Rp {{ number_format($totalPortDues, 0, ',', '.') }}</td>
                            <td class="text-success">Rp {{ number_format($totalNetProfit, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $avgMargin = ($totalGmv > 0) ? round(($totalNetProfit / $totalGmv) * 100, 1) : 0;
                                @endphp
                                <span class="badge bg-primary text-xs">{{ $avgMargin }}%</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        <!-- PILAR 2 CONTENT: Tax Summary -->
        @elseif($activePillar === 'tax_summary')
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0">Rekapitulasi Kepatuhan Pajak Logistik &amp; Freight Forwarding</h6>
                    <span class="text-muted small">Rangkuman pemotongan PPh Pasal 23 atas sewa armada dan PPN 11% atas imbalan jasa perantara pengiriman kargo.</span>
                </div>
                <a href="{{ route('admin.finance.reports.export', ['type' => 'tax_summary']) }}" class="btn btn-sm btn-outline-warning">
                    <x-icon name="download" class="me-1" /> Unduh Format DJP (CSV)
                </a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card bg-light border p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-primary mb-0 d-flex align-items-center">
                                <x-icon name="file-text" size="0.9rem" class="me-2" /> PPN Jasa Pengurusan Transportasi (11%)
                            </h6>
                            <span class="badge bg-primary text-white text-xs">PMK 71/2022</span>
                        </div>
                        <div class="small text-muted mb-2">Dasar Pengenaan Pajak (DPP Margin SoraCargo):</div>
                        <div class="h5 fw-bold text-dark">Rp {{ number_format($taxBaseDpp, 0, ',', '.') }}</div>
                        <div class="d-flex justify-content-between border-top pt-2 mt-2 small">
                            <span class="text-muted">PPN Keluaran Terutang (11%):</span>
                            <strong class="text-primary">Rp {{ number_format($ppn11Pct, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light border p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-danger mb-0 d-flex align-items-center">
                                <x-icon name="shield" size="0.9rem" class="me-2" /> PPh Pasal 23 Sewa Armada &amp; Jasa (2%)
                            </h6>
                            <span class="badge bg-danger text-white text-xs">Withholding Tax</span>
                        </div>
                        <div class="small text-muted mb-2">Total Nilai Sewa/Imbalan ke Operator Pelayaran:</div>
                        <div class="h5 fw-bold text-dark">Rp {{ number_format($totalOperatorPayout, 0, ',', '.') }}</div>
                        <div class="d-flex justify-content-between border-top pt-2 mt-2 small">
                            <span class="text-muted">PPh 23 Dipotong (2% Bukti Potong):</span>
                            <strong class="text-danger">Rp {{ number_format($pph23Withholding, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle my-0">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis Pajak &amp; Komponen</th>
                            <th>Regulasi Acuan</th>
                            <th>Dasar Pengenaan Pajak (DPP)</th>
                            <th>Tarif Efektif</th>
                            <th>Pajak Terutang (IDR)</th>
                            <th>Status Pelaporan SPT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">PPN Jasa Ekspedisi (Keluaran)</div>
                                <div class="text-muted text-xs">Faktur Pajak atas Platform Fee</div>
                            </td>
                            <td><span class="badge bg-light text-dark border">UU HPP / PMK 71</span></td>
                            <td>Rp {{ number_format($taxBaseDpp, 0, ',', '.') }}</td>
                            <td><span class="badge bg-primary text-white">11%</span></td>
                            <td class="fw-bold text-primary">Rp {{ number_format($ppn11Pct, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success-subtle text-success border border-success-subtle"><x-icon name="check-circle" size="0.7rem" /> Siap Ekspor e-Faktur</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">PPh Pasal 23 Sewa Kapal &amp; Truk</div>
                                <div class="text-muted text-xs">Bukti Potong Bupot Unifikasi Operator</div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Pasal 23 UU PPh</span></td>
                            <td>Rp {{ number_format($totalOperatorPayout, 0, ',', '.') }}</td>
                            <td><span class="badge bg-danger text-white">2%</span></td>
                            <td class="fw-bold text-danger">Rp {{ number_format($pph23Withholding, 0, ',', '.') }}</td>
                            <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle"><x-icon name="clock" size="0.7rem" /> Menunggu Bupot DJP</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">PNBP &amp; Retribusi Kepelabuhanan</div>
                                <div class="text-muted text-xs">Uang Dermaga &amp; Jasa CY Pelindo</div>
                            </td>
                            <td><span class="badge bg-light text-dark border">Tarif BUP Pelindo</span></td>
                            <td>Rp {{ number_format($totalPortDues, 0, ',', '.') }}</td>
                            <td><span class="badge bg-secondary text-white">At Cost</span></td>
                            <td class="fw-bold text-dark">Rp {{ number_format($totalPortDues, 0, ',', '.') }}</td>
                            <td><span class="badge bg-light text-secondary border">Non-SPT (Nota Pelabuhan)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <!-- PILAR 3 CONTENT: Escrow Flow -->
        @else
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-0">Arus Kas Rekening Bersama (Escrow Movement)</h6>
                    <span class="text-muted small">Aliran dana penampungan konsumen dari saat pembayaran hingga penyelesaian termin (M1 Gate-In, M2 Sailing, M3 Delivered).</span>
                </div>
                <a href="{{ route('admin.finance.reports.export', ['type' => 'escrow_flow']) }}" class="btn btn-sm btn-outline-success">
                    <x-icon name="download" class="me-1" /> Unduh Mutasi Escrow (CSV)
                </a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card bg-light border p-3">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Dana Masuk (Inflow)</div>
                        <div class="h5 fw-bold text-dark">Rp {{ number_format($escrowInflow, 0, ',', '.') }}</div>
                        <div class="text-muted text-xs">100% Pembayaran aman konsumen</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border p-3">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Total Dana Dicairkan (Outflow)</div>
                        <div class="h5 fw-bold text-success">Rp {{ number_format($escrowOutflow, 0, ',', '.') }}</div>
                        <div class="text-muted text-xs">Pencairan termin M1/M2/M3 ke operator</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border p-3">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Saldo Floating Aktif</div>
                        <div class="h5 fw-bold text-info">Rp {{ number_format($escrowFloatingBalance, 0, ',', '.') }}</div>
                        <div class="text-muted text-xs">Dana mengendap menunggu termin</div>
                    </div>
                </div>
            </div>

            <div class="alert alert-light border small text-muted d-flex align-items-center">
                <x-icon name="shield-check" class="text-success me-2 flex-shrink-0" />
                <div>
                    Seluruh mutasi dana rekening bersama terintegrasi dengan trigger status kargo otomatis serta dilengkapi hak veto pembekuan Superadmin pada menu 
                    <a href="{{ route('admin.finance.escrow') }}" class="fw-bold text-primary">Rekening Bersama</a>.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

