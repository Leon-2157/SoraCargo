@extends('layouts.app')

@section('title', 'Faktur & Penagihan B2B')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Faktur &amp; Penagihan B2B</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="file-text" size="0.85rem" class="me-1" /> Term of Payment (TOP)
            </span>
        </div>
        <p class="text-muted small mb-0">Manajemen tagihan piutang korporat B2B tempo 14-60 hari, verifikasi rekonsiliasi transfer bank, dan eskalasi penagihan bertingkat SP-1/SP-2.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <span class="badge bg-light text-secondary border d-flex align-items-center px-3 py-2">
            <x-icon name="shield-check" class="text-success me-2" /> Penagihan Bertingkat &amp; Kunci Kredit
        </span>
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
    <!-- Card 1: Piutang Berjalan (Unpaid) -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Piutang Berjalan (Unpaid)</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalReceivables, 0, ',', '.') }}</div>
                        <span class="text-muted text-xs">{{ $counts['unpaid'] }} Faktur belum jatuh tempo</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="file-text" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Tunggakan Overdue -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-danger fw-bold text-xs mb-1">Tunggakan Lewat Tempo</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalOverdue, 0, ',', '.') }}</div>
                        <span class="text-danger text-xs fw-semibold"><x-icon name="alert-circle" size="0.75rem" /> {{ $overdueCount }} Faktur Perlu Tindakan</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="alert-circle" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Pelunasan Berhasil (Paid) -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Pelunasan Sukses (Settled)</div>
                        <div class="text-dark fw-bold h5 mb-0">Rp {{ number_format($totalCollected, 0, ',', '.') }}</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="clipboard-check" size="0.75rem" /> {{ $counts['paid'] }} Faktur Lunas</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="clipboard-check" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Status Mitigasi Piutang -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Tingkat Penagihan B2B</div>
                        <div class="text-dark fw-bold h5 mb-0">
                            @php
                                $totalAll = $totalReceivables + $totalOverdue + $totalCollected;
                                $rate = $totalAll > 0 ? round(($totalCollected / $totalAll) * 100, 1) : 100;
                            @endphp
                            {{ $rate }}%
                        </div>
                        <span class="text-muted text-xs">Rasio pemulihan arus kas</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="coins" class="text-gray-300" size="2rem" />
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
            <x-icon name="file-text" class="me-2" />Daftar Faktur Penagihan &amp; Piutang Korporat
        </h6>
        <span class="badge bg-light text-primary border">Skema Invoice Tempo 14-60 Hari</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="invoiceFilterTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'all' ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.finance.invoices', ['filter' => 'all', 'search' => $search]) }}">
                    <x-icon name="layers" class="me-1" /> Semua Faktur ({{ $counts['all'] }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'unpaid' ? 'active' : '' }} py-1 px-3 small fw-bold text-primary" href="{{ route('admin.finance.invoices', ['filter' => 'unpaid', 'search' => $search]) }}">
                    <x-icon name="clock" class="me-1" /> Belum Lunas / Unpaid ({{ $counts['unpaid'] }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $filter === 'overdue' ? 'active' : '' }} py-1 px-3 small fw-bold text-danger" href="{{ route('admin.finance.invoices', ['filter' => 'overdue', 'search' => $search]) }}">
                    <x-icon name="alert-circle" class="me-1" /> Lewat Jatuh Tempo / Overdue ({{ $counts['overdue'] }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $filter === 'paid' ? 'active' : '' }} py-1 px-3 small fw-bold text-success" href="{{ route('admin.finance.invoices', ['filter' => 'paid', 'search' => $search]) }}">
                    <x-icon name="check-circle" class="me-1" /> Lunas / Paid ({{ $counts['paid'] }})
                </a>
            </li>
        </ul>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.finance.invoices') }}" class="row mb-3 g-2">
            <input type="hidden" name="filter" value="{{ $filter }}">
            <div class="col-md-9 col-lg-10">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari nomor invoice (INV-...), nama perusahaan B2B, nama PIC, atau nomor resi..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                @if($search)
                    <a href="{{ route('admin.finance.invoices', ['filter' => $filter]) }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- Invoices Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="invoicesTable">
                <thead class="table-light">
                    <tr>
                        <th>No. Faktur &amp; Tanggal</th>
                        <th>Perusahaan Mitra B2B</th>
                        <th>Nominal Tagihan</th>
                        <th>Jatuh Tempo (Due Date)</th>
                        <th>Status Kredit &amp; Mitigasi</th>
                        <th>Status Pembayaran</th>
                        <th class="text-center">Aksi Superadmin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                        @php
                            $comp = $inv->company;
                            $user = $comp?->user;
                            $credit = $comp?->corporateCredit;
                            $isOverdue = ($inv->payment_status === 'OVERDUE') || ($inv->payment_status === 'UNPAID' && $inv->due_date->isPast());
                            $isLocked = ($user && $user->status === 'BOOKING_LOCKED');
                            $daysLeft = now()->startOfDay()->diffInDays($inv->due_date->startOfDay(), false);
                        @endphp
                        <tr class="{{ $isOverdue ? 'table-danger-subtle' : '' }}">
                            <!-- 1. No Faktur & Tanggal -->
                            <td>
                                <div class="fw-bold font-monospace text-primary">{{ $inv->invoice_number }}</div>
                                <div class="text-muted text-xs">Terbit: {{ $inv->created_at->format('d M Y') }}</div>
                                @if($inv->cargoBooking)
                                    <div class="text-xs text-secondary mt-1">
                                        <x-icon name="package" size="0.75rem" /> Resi: {{ $inv->cargoBooking->tracking_number }}
                                    </div>
                                @endif
                            </td>

                            <!-- 2. Perusahaan Mitra B2B -->
                            <td>
                                <div class="fw-bold text-dark d-flex align-items-center">
                                    <x-icon name="building-2" size="0.85rem" class="text-primary me-1" />
                                    {{ $comp?->company_name ?? 'Perusahaan N/A' }}
                                </div>
                                <div class="text-muted text-xs">NPWP: {{ $comp?->npwp ?? '-' }}</div>
                                <div class="text-xs text-dark mt-1">
                                    <x-icon name="user" size="0.75rem" class="text-secondary" /> PIC: {{ $comp?->pic_name ?? '-' }} ({{ $comp?->pic_phone ?? '-' }})
                                </div>
                            </td>

                            <!-- 3. Nominal Tagihan -->
                            <td>
                                <div class="fw-bold text-dark">Rp {{ number_format($inv->total_invoice_amount, 0, ',', '.') }}</div>
                                <span class="badge bg-light text-muted border text-xs">{{ $inv->currency }} (Kurs 1:1)</span>
                            </td>

                            <!-- 4. Jatuh Tempo (Due Date) -->
                            <td>
                                <div class="fw-semibold {{ $isOverdue ? 'text-danger' : 'text-dark' }}">
                                    {{ $inv->due_date->format('d M Y') }}
                                </div>
                                @if($inv->payment_status === 'PAID')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle text-xs">
                                        <x-icon name="check-circle" size="0.7rem" /> Lunas: {{ $inv->paid_at?->format('d M Y') }}
                                    </span>
                                @elseif($isOverdue)
                                    <span class="badge bg-danger text-white text-xs">
                                        <x-icon name="alert-triangle" size="0.7rem" /> Lewat {{ abs($daysLeft) }} Hari
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border text-xs">
                                        <x-icon name="clock" size="0.7rem" /> Sisa {{ $daysLeft }} Hari
                                    </span>
                                @endif
                            </td>

                            <!-- 5. Status Kredit & Mitigasi -->
                            <td>
                                @if($credit)
                                    <div class="text-xs mb-1">
                                        Plafon: <strong>Rp {{ number_format($credit->credit_limit_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    @if($credit->debt_enforcement_stage === 'SP1_ISSUED')
                                        <span class="badge bg-warning text-dark text-xs"><x-icon name="alert-triangle" size="0.7rem" /> SP-1 Diterbitkan</span>
                                    @elseif($credit->debt_enforcement_stage === 'SP2_ISSUED')
                                        <span class="badge bg-danger text-white text-xs"><x-icon name="shield-alert" size="0.7rem" /> SP-2 Peringatan Keras</span>
                                    @elseif($credit->debt_enforcement_stage === 'LEGAL_TAKEOVER')
                                        <span class="badge bg-dark text-white text-xs">Eskalasi Hukum</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle text-xs">Kredit Sehat</span>
                                    @endif

                                    @if($isLocked)
                                        <span class="badge bg-dark text-white text-xs ms-1"><x-icon name="lock" size="0.7rem" /> Booking Locked</span>
                                    @endif
                                @else
                                    <span class="text-muted text-xs">Tanpa Plafon Kredit</span>
                                @endif
                            </td>

                            <!-- 6. Status Pembayaran -->
                            <td>
                                @if($inv->payment_status === 'PAID')
                                    <span class="badge bg-success text-white">
                                        <x-icon name="check-circle" size="0.75rem" class="me-1" /> Lunas (Paid)
                                    </span>
                                @elseif($inv->payment_status === 'OVERDUE' || $isOverdue)
                                    <span class="badge bg-danger text-white">
                                        <x-icon name="alert-circle" size="0.75rem" class="me-1" /> Jatuh Tempo (Overdue)
                                    </span>
                                @else
                                    <span class="badge bg-primary text-white">
                                        <x-icon name="clock" size="0.75rem" class="me-1" /> Belum Lunas (Unpaid)
                                    </span>
                                @endif
                            </td>

                            <!-- 7. Aksi Superadmin -->
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Kelola
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Tindakan Finansial</h6></li>
                                        @if($inv->payment_status !== 'PAID')
                                            <li>
                                                <button class="dropdown-item small text-success fw-bold" type="button"
                                                    onclick="openReconcileModal('{{ $inv->id }}', '{{ $inv->invoice_number }}', '{{ $comp?->company_name }}', '{{ $inv->total_invoice_amount }}')">
                                                    <x-icon name="check-circle" class="me-2" size="0.85rem" /> Rekonsiliasi Pelunasan Bank
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item small text-primary" type="button"
                                                    onclick="openReminderModal('{{ $inv->id }}', '{{ $inv->invoice_number }}', '{{ $comp?->company_name }}', '{{ $comp?->pic_name }}', '{{ $comp?->pic_phone }}', '{{ $inv->total_invoice_amount }}')">
                                                    <x-icon name="brand-whatsapp" class="me-2" size="0.85rem" /> Kirim Tagihan / SP
                                                </button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.finance.invoices.lock', $inv->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah izin booking korporat perusahaan ini?');">
                                                    @csrf
                                                    <button class="dropdown-item small {{ $isLocked ? 'text-success' : 'text-danger' }}" type="submit">
                                                        <x-icon name="{{ $isLocked ? 'unlock' : 'lock' }}" class="me-2" size="0.85rem" />
                                                        {{ $isLocked ? 'Buka Kunci Booking Mitra' : 'Kunci Hak Booking (Lock)' }}
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <span class="dropdown-item small text-muted disabled">
                                                    <x-icon name="check-circle" class="me-2" size="0.85rem" /> Faktur Telah Lunas
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <x-icon name="file-text" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada data faktur penagihan pada filter ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($invoices->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $invoices->firstItem() }} - {{ $invoices->lastItem() }} dari {{ $invoices->total() }} faktur
                </div>
                <div>
                    {{ $invoices->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL 1: Rekonsiliasi Pelunasan Bank -->
<div class="modal fade" id="reconcileModal" tabindex="-1" aria-labelledby="reconcileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="reconcileForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="reconcileModalLabel">
                        <x-icon name="check-circle" class="me-2" /> Rekonsiliasi Bank Pelunasan Faktur
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border small text-muted mb-3">
                        Pemberian status Lunas akan otomatis mengurangi saldo pemakaian kredit mitra pada plafon korporat.
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nomor Faktur</label>
                            <input type="text" id="recInvoiceNum" class="form-control form-control-sm font-monospace" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Perusahaan Mitra</label>
                            <input type="text" id="recCompanyName" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Akun Bank Rekening Penampung <span class="text-danger">*</span></label>
                        <select name="bank_account" class="form-select form-select-sm" required>
                            <option value="BCA_ESCROW_88200192">BCA Giro Escrow (019-200-8821) a.n PT Sora Maritim Nusantara</option>
                            <option value="MANDIRI_ESCROW_1320098">Bank Mandiri Rek. Penampung (132-00-9812-4) a.n PT Sora Maritim</option>
                            <option value="BRI_ESCROW_02199182">Bank BRI Virtual Account Corporate</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nominal Pelunasan Masuk (Rp) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="paid_amount" id="recPaidAmount" class="form-control form-control-sm fw-bold" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Nomor Referensi Mutasi Bank / Slip Transfer <span class="text-danger">*</span></label>
                        <input type="text" name="payment_reference" class="form-control form-control-sm" placeholder="Contoh: TRF-BCA-20261106-99214" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Catatan Audit Superadmin Finance <span class="text-danger">*</span></label>
                        <textarea name="reconciliation_notes" class="form-control form-control-sm" rows="2" placeholder="Contoh: Dana telah dicek pada mutasi Internet Banking Bisnis dan sesuai dengan nominal faktur..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success">
                        <x-icon name="check-circle" class="me-1" /> Konfirmasi Pelunasan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Kirim Penagihan / SP Reminder Gateway -->
<div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="reminderForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="reminderModalLabel">
                        <x-icon name="brand-whatsapp" class="me-2" /> Kirim Surat Penagihan / Peringatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nomor Faktur</label>
                            <input type="text" id="remInvoiceNum" class="form-control form-control-sm font-monospace" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Tujuan Penerima (PIC)</label>
                            <input type="text" id="remPicInfo" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Tingkat Ketegasan Surat Penagihan <span class="text-danger">*</span></label>
                        <select name="notice_level" class="form-select form-select-sm" required>
                            <option value="FRIENDLY_REMINDER">Friendly Reminder (Pengingat Lembut Menjelang Jatuh Tempo)</option>
                            <option value="SP1_WARNING">Surat Peringatan 1 (SP-1: Tunggakan Telah Lewat Tempo)</option>
                            <option value="SP2_FINAL_DEMAND">Surat Peringatan 2 (SP-2 Final Demand: Peringatan Kunci Kredit &amp; Penalti)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Saluran Pengiriman Gateway <span class="text-danger">*</span></label>
                        <select name="reminder_channel" class="form-select form-select-sm" required>
                            <option value="WHATSAPP">WhatsApp Baileys Otomatis (Nomor Resmi SoraCargo)</option>
                            <option value="EMAIL">Email Resmi Finance (SMTP Corporate)</option>
                            <option value="BOTH">Kirim Keduanya (WhatsApp + Email Resmi)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Pesan Tambahan (Opsional)</label>
                        <textarea name="custom_message" class="form-control form-control-sm" rows="2" placeholder="Catatan khusus dari Finance kepada pihak PIC penagihan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="send" class="me-1" /> Kirimkan Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openReconcileModal(id, invoiceNum, companyName, amount) {
        document.getElementById('reconcileForm').action = '/admin/finance/invoices/' + id + '/reconcile';
        document.getElementById('recInvoiceNum').value = invoiceNum;
        document.getElementById('recCompanyName').value = companyName;
        document.getElementById('recPaidAmount').value = amount;

        var modal = new bootstrap.Modal(document.getElementById('reconcileModal'));
        modal.show();
    }

    function openReminderModal(id, invoiceNum, companyName, picName, picPhone, amount) {
        document.getElementById('reminderForm').action = '/admin/finance/invoices/' + id + '/remind';
        document.getElementById('remInvoiceNum').value = invoiceNum;
        document.getElementById('remPicInfo').value = picName + ' (' + picPhone + ')';

        var modal = new bootstrap.Modal(document.getElementById('reminderModal'));
        modal.show();
    }
</script>
@endpush
@endsection
