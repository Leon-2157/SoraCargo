@extends('layouts.app')

@section('title', 'Kelola Staf & Hak Akses')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Kelola Staf &amp; Hak Akses</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="badge-check" size="0.85rem" class="me-1" /> RBAC Security
            </span>
        </div>
        <p class="text-muted small mb-0">Manajemen akun staf kantor pusat, pembagian peran Role-Based Access Control (Superadmin, Finance, Operations), dan mitigasi keamanan login.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <button class="btn btn-sm btn-primary d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#newStaffModal">
            <x-icon name="user-plus" class="me-1" /> Daftarkan Staf Baru
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
    <!-- Card 1: Total Staff -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Staf Kantor Pusat</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalStaff }} Orang</div>
                        <span class="text-muted text-xs">Akun internal terverifikasi</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="users" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Superadmin -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-danger fw-bold text-xs mb-1">Superadmin Penuh</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $superAdmins }} Akun</div>
                        <span class="text-danger text-xs fw-semibold"><x-icon name="shield-check" size="0.75rem" /> Hak veto &amp; audit penuh</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="shield-check" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Finance Admins -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Divisi Keuangan &amp; Pajak</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $financeAdmins }} Staf</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="vault" size="0.75rem" /> Escrow &amp; invoicing B2B</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="vault" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Ops Admins -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Divisi Operasional &amp; Hub</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $opsAdmins }} Staf</div>
                        <span class="text-muted text-xs">Booking &amp; pelacakan manifes</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="truck" class="text-gray-300" size="2rem" />
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
            <x-icon name="users" class="me-2" />Daftar Akun Staf Kantor Pusat &amp; Hak Akses Modul
        </h6>
        <span class="badge bg-light text-primary border">Enforced RBAC Protocol</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="staffFilterTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($role) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.staff', ['search' => $search]) }}">
                    <x-icon name="layers" class="me-1" /> Semua Staf ({{ $staffs->total() }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $role === 'SUPER_ADMIN' ? 'active' : '' }} py-1 px-3 small fw-bold text-danger" href="{{ route('admin.staff', ['role' => 'SUPER_ADMIN', 'search' => $search]) }}">
                    <x-icon name="shield-check" class="me-1" /> Superadmin ({{ $superAdmins }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $role === 'FINANCE_ADMIN' ? 'active' : '' }} py-1 px-3 small fw-bold text-success" href="{{ route('admin.staff', ['role' => 'FINANCE_ADMIN', 'search' => $search]) }}">
                    <x-icon name="vault" class="me-1" /> Finance ({{ $financeAdmins }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $role === 'OPS_ADMIN' ? 'active' : '' }} py-1 px-3 small fw-bold text-info" href="{{ route('admin.staff', ['role' => 'OPS_ADMIN', 'search' => $search]) }}">
                    <x-icon name="truck" class="me-1" /> Operations ({{ $opsAdmins }})
                </a>
            </li>
        </ul>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.staff') }}" class="row mb-3 g-2">
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="col-md-9 col-lg-10">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari nama staf, alamat email, atau nomor telepon..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                @if($search)
                    <a href="{{ route('admin.staff') }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- Staff Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="staffTable">
                <thead class="table-light">
                    <tr>
                        <th>Nama &amp; Kontak Staf</th>
                        <th>Peran Akses (RBAC)</th>
                        <th>Cakupan Hak Akses Modul</th>
                        <th>Status Akun</th>
                        <th>Waktu Didaftarkan</th>
                        <th class="text-center">Aksi Superadmin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $s)
                        @php
                            $isSuper = ($s->admin_role === 'SUPER_ADMIN');
                            $isActive = ($s->status === 'ACTIVE');
                            $isPrimary = ($s->email === 'valerie.admin@soracargo.com');
                        @endphp
                        <tr>
                            <!-- 1. Nama & Kontak -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle me-3" width="36" height="36" src="http://127.0.0.1:8003/assets/img/avatars/avatar1.jpeg" alt="Avatar">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $s->name }}</div>
                                        <div class="text-muted text-xs">{{ $s->email }}</div>
                                        @if($s->phone)
                                            <div class="text-muted text-xs">{{ $s->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- 2. Peran Akses -->
                            <td>
                                @if($isSuper)
                                    <span class="badge bg-danger text-white">
                                        <x-icon name="shield-check" size="0.75rem" class="me-1" /> SUPER_ADMIN
                                    </span>
                                @elseif($s->admin_role === 'FINANCE_ADMIN')
                                    <span class="badge bg-success text-white">
                                        <x-icon name="vault" size="0.75rem" class="me-1" /> FINANCE_ADMIN
                                    </span>
                                @elseif($s->admin_role === 'OPS_ADMIN')
                                    <span class="badge bg-info text-white">
                                        <x-icon name="truck" size="0.75rem" class="me-1" /> OPS_ADMIN
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white">{{ $s->admin_role ?? 'STAFF' }}</span>
                                @endif
                            </td>

                            <!-- 3. Cakupan Izin -->
                            <td>
                                @if($isSuper)
                                    <span class="text-xs fw-semibold text-danger">Otoritas Penuh (Seluruh Modul &amp; Veto Escrow)</span>
                                @elseif($s->admin_role === 'FINANCE_ADMIN')
                                    <span class="text-xs fw-semibold text-success">Escrow, Faktur B2B, &amp; Rekap Pajak</span>
                                @elseif($s->admin_role === 'OPS_ADMIN')
                                    <span class="text-xs fw-semibold text-info">Booking, Manifes, Depo, &amp; Rute Ekspedisi</span>
                                @else
                                    <span class="text-xs text-muted">Akses Terbatas Sesuai Penugasan</span>
                                @endif
                            </td>

                            <!-- 4. Status Akun -->
                            <td>
                                @if($isActive)
                                    <span class="badge bg-success text-white">
                                        <x-icon name="check-circle" size="0.7rem" class="me-1" /> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger text-white">
                                        <x-icon name="ban" size="0.7rem" class="me-1" /> Ditangguhkan
                                    </span>
                                @endif
                            </td>

                            <!-- 5. Waktu Didaftarkan -->
                            <td>
                                <div class="text-xs text-dark">{{ $s->created_at->format('d M Y') }}</div>
                                <div class="text-muted text-xs font-monospace">{{ $s->created_at->format('H:i') }} WIB</div>
                            </td>

                            <!-- 6. Aksi Superadmin -->
                            <td class="text-center">
                                @if($isPrimary)
                                    <span class="badge bg-light text-muted border text-xs" title="Akun Superadmin Utama terlindungi">
                                        <x-icon name="lock" size="0.7rem" /> Superadmin Utama
                                    </span>
                                @else
                                    <form action="{{ route('admin.staff.toggle', $s->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status aktif akun staf ini?');">
                                        @csrf
                                        <button class="btn btn-sm {{ $isActive ? 'btn-outline-danger' : 'btn-outline-success' }}" type="submit">
                                            <x-icon name="{{ $isActive ? 'ban' : 'check-circle' }}" class="me-1" size="0.75rem" />
                                            {{ $isActive ? 'Bekukan Akun' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <x-icon name="users" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada akun staf pada filter ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($staffs->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $staffs->firstItem() }} - {{ $staffs->lastItem() }} dari {{ $staffs->total() }} akun staf
                </div>
                <div>
                    {{ $staffs->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL: Tambah Staf Baru -->
<div class="modal fade" id="newStaffModal" tabindex="-1" aria-labelledby="newStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.staff.store') }}">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="newStaffModalLabel">
                        <x-icon name="user-plus" class="me-2" /> Daftarkan Akun Staf Kantor Pusat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nama Lengkap Staf <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Contoh: Andi Pratama" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Alamat Email Perusahaan (@soracargo.com) <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Contoh: andi.ops@soracargo.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control form-control-sm" placeholder="Contoh: 081234567890">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Peran Akses RBAC <span class="text-danger">*</span></label>
                        <select name="admin_role" class="form-select form-select-sm" required>
                            <option value="OPS_ADMIN">OPS_ADMIN (Divisi Operasional &amp; Manifes Kapal)</option>
                            <option value="FINANCE_ADMIN">FINANCE_ADMIN (Divisi Keuangan, Escrow &amp; Faktur)</option>
                            <option value="SUPER_ADMIN">SUPER_ADMIN (Hak Akses Penuh &amp; Otoritas Veto)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Kata Sandi Awal Akun <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Minimal 8 karakter" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Akun Staf
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

