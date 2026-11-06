@extends('layouts.app')

@section('title', 'Manajemen Operator & Hub')

@section('content')
<!-- Page Title & Actions -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="text-dark mb-0 fw-bold">Tata Kelola Operator Regional Hub</h3>
        <p class="text-muted small mb-0">Kelola izin akses, peran kepabeanan internasional, mutasi cabang, dan penerbitan token undangan 24 jam.</p>
    </div>
    <button class="btn btn-primary btn-sm shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#inviteOperatorModal">
        <x-icon name="user-plus" size="0.9rem" class="text-white-50 me-1" /> + Undang Operator Baru
    </button>
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
                <strong>Gagal Menyimpan:</strong>
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

<!-- Active Invitation Token Banner (Shown right after invite or resend) -->
@if(session('invitation_url'))
    <div class="card border-primary bg-primary-subtle shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                <div class="d-flex align-items-center">
                    <x-icon name="key" class="text-primary me-2" size="1.25rem" />
                    <h6 class="mb-0 fw-bold text-primary">Tautan Undangan Mandiri Berhasil Diterbitkan</h6>
                </div>
                <span class="badge bg-primary text-white">
                    <x-icon name="clock" size="0.75rem" class="me-1" /> Kedaluwarsa: {{ session('invitation_expires') }}
                </span>
            </div>
            <p class="text-muted small mb-3">
                Undangan dibuat untuk <strong>{{ session('invitation_name') }}</strong> ({{ session('invitation_phone') }}). Salin tautan berikut atau kirim langsung melalui WhatsApp operator untuk proses verifikasi dan aktivasi mandiri akun:
            </p>
            <div class="row g-2 align-items-center">
                <div class="col-md-9">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><x-icon name="link" size="0.9rem" /></span>
                        <input type="text" id="invitationUrlInput" class="form-control bg-white font-monospace" value="{{ session('invitation_url') }}" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="copyInvitationLink()">
                            <x-icon name="copy" size="0.9rem" class="me-1" /> <span id="copyBtnText">Salin Tautan</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', session('invitation_phone') ?? '');
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                        $waText = rawurlencode("Halo " . session('invitation_name') . ", Anda diundang sebagai Operator resmi SoraCargo. Silakan lakukan aktivasi akun Anda dalam 24 jam melalui tautan berikut: " . session('invitation_url'));
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" class="btn btn-success btn-sm w-100">
                        <x-icon name="brand-whatsapp" size="0.9rem" class="me-1" /> Kirim via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Table Container Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold">
            <x-icon name="user-cog" class="me-2" />Daftar Akun Operator Lapangan
        </h6>
        <span class="badge bg-light text-primary border">Total {{ $totalCount }} Akun Terdaftar</span>
    </div>
    
    <div class="card-body">
        <!-- In-Page Tab Filters (Semua, Lokal vs Lintas Batas) -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="operatorTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($tier) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.operators.index', array_filter(['hub' => $hubId, 'search' => $search])) }}">
                    <x-icon name="users" class="me-1" /> Semua Operator ({{ $totalCount }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $tier === 'local' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.operators.index', array_filter(['tier' => 'local', 'hub' => $hubId, 'search' => $search])) }}">
                    <x-icon name="truck" class="me-1" /> Operator Lokal ({{ $localCount }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tier === 'cross_border' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.operators.index', array_filter(['tier' => 'cross_border', 'hub' => $hubId, 'search' => $search])) }}">
                    <x-icon name="ship" class="me-1" /> Operator Lintas Batas ({{ $crossBorderCount }})
                </a>
            </li>
        </ul>

        <!-- Filter & Search Controls Form -->
        <form method="GET" action="{{ route('admin.operators.index') }}" class="row mb-3 g-2">
            @if(!empty($tier))
                <input type="hidden" name="tier" value="{{ $tier }}">
            @endif
            <div class="col-md-5 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Filter Hub:</label>
                    <select name="hub" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" {{ empty($hubId) || $hubId === 'all' ? 'selected' : '' }}>Semua Regional Hub</option>
                        @foreach($ports as $port)
                            <option value="{{ $port->id }}" {{ $hubId === $port->id ? 'selected' : '' }}>
                                {{ $port->name }} ({{ $port->city }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-7">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari nama, ID pegawai, atau email..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                    @if(!empty($search) || (!empty($hubId) && $hubId !== 'all'))
                        <a href="{{ route('admin.operators.index', array_filter(['tier' => $tier])) }}" class="btn btn-outline-danger" title="Reset Filter">
                            <x-icon name="x" />
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Table Responsive -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="operatorTable">
                <thead class="table-light">
                    <tr>
                        <th>Operator</th>
                        <th>ID Pegawai</th>
                        <th>Peran &amp; Regional Hub</th>
                        <th>Shift Dinas</th>
                        <th>KPI Rating</th>
                        <th>Keamanan &amp; VPN</th>
                        <th>Status Akun</th>
                        <th class="text-center">Aksi Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($operators as $operator)
                        @php
                            $user = $operator->user;
                            $avatarIndex = (abs(crc32($operator->id)) % 5) + 1;
                            $invitation = $invitationsByEmail->get($user->email ?? '');
                        @endphp
                        <tr>
                            <!-- 1. Operator -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-3" width="38" height="38" src="{{ asset("assets/img/avatars/avatar{$avatarIndex}.jpeg") }}" alt="Avatar">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name ?? 'Tanpa Nama' }}</div>
                                        <div class="text-muted small">{{ $user->email ?? '-' }}</div>
                                        @if(!empty($user->phone))
                                            <div class="text-muted text-xs">{{ $user->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- 2. ID Pegawai -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace">{{ $operator->employee_id }}</span>
                            </td>

                            <!-- 3. Peran & Hub -->
                            <td>
                                <div>
                                    @if($operator->role_tier === 'OPERATOR_INTERNATIONAL')
                                        <span class="badge badge-international">OPERATOR_INTERNATIONAL</span>
                                    @else
                                        <span class="badge badge-domestic">OPERATOR_DOMESTIC</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    @if($operator->hub)
                                        <div class="fw-semibold text-dark small">{{ $operator->hub->name }}</div>
                                        <small class="text-muted text-xs">{{ $operator->hub->city }} ({{ $operator->hub->id }})</small>
                                    @else
                                        <span class="text-muted text-xs">-</span>
                                    @endif
                                </div>
                            </td>

                            <!-- 4. Shift Dinas (ops.operator_profiles.is_on_duty) -->
                            <td>
                                @if($operator->is_on_duty)
                                    <span class="badge bg-success text-white px-2 py-1">
                                        <span class="spinner-grow spinner-grow-sm me-1" style="width: 0.45rem; height: 0.45rem;"></span> ON DUTY
                                    </span>
                                    <div class="text-muted text-xs mt-1">Piket Lapangan</div>
                                @else
                                    <span class="badge bg-light text-muted border px-2 py-1">OFF DUTY</span>
                                    <div class="text-muted text-xs mt-1">Luar Shift</div>
                                @endif
                            </td>

                            <!-- 5. KPI Rating (ops.operator_profiles.kpi_rating) -->
                            <td>
                                <div class="d-flex align-items-center gap-1 text-dark fw-bold small">
                                    <span class="text-warning">★</span>
                                    <span>{{ number_format((float)($operator->kpi_rating ?? 5.0), 2) }}</span>
                                    <span class="text-muted text-xs">/ 5.0</span>
                                </div>
                                <div class="text-muted text-xs">SLA &amp; Audit Skor</div>
                            </td>

                            <!-- 6. Keamanan & VPN Subnet -->
                            <td>
                                <div>
                                    @if($user && $user->status === 'PENDING_ACTIVATION')
                                        <span class="badge bg-secondary">
                                            <x-icon name="clock" size="0.75rem" class="me-1" /> Menunggu Aktivasi
                                        </span>
                                    @elseif($user && $user->status === 'SUSPENDED')
                                        <span class="badge bg-danger text-white">
                                            <x-icon name="ban" size="0.75rem" class="me-1" /> Akses Dibekukan
                                        </span>
                                    @elseif($user && $user->two_factor_enabled_at)
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            <x-icon name="brand-whatsapp" class="me-1" /> WA OTP
                                        </span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary border border-primary">
                                            <x-icon name="phone" class="me-1" /> TOTP
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span class="badge bg-light text-muted border text-xs font-monospace" title="WireGuard VPN Subnet: {{ $operator->wireguard_pubkey ?? 'Internal Gateway Key' }}">
                                        <x-icon name="shield" size="0.65rem" class="text-primary me-1" /> VPN WireGuard
                                    </span>
                                </div>
                            </td>

                            <!-- 7. Status Akun -->
                            <td>
                                @if($user && $user->status === 'ACTIVE')
                                    <span class="badge badge-active">ACTIVE</span>
                                @elseif($user && $user->status === 'PENDING_ACTIVATION')
                                    <span class="badge badge-pending">PENDING_ACTIVATION</span>
                                    @if($invitation)
                                        <div class="text-muted text-xs mt-1">Sisa Token: {{ $invitation->hoursRemaining() }} Jam</div>
                                    @endif
                                @elseif($user && $user->status === 'SUSPENDED')
                                    <span class="badge badge-suspended">SUSPENDED</span>
                                @else
                                    <span class="badge bg-secondary">{{ $user->status ?? 'UNKNOWN' }}</span>
                                @endif
                            </td>

                            <!-- 8. Aksi Kelola -->
                            <td class="text-center text-nowrap">
                                <form action="{{ route('admin.operators.duty', $operator->id) }}" method="POST" class="d-inline me-1">
                                    @csrf
                                    <button class="btn btn-xs {{ $operator->is_on_duty ? 'btn-outline-warning' : 'btn-outline-success' }}" type="submit" title="Ubah Status Shift Dinas (On-Duty / Off-Duty)">
                                        <x-icon name="clock" size="0.75rem" class="me-1" /> {{ $operator->is_on_duty ? 'Off-Duty' : 'On-Duty' }}
                                    </button>
                                </form>

                                @if($user && $user->status === 'PENDING_ACTIVATION')
                                    <form action="{{ route('admin.operators.resend', $operator->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-xs btn-outline-primary" type="submit" title="Terbitkan Ulang Token Undangan 24 Jam">
                                            <x-icon name="mail" class="me-1" /> Kirim
                                        </button>
                                    </form>
                                @elseif($user && $user->status === 'SUSPENDED')
                                    <form action="{{ route('admin.operators.toggle', $operator->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-xs btn-success" type="submit" onclick="return confirm('Apakah Anda yakin ingin memulihkan status akun operator {{ $user->name }}?')">
                                            <x-icon name="unlock" class="me-1" /> Pulihkan
                                        </button>
                                    </form>
                                @else
                                    <div class="dropdown no-arrow d-inline">
                                        <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <x-icon name="more-horizontal" size="0.75rem" />
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#inviteOperatorModal">
                                                    <x-icon name="arrow-left-right" class="me-2 text-primary" />Perbarui Hub
                                                </button>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.operators.toggle', $operator->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membekukan (suspend) akses operator {{ $user->name }}?')">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <x-icon name="ban" class="me-2 text-danger" />Bekukan Akun (Suspend)
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <x-icon name="users" size="2.5rem" class="mb-2 text-secondary opacity-50" />
                                    <div class="fw-bold">Tidak ada data operator ditemukan</div>
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
                    Menampilkan {{ $operators->firstItem() ?? 0 }} sampai {{ $operators->lastItem() ?? 0 }} dari {{ $operators->total() }} operator regional
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                {{ $operators->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL: INVITE NEW OPERATOR -->
<div class="modal fade" id="inviteOperatorModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="inviteModalLabel">
                    <x-icon name="mail" class="me-2" />Undang Operator Resmi Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.operators.invite') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <x-icon name="info" class="me-1" />
                        Sistem akan menerbitkan token aktivasi kriptografis 24-jam. Tautan aktivasi dapat langsung Anda salin dan bagikan via WhatsApp kepada calon operator.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap Operator <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Contoh: Hendra Kusuma" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Kantor Resmi <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="hendra.ops@soracargo.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor WhatsApp / HP Aktif <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control form-control-sm" placeholder="+6281234567890" value="{{ old('phone') }}" required>
                        <div class="form-text text-xs">Digunakan untuk pengiriman tautan aktivasi dan verifikasi 2FA WhatsApp.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">ID Pegawai <span class="text-danger">*</span></label>
                            <input type="text" name="employee_id" class="form-control form-control-sm font-monospace text-uppercase" placeholder="OPS-JKT-105" value="{{ old('employee_id') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Regional Hub <span class="text-danger">*</span></label>
                            <select name="hub_id" class="form-select form-select-sm" required>
                                <option value="" disabled {{ old('hub_id') ? '' : 'selected' }}>-- Pilih Hub --</option>
                                @foreach($ports as $port)
                                    <option value="{{ $port->id }}" {{ old('hub_id') === $port->id ? 'selected' : '' }}>
                                        {{ $port->name }} ({{ $port->id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Peran Operasional (Role) <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="roleDomestic" value="OPERATOR_DOMESTIC" {{ old('role', 'OPERATOR_DOMESTIC') === 'OPERATOR_DOMESTIC' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="roleDomestic">
                                <strong>OPERATOR_DOMESTIC</strong> (Truk Darat & Pelayaran Nusantara)
                            </label>
                        </div>
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="radio" name="role" id="roleInternational" value="OPERATOR_INTERNATIONAL" {{ old('role') === 'OPERATOR_INTERNATIONAL' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="roleInternational">
                                <strong>OPERATOR_INTERNATIONAL</strong> (Ekspor-Impor, PPJK, & Bea Cukai)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="mail" class="me-1" /> Terbitkan & Kirim Undangan (24 Jam)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyInvitationLink() {
    const input = document.getElementById('invitationUrlInput');
    if (!input) return;
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        const btnText = document.getElementById('copyBtnText');
        if (btnText) {
            btnText.innerText = 'Tersalin!';
            setTimeout(() => {
                btnText.innerText = 'Salin Tautan';
            }, 2500);
        }
    });
}
</script>
@endsection
