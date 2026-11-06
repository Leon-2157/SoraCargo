@extends('layouts.app')

@section('title', 'Pelanggan Retail & UMKM')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Manajemen Pelanggan Retail &amp; UMKM</h3>
            <span class="badge badge-retail fw-semibold px-2 py-1">
                <x-icon name="user" size="0.85rem" class="me-1" /> Klien Perorangan &amp; Toko Online
            </span>
        </div>
        <p class="text-muted small mb-0">Pengirim kargo retail dengan pembayaran 100% Prepaid Rekening Bersama Escrow dan verifikasi kepatuhan bertingkat (AML KTP untuk transaksi > Rp 50 Jt &amp; Dangerous Goods).</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <a href="{{ route('admin.customers.retail.export') }}" class="btn btn-outline-success btn-sm shadow-sm">
            <x-icon name="file-spreadsheet" size="0.9rem" class="me-1" /> Ekspor Data Retail (CSV)
        </a>
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
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- AML High Value Pending Alert -->
@if($pendingAmlCount > 0)
    <div class="alert alert-warning border-start border-4 border-warning shadow-sm mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <x-icon name="shield-alert" class="text-warning flex-shrink-0" />
                <div>
                    <strong>Pemberitahuan Kepatuhan Hukum (AML / Anti Money Laundering):</strong>
                    <span class="ms-1 small text-dark">
                        Terdapat <strong>{{ $pendingAmlCount }} pelanggan retail</strong> yang melakukan order bernilai tinggi (> Rp 50 Juta) atau kategori Dangerous Goods yang memerlukan validasi KTP/NIK.
                    </span>
                </div>
            </div>
            <a href="{{ route('admin.customers.retail.index', ['aml_status' => 'HIGH_VALUE_PENDING']) }}" class="btn btn-sm btn-outline-dark fw-bold">
                Review Berkas KTP NIK ({{ $pendingAmlCount }})
            </a>
        </div>
    </div>
@endif

<!-- Retail KPI Radar Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Total Pelanggan Retail</div>
                        <h4 class="fw-bold mb-0 mt-1">{{ number_format($totalRetailCount) }} <span class="fs-6 fw-normal text-muted">User</span></h4>
                        <div class="small text-success mt-1">
                            <x-icon name="badge-check" size="0.8rem" /> {{ $activeCount }} Akun Aktif
                        </div>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <x-icon name="users" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Saldo Escrow Berjalan</div>
                        <h4 class="fw-bold mb-0 mt-1 text-success">Rp {{ number_format($activePrepaidEscrow / 1000000, 1, ',', '.') }} <span class="fs-6 fw-normal text-muted">Juta</span></h4>
                        <div class="small text-muted mt-1">Prepaid tertahan di rekening bersama</div>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <x-icon name="escrow" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Izin Booking Dikunci</div>
                        <h4 class="fw-bold mb-0 mt-1 text-warning">{{ number_format($lockedCount) }} <span class="fs-6 fw-normal text-muted">Akun</span></h4>
                        <div class="small text-muted mt-1">Sanksi pembatalan berulang / investigasi</div>
                    </div>
                    <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                        <x-icon name="ban" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Masuk Daftar Hitam</div>
                        <h4 class="fw-bold mb-0 mt-1 text-danger">{{ number_format($blacklistedCount) }} <span class="fs-6 fw-normal text-muted">Akun</span></h4>
                        <div class="small text-danger mt-1">Permanent Blacklist</div>
                    </div>
                    <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                        <x-icon name="shield-alert" size="1.5rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.customers.retail.index') }}" class="row g-2 align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <x-icon name="search" size="0.85rem" class="text-muted" />
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Nama, Email, WhatsApp, NIK, atau Bidang Usaha..." value="{{ $search }}">
                </div>
            </div>

            <div class="col-lg-3 col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="all">Semua Status Akun</option>
                    <option value="ACTIVE" {{ $status === 'ACTIVE' ? 'selected' : '' }}>🟢 Aktif (Normal)</option>
                    <option value="BOOKING_LOCKED" {{ $status === 'BOOKING_LOCKED' ? 'selected' : '' }}>🟡 Booking Dikunci (Suspended)</option>
                    <option value="BLACKLISTED" {{ $status === 'BLACKLISTED' ? 'selected' : '' }}>🔴 Masuk Daftar Hitam (Blacklisted)</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-3">
                <select name="aml_status" class="form-select form-select-sm">
                    <option value="all">Semua Kepatuhan AML / NIK</option>
                    <option value="STANDARD_VERIFIED" {{ $amlStatus === 'STANDARD_VERIFIED' ? 'selected' : '' }}>Standard (OTP HP + Email)</option>
                    <option value="HIGH_VALUE_PENDING" {{ $amlStatus === 'HIGH_VALUE_PENDING' ? 'selected' : '' }}>⏳ Menunggu Verifikasi KTP (> Rp 50Jt)</option>
                    <option value="AML_VERIFIED" {{ $amlStatus === 'AML_VERIFIED' ? 'selected' : '' }}>✅ KTP NIK Terverifikasi Sah</option>
                    <option value="AML_REJECTED" {{ $amlStatus === 'AML_REJECTED' ? 'selected' : '' }}>❌ Verifikasi NIK Ditolak</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                    Filter
                </button>
                @if($search || ($status && $status !== 'all') || ($amlStatus && $amlStatus !== 'all'))
                    <a href="{{ route('admin.customers.retail.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Retail Customers Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-3 py-3">Nama Pengirim &amp; Komoditas Usaha</th>
                    <th class="py-3">Kontak WhatsApp &amp; Email</th>
                    <th class="py-3">Kepatuhan AML &amp; NIK</th>
                    <th class="py-3">Status Akun</th>
                    <th class="py-3">Tanggal Bergabung</th>
                    <th class="pe-3 py-3 text-end">Aksi Terpadu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($retailUsers as $user)
                    @php
                        $waPhone = preg_replace('/[^0-9]/', '', $user->phone ?? '');
                        if (str_starts_with($waPhone, '0')) {
                            $waPhone = '62' . substr($waPhone, 1);
                        }
                    @endphp
                    <tr>
                        <!-- Nama & Komoditas -->
                        <td class="ps-3 py-3">
                            <div class="fw-bold text-dark">
                                <a href="{{ route('admin.customers.retail.show', $user->id) }}" class="text-dark text-decoration-none hover-primary">
                                    {{ $user->name }}
                                </a>
                            </div>
                            <div class="small text-muted mt-1">
                                <span class="badge bg-light text-secondary border">
                                    <x-icon name="boxes" size="0.75rem" /> {{ $user->business_type ?? 'Perorangan UMKM' }}
                                </span>
                                @if($user->nik)
                                    <span class="badge bg-light text-dark border font-monospace ms-1">NIK: {{ $user->nik }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Kontak -->
                        <td class="py-3">
                            <div class="small text-muted">{{ $user->email }}</div>
                            @if($user->phone)
                                <div class="mt-1">
                                    <a href="https://wa.me/{{ $waPhone }}?text=Halo%20{{ urlencode($user->name) }},%20kami%20dari%20Tim%20SoraCargo." 
                                       target="_blank" 
                                       class="btn btn-outline-success btn-xs py-0 px-2 rounded-pill shadow-xs" 
                                       title="Buka Chat WhatsApp">
                                        <x-icon name="brand-whatsapp" size="0.75rem" class="me-1" /> {{ $user->phone }}
                                    </a>
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <!-- Kepatuhan AML -->
                        <td class="py-3">
                            @php $aml = $user->kyc_aml_status ?? 'STANDARD_VERIFIED'; @endphp
                            @if($aml === 'AML_VERIFIED')
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    <x-icon name="check-circle" size="0.8rem" /> KTP Terverifikasi
                                </span>
                                <div class="small text-muted mt-1">Kargo Nilai Tinggi Sah</div>
                            @elseif($aml === 'HIGH_VALUE_PENDING')
                                <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1">
                                    ⏳ Menunggu KTP (> Rp 50Jt)
                                </span>
                                <div class="small text-muted mt-1">Perlu validasi identitas</div>
                            @elseif($aml === 'AML_REJECTED')
                                <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1">
                                    ❌ NIK KTP Ditolak
                                </span>
                            @else
                                <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                    Standard (OTP WhatsApp)
                                </span>
                            @endif
                        </td>

                        <!-- Status Akun -->
                        <td class="py-3">
                            @if($user->status === 'ACTIVE')
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    🟢 Aktif
                                </span>
                            @elseif($user->status === 'BOOKING_LOCKED')
                                <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1">
                                    🟡 Izin Booking Dikunci
                                </span>
                            @elseif($user->status === 'BLACKLISTED')
                                <span class="badge bg-danger text-white fw-semibold px-2 py-1">
                                    🔴 Masuk Daftar Hitam
                                </span>
                            @else
                                <span class="badge bg-secondary px-2 py-1">{{ $user->status }}</span>
                            @endif
                        </td>

                        <!-- Tanggal Bergabung -->
                        <td class="py-3 small text-muted">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <!-- Aksi Terpadu -->
                        <td class="pe-3 py-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.customers.retail.show', $user->id) }}" class="btn btn-outline-primary btn-sm shadow-xs" title="Buka Detail Lengkap 360°">
                                    Detail 360°
                                </a>

                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-light btn-sm border shadow-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opsi
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <li>
                                            <button class="dropdown-item py-2 small" type="button" data-bs-toggle="modal" data-bs-target="#retailAmlModal{{ $user->id }}">
                                                <x-icon name="shield-check" size="0.85rem" class="me-2 text-primary" /> Verifikasi NIK KTP (AML)
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item py-2 small" type="button" data-bs-toggle="modal" data-bs-target="#retailStatusModal{{ $user->id }}">
                                                <x-icon name="user-cog" size="0.85rem" class="me-2 text-warning" /> Ubah Sanksi / Status Akun
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- MODAL 1: Verifikasi AML KTP NIK -->
                    <div class="modal fade" id="retailAmlModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="{{ route('admin.customers.retail.verify_aml', $user->id) }}">
                                    @csrf
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold fs-6">
                                            <x-icon name="shield-check" class="text-primary me-1" /> Verifikasi Kepatuhan NIK KTP (AML)
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="alert alert-secondary small mb-3">
                                            Pelanggan: <strong>{{ $user->name }}</strong> ({{ $user->email }})<br>
                                            No. WhatsApp: {{ $user->phone ?? '-' }}
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Nomor Induk Kependudukan (NIK KTP 16 Digit) <span class="text-danger">*</span></label>
                                            <input type="text" name="nik" class="form-control form-control-sm font-monospace" maxlength="16" placeholder="Contoh: 3171052309850002" value="{{ $user->nik ?? '' }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Bidang Usaha / Jenis Komoditas UMKM</label>
                                            <input type="text" name="business_type" class="form-control form-control-sm" placeholder="Contoh: Grosir Kopi, Sparepart Motor, Tekstil..." value="{{ $user->business_type ?? '' }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Status Keputusan Verifikasi AML <span class="text-danger">*</span></label>
                                            <select name="kyc_aml_status" class="form-select form-select-sm" required>
                                                <option value="AML_VERIFIED" {{ ($user->kyc_aml_status ?? '') === 'AML_VERIFIED' ? 'selected' : '' }}>
                                                    ✅ KTP Sah &amp; Valid (Boleh Kirim Kargo > Rp 50Jt / DG)
                                                </option>
                                                <option value="STANDARD_VERIFIED" {{ ($user->kyc_aml_status ?? '') === 'STANDARD_VERIFIED' ? 'selected' : '' }}>
                                                    Standard (Khusus Transaksi Retail Reguler)
                                                </option>
                                                <option value="AML_REJECTED" {{ ($user->kyc_aml_status ?? '') === 'AML_REJECTED' ? 'selected' : '' }}>
                                                    ❌ NIK / Dokumen KTP Tidak Valid (Ditolak)
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label small fw-bold">Catatan Verifikator</label>
                                            <textarea name="aml_notes" class="form-control form-control-sm" rows="2" placeholder="Catatan hasil validasi data Dukcapil..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">Simpan Verifikasi KTP</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 2: Ubah Sanksi / Status Akun -->
                    <div class="modal fade" id="retailStatusModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="{{ route('admin.customers.retail.status', $user->id) }}">
                                    @csrf
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold fs-6">
                                            <x-icon name="user-cog" class="text-warning me-1" /> Penetapan Sanksi Administratif Akun
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="alert alert-secondary small mb-3">
                                            Pelanggan: <strong>{{ $user->name }}</strong><br>
                                            Status Terkini: <strong>{{ $user->status }}</strong>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Pilih Status Akun Baru <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select form-select-sm" required>
                                                <option value="ACTIVE" {{ $user->status === 'ACTIVE' ? 'selected' : '' }}>🟢 Aktif (Izin Pemesanan Normal)</option>
                                                <option value="BOOKING_LOCKED" {{ $user->status === 'BOOKING_LOCKED' ? 'selected' : '' }}>🟡 Kunci Izin Booking (Pembatalan Berulang / Investigasi)</option>
                                                <option value="BLACKLISTED" {{ $user->status === 'BLACKLISTED' ? 'selected' : '' }}>🔴 Masuk Daftar Hitam (Permanen)</option>
                                            </select>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label small fw-bold">Alasan Penetapan Sanksi</label>
                                            <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Terjadi pembatalan kontainer 3 kali berturut-turut setelah proses Gate-In..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold">Simpan Sanksi Akun</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <x-icon name="user" size="2.5rem" class="text-secondary opacity-50 mb-2" />
                            <div class="fw-semibold">Tidak ada pelanggan retail yang ditemukan.</div>
                            <div class="small">Ubah kata kunci pencarian atau bersihkan filter.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($retailUsers->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan <strong>{{ $retailUsers->firstItem() }}</strong> - <strong>{{ $retailUsers->lastItem() }}</strong> dari <strong>{{ $retailUsers->total() }}</strong> pelanggan
                </div>
                <div>
                    {{ $retailUsers->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
