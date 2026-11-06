@extends('layouts.app')

@section('title', 'Catatan Aktivitas (Immutable Audit Trail)')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Catatan Aktivitas (Immutable Audit Trail)</h3>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold px-2 py-1">
                <x-icon name="shield" size="0.85rem" class="me-1" /> Append-Only Security Log
            </span>
        </div>
        <p class="text-muted small mb-0">Rekaman permanen tak terhapuskan atas seluruh intervensi Superadmin, rilis saldo escrow, persetujuan kredit B2B, dan keamanan sistem.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <span class="badge bg-light text-secondary border d-flex align-items-center px-3 py-2">
            <x-icon name="lock" class="text-success me-2" /> PostgreSQL Read-Only Tamper-Proof
        </span>
    </div>
</div>

<!-- 4 Small Stat Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Logs -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Mutasi Tercatat</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalLogs }} Catatan</div>
                        <span class="text-muted text-xs">Rekaman log permanen di PostgreSQL</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="shield" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Financial Mutations -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Tindakan Finansial &amp; Escrow</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $financialMutations }} Aksi</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Pencairan, freeze &amp; pelunasan</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="vault" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Operational Cargo Mutations -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Operasional Kargo &amp; Rute</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $operationalMutations }} Aksi</div>
                        <span class="text-info text-xs fw-semibold"><x-icon name="truck" size="0.75rem" /> Manifes, kontainer &amp; cuaca</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="truck" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Unique Admin Users -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Staf Pelaksana Aktif</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $uniqueAdminsCount }} Administrator</div>
                        <span class="text-muted text-xs">Identitas penanggung jawab tervalidasi</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="user-cog" class="text-gray-300" size="2rem" />
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
            <x-icon name="shield" class="me-2" />Log Forensik &amp; Riwayat Mutasi Data
        </h6>
        <span class="badge bg-light text-secondary border">Waktu Sinkronisasi: {{ now()->format('d M Y, H:i T') }}</span>
    </div>

    <div class="card-body">
        <!-- Search & Filter Controls -->
        <form method="GET" action="{{ route('admin.audit') }}" class="row mb-3 g-2">
            <div class="col-md-3">
                <select name="action" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Tipe Aksi --</option>
                    @foreach($actionTypes as $at)
                        <option value="{{ $at }}" {{ $action === $at ? 'selected' : '' }}>{{ $at }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="table" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Tabel Target --</option>
                    @foreach($targetTables as $tt)
                        <option value="{{ $tt }}" {{ $table === $tt ? 'selected' : '' }}>{{ $tt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari keyword aksi, record ID, IP address, atau admin..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                @if($action || $table || $search)
                    <a href="{{ route('admin.audit') }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- Audit Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="auditTable">
                <thead class="table-light">
                    <tr>
                        <th>ID &amp; Waktu (WIB)</th>
                        <th>Administrator Pelaksana</th>
                        <th>Tipe Aksi</th>
                        <th>Tabel Target &amp; Record ID</th>
                        <th>Alamat IP &amp; Client</th>
                        <th class="text-center">Inspeksi Forensik</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            $actionName = $log->action_type;
                            $badgeClass = 'bg-secondary';
                            if (str_contains($actionName, 'RELEASE') || str_contains($actionName, 'VERIFY') || str_contains($actionName, 'CREATE')) {
                                $badgeClass = 'bg-success';
                            } elseif (str_contains($actionName, 'FREEZE') || str_contains($actionName, 'LOCK') || str_contains($actionName, 'REJECT') || str_contains($actionName, 'HOLD')) {
                                $badgeClass = 'bg-danger';
                            } elseif (str_contains($actionName, 'UPDATE') || str_contains($actionName, 'DISPATCH')) {
                                $badgeClass = 'bg-primary';
                            }
                        @endphp
                        <tr>
                            <!-- 1. ID & Waktu -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace text-xs">#{{ $log->id }}</span>
                                <div class="fw-semibold text-dark text-xs mt-1">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-muted text-xs font-monospace">{{ $log->created_at->format('H:i:s') }} WIB</div>
                            </td>

                            <!-- 2. Administrator Pelaksana -->
                            <td>
                                <div class="fw-bold text-dark d-flex align-items-center">
                                    <x-icon name="user" size="0.8rem" class="text-primary me-1" />
                                    {{ $log->adminUser?->name ?? 'System Automated Hook' }}
                                </div>
                                <div class="text-muted text-xs">{{ $log->adminUser?->email ?? 'system@soracargo.internal' }}</div>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-xs mt-1">
                                    {{ $log->adminUser?->admin_role ?? 'SYSTEM' }}
                                </span>
                            </td>

                            <!-- 3. Tipe Aksi -->
                            <td>
                                <span class="badge {{ $badgeClass }} text-white font-monospace text-xs">
                                    {{ $log->action_type }}
                                </span>
                            </td>

                            <!-- 4. Tabel Target & Record ID -->
                            <td>
                                <div class="fw-bold text-dark font-monospace text-xs">
                                    {{ $log->target_schema }}.{{ $log->target_table }}
                                </div>
                                <div class="text-muted text-xs font-monospace text-truncate" style="max-width: 220px;" title="{{ $log->record_id }}">
                                    ID: {{ $log->record_id }}
                                </div>
                            </td>

                            <!-- 5. Alamat IP & Client -->
                            <td>
                                <div class="font-monospace text-xs text-dark d-flex align-items-center">
                                    <x-icon name="map-pin" size="0.75rem" class="text-secondary me-1" />
                                    {{ $log->ip_address }}
                                </div>
                                <div class="text-muted text-xs text-truncate" style="max-width: 180px;" title="{{ $log->user_agent }}">
                                    {{ Str::limit($log->user_agent, 28) }}
                                </div>
                            </td>

                            <!-- 6. Inspeksi Forensik -->
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-dark" type="button" onclick="inspectPayload('{{ $log->id }}')">
                                    <x-icon name="file-text" class="me-1" size="0.8rem" /> Payload
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <x-icon name="shield" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada catatan audit yang cocok dengan filter yang dipilih.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} catatan log
                </div>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL: Forensik Payload JSON Inspector -->
<div class="modal fade" id="payloadModal" tabindex="-1" aria-labelledby="payloadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="payloadModalLabel">
                    <x-icon name="shield" class="me-2" /> Inspeksi Payload Forensik
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 mb-3 small">
                    <div class="col-md-6">
                        <strong>Tipe Aksi:</strong> <span id="modalAction" class="badge bg-primary font-monospace ms-1">-</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Target:</strong> <span id="modalTarget" class="font-monospace text-dark ms-1">-</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Pelaksana:</strong> <span id="modalAdmin" class="text-dark ms-1">-</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Waktu &amp; IP:</strong> <span id="modalTimeIp" class="text-muted font-monospace ms-1">-</span>
                    </div>
                </div>

                <!-- Tabs: Before vs After State -->
                <ul class="nav nav-tabs mb-2" id="payloadTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active small fw-bold" id="after-tab" data-bs-toggle="tab" data-bs-target="#after-pane" type="button" role="tab">
                            State Baru (After State)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link small fw-bold text-muted" id="before-tab" data-bs-toggle="tab" data-bs-target="#before-pane" type="button" role="tab">
                            State Sebelumnya (Before State)
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="payloadTabContent">
                    <div class="tab-pane fade show active" id="after-pane" role="tabpanel">
                        <pre class="bg-dark text-light p-3 rounded small font-monospace my-0" style="max-height: 320px; overflow-y: auto;" id="afterJsonViewer">Memuat data...</pre>
                    </div>
                    <div class="tab-pane fade" id="before-pane" role="tabpanel">
                        <pre class="bg-dark text-light p-3 rounded small font-monospace my-0" style="max-height: 320px; overflow-y: auto;" id="beforeJsonViewer">Memuat data...</pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function inspectPayload(logId) {
        document.getElementById('afterJsonViewer').innerText = 'Memuat payload JSON...';
        document.getElementById('beforeJsonViewer').innerText = 'Memuat payload JSON...';

        var modal = new bootstrap.Modal(document.getElementById('payloadModal'));
        modal.show();

        fetch('/admin/audit/' + logId)
            .then(function(res) { return res.json(); })
            .then(function(data) {
                document.getElementById('modalAction').innerText = data.action_type;
                document.getElementById('modalTarget').innerText = data.target_table + ' (' + data.record_id + ')';
                document.getElementById('modalAdmin').innerText = data.admin_name + ' (' + data.admin_email + ')';
                document.getElementById('modalTimeIp').innerText = data.created_at + ' · IP: ' + data.ip_address;

                document.getElementById('afterJsonViewer').innerText = data.after_state ? JSON.stringify(data.after_state, null, 2) : 'Tidak ada perubahan state (NULL)';
                document.getElementById('beforeJsonViewer').innerText = data.before_state ? JSON.stringify(data.before_state, null, 2) : 'Record baru (NULL / INITIAL_CREATION)';
            })
            .catch(function(err) {
                document.getElementById('afterJsonViewer').innerText = 'Gagal memuat detail payload: ' + err;
            });
    }
</script>
@endpush
@endsection

