@extends('layouts.app')

@section('title', 'Kamus Barang & Bea Cukai (HS Code)')

@section('content')
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Kamus Barang &amp; Bea Cukai (HS Code)</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">
                <x-icon name="barcode" size="0.85rem" class="me-1" /> Klasifikasi Kepabeanan (BTKI)
            </span>
        </div>
        <p class="text-muted small mb-0">Tata kelola pos tarif 8 digit Buku Tarif Kepabeanan Indonesia (BTKI), matriks bea masuk, PPN/PPh impor, dan verifikasi perizinan Lartas.</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <button class="btn btn-sm btn-primary d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#newHsCodeModal">
            <x-icon name="plus" class="me-1" /> Tambah Pos Tarif HS Code
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
    <!-- Card 1: Total HS Codes -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Pos Tarif Terdaftar</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalHsCodes }} Komoditas</div>
                        <span class="text-muted text-xs">Standardisasi 8-Digit BTKI</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="barcode" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Lartas Restrictions -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-danger fw-bold text-xs mb-1">Komoditas Terkena Lartas</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalLartas }} Pos Tarif</div>
                        <span class="text-danger text-xs fw-semibold"><x-icon name="shield-alert" size="0.75rem" /> Wajib Izin Instansi Khusus</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="shield-alert" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Non Lartas -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Komoditas Bebas (Jalur Hijau)</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $totalNonLartas }} Pos Tarif</div>
                        <span class="text-success text-xs fw-semibold"><x-icon name="check-circle" size="0.75rem" /> Clearance Otomatis</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="check-circle" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Avg Duty -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Rata-rata Bea Masuk</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ round($avgImportDuty, 1) }}%</div>
                        <span class="text-muted text-xs">Tarif MFN Direktorat Jenderal Bea Cukai</span>
                    </div>
                    <div class="col-auto">
                        <x-icon name="coins" class="text-gray-300" size="2rem" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main HS Code Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold d-flex align-items-center">
            <x-icon name="barcode" class="me-2" />Daftar Klasifikasi Pos Tarif &amp; Matriks Kepabeanan
        </h6>
        <span class="badge bg-light text-primary border">INSW &amp; DJBC Compliant</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="hsFilterTab">
            <li class="nav-item me-1">
                <a class="nav-link {{ empty($filterLartas) ? 'active' : '' }} py-1 px-3 small fw-bold" href="{{ route('admin.logistics.hscode', ['search' => $search]) }}">
                    <x-icon name="layers" class="me-1" /> Semua Pos Tarif ({{ $hscodes->total() }})
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link {{ $filterLartas === 'yes' ? 'active' : '' }} py-1 px-3 small fw-bold text-danger" href="{{ route('admin.logistics.hscode', ['lartas' => 'yes', 'search' => $search]) }}">
                    <x-icon name="shield-alert" class="me-1" /> Komoditas Lartas ({{ $totalLartas }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $filterLartas === 'no' ? 'active' : '' }} py-1 px-3 small fw-bold text-success" href="{{ route('admin.logistics.hscode', ['lartas' => 'no', 'search' => $search]) }}">
                    <x-icon name="check-circle" class="me-1" /> Bebas Lartas ({{ $totalNonLartas }})
                </a>
            </li>
        </ul>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.logistics.hscode') }}" class="row mb-3 g-2">
            <input type="hidden" name="lartas" value="{{ $filterLartas }}">
            <div class="col-md-9 col-lg-10">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari kode 8 digit (0901.11.10), nama komoditas (Kopi, Laptop, Tekstil), atau instansi izin..." value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <x-icon name="search" />
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-lg-2">
                @if($search)
                    <a href="{{ route('admin.logistics.hscode') }}" class="btn btn-sm btn-outline-danger w-100">
                        <x-icon name="refresh-cw" class="me-1" /> Reset Filter
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                        <x-icon name="filter" class="me-1" /> Terapkan
                    </button>
                @endif
            </div>
        </form>

        <!-- HS Codes Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="hsCodeTable">
                <thead class="table-light">
                    <tr>
                        <th>Pos Tarif &amp; Uraian Barang</th>
                        <th>Tarif Bea Masuk (BM)</th>
                        <th>PPN Impor</th>
                        <th>PPh Pasal 22 Impor</th>
                        <th>Ketentuan Lartas &amp; Instansi</th>
                        <th>Indikasi Jalur Bea Cukai</th>
                        <th>Pesanan Kargo</th>
                        <th class="text-center">Aksi Superadmin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hscodes as $item)
                        @php
                            $isLartas = $item->has_lartas_restriction;
                            $isRedChannel = $isLartas || ($item->import_duty_pct >= 10);
                        @endphp
                        <tr class="{{ $isLartas ? 'table-warning-subtle' : '' }}">
                            <!-- 1. Pos Tarif & Uraian Barang -->
                            <td>
                                <div class="fw-bold font-monospace text-primary h6 mb-1">{{ $item->code }}</div>
                                <div class="fw-semibold text-dark">{{ $item->description_id }}</div>
                                @if($item->description_en)
                                    <div class="text-muted text-xs fst-italic">{{ $item->description_en }}</div>
                                @endif
                            </td>

                            <!-- 2. Bea Masuk -->
                            <td>
                                <span class="badge {{ $item->import_duty_pct > 0 ? 'bg-primary' : 'bg-light text-secondary border' }} font-monospace text-xs">
                                    {{ $item->import_duty_pct }}%
                                </span>
                            </td>

                            <!-- 3. PPN Impor -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace text-xs">
                                    {{ $item->vat_pct }}%
                                </span>
                            </td>

                            <!-- 4. PPh 22 Impor -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace text-xs">
                                    {{ $item->income_tax_pct }}%
                                </span>
                            </td>

                            <!-- 5. Ketentuan Lartas & Instansi -->
                            <td>
                                @if($isLartas)
                                    <span class="badge bg-danger text-white mb-1 text-xs">
                                        <x-icon name="shield-alert" size="0.7rem" class="me-1" /> Wajib Izin Lartas
                                    </span>
                                    <div class="text-xs text-dark fw-semibold">
                                        {{ $item->required_permit_agency ?? 'Instansi Terkait' }}
                                    </div>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle text-xs">
                                        <x-icon name="check-circle" size="0.7rem" class="me-1" /> Bebas Lartas
                                    </span>
                                    <div class="text-xs text-muted">Komoditas Non-Regulated</div>
                                @endif
                            </td>

                            <!-- 6. Indikasi Jalur Bea Cukai -->
                            <td>
                                @if($isRedChannel)
                                    <span class="badge bg-danger text-white">
                                        Jalur Merah (Fisik)
                                    </span>
                                    <div class="text-xs text-muted mt-1">Uji laboratorium / periksa peti</div>
                                @else
                                    <span class="badge bg-success text-white">
                                        Jalur Hijau (Otomatis)
                                    </span>
                                    <div class="text-xs text-muted mt-1">Clearance elektronik cepat</div>
                                @endif
                            </td>

                            <!-- 7. Pesanan Kargo -->
                            <td>
                                <span class="badge bg-light text-dark border font-monospace">
                                    {{ $item->cargo_bookings_count }} Resi
                                </span>
                            </td>

                            <!-- 8. Aksi Superadmin -->
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="openEditHsModal('{{ $item->code }}', '{{ addslashes($item->description_id) }}', '{{ addslashes($item->description_en) }}', '{{ $item->import_duty_pct }}', '{{ $item->vat_pct }}', '{{ $item->income_tax_pct }}', {{ $isLartas ? 'true' : 'false' }}, '{{ addslashes($item->required_permit_agency) }}')">
                                    <x-icon name="settings" class="me-1" size="0.8rem" /> Ubah
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <x-icon name="barcode" size="2.5rem" class="text-gray-300 mb-2" />
                                <div>Tidak ada pos tarif kepabeanan yang sesuai dengan filter.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($hscodes->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $hscodes->firstItem() }} - {{ $hscodes->lastItem() }} dari {{ $hscodes->total() }} pos tarif
                </div>
                <div>
                    {{ $hscodes->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- MODAL 1: Tambah Pos Tarif Baru -->
<div class="modal fade" id="newHsCodeModal" tabindex="-1" aria-labelledby="newHsCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('admin.logistics.hscode.store') }}">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="newHsCodeModalLabel">
                        <x-icon name="plus" class="me-2" /> Daftarkan Pos Tarif HS Code Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Kode HS (8 Digit Format BTKI) <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control form-control-sm font-monospace" placeholder="Contoh: 1006.30.90" required maxlength="15">
                        <span class="text-xs text-muted">Gunakan titik pemisah standar kepabeanan (misal: 0901.11.10).</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Uraian Komoditas Barang (Bahasa Indonesia) <span class="text-danger">*</span></label>
                        <textarea name="description_id" class="form-control form-control-sm" rows="2" placeholder="Uraian resmi Buku Tarif Kepabeanan Indonesia..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">English Goods Description (Opsional)</label>
                        <textarea name="description_en" class="form-control form-control-sm" rows="2" placeholder="Harmonized System international description..."></textarea>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-dark">Bea Masuk / BM (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="import_duty_pct" class="form-control form-control-sm" value="5.00" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-dark">PPN Impor (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="vat_pct" class="form-control form-control-sm" value="11.00" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-dark">PPh Pasal 22 (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="income_tax_pct" class="form-control form-control-sm" value="2.50" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Ketentuan Pembatasan Lartas <span class="text-danger">*</span></label>
                        <select name="has_lartas_restriction" id="newLartasSelect" class="form-select form-select-sm" required onchange="togglePermitAgencyInput(this.value, 'newAgencyBox')">
                            <option value="0">TIDAK (Komoditas Bebas Non-Lartas / Jalur Hijau)</option>
                            <option value="1">YA (Komoditas Terkena Lartas / Wajib Izin Khusus)</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="newAgencyBox">
                        <label class="form-label fw-bold small text-dark">Instansi Pembina / Penerbit Izin Lartas <span class="text-danger">*</span></label>
                        <input type="text" name="required_permit_agency" class="form-control form-control-sm" placeholder="Contoh: BPOM RI / Badan Karantina Indonesia / Kemendag PI">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Pos Tarif
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: Edit Pos Tarif -->
<div class="modal fade" id="editHsCodeModal" tabindex="-1" aria-labelledby="editHsCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editHsCodeForm">
            @csrf
            <div class="modal-content shadow border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="editHsCodeModalLabel">
                        <x-icon name="settings" class="me-2" /> Perbarui Pos Tarif &amp; Kebijakan Lartas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Kode HS (8 Digit)</label>
                        <input type="text" id="editHsCodeVal" class="form-control form-control-sm font-monospace fw-bold" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Uraian Barang (Bahasa Indonesia) <span class="text-danger">*</span></label>
                        <textarea name="description_id" id="editHsDescId" class="form-control form-control-sm" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">English Description</label>
                        <textarea name="description_en" id="editHsDescEn" class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-dark">Bea Masuk / BM (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="import_duty_pct" id="editHsBm" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-dark">PPN Impor (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="vat_pct" id="editHsVat" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-dark">PPh Pasal 22 (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="income_tax_pct" id="editHsPph" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Ketentuan Pembatasan Lartas <span class="text-danger">*</span></label>
                        <select name="has_lartas_restriction" id="editHsLartas" class="form-select form-select-sm" required onchange="togglePermitAgencyInput(this.value, 'editAgencyBox')">
                            <option value="0">TIDAK (Komoditas Bebas Non-Lartas / Jalur Hijau)</option>
                            <option value="1">YA (Komoditas Terkena Lartas / Wajib Izin Khusus)</option>
                        </select>
                    </div>

                    <div class="mb-3" id="editAgencyBox">
                        <label class="form-label fw-bold small text-dark">Instansi Pembina / Penerbit Izin Lartas</label>
                        <input type="text" name="required_permit_agency" id="editHsAgency" class="form-control form-control-sm" placeholder="Contoh: Badan Karantina Indonesia">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <x-icon name="check-circle" class="me-1" /> Simpan Perubahan Pos Tarif
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePermitAgencyInput(val, targetBoxId) {
        var box = document.getElementById(targetBoxId);
        if (val === '1' || val === 1 || val === true) {
            box.classList.remove('d-none');
        } else {
            box.classList.add('d-none');
        }
    }

    function openEditHsModal(code, descId, descEn, bm, vat, pph, isLartas, agency) {
        document.getElementById('editHsCodeForm').action = '/admin/logistics/hscode/' + encodeURIComponent(code);
        document.getElementById('editHsCodeVal').value = code;
        document.getElementById('editHsDescId').value = descId;
        document.getElementById('editHsDescEn').value = descEn;
        document.getElementById('editHsBm').value = bm;
        document.getElementById('editHsVat').value = vat;
        document.getElementById('editHsPph').value = pph;
        document.getElementById('editHsLartas').value = isLartas ? '1' : '0';
        document.getElementById('editHsAgency').value = agency;

        togglePermitAgencyInput(isLartas ? '1' : '0', 'editAgencyBox');

        var modal = new bootstrap.Modal(document.getElementById('editHsCodeModal'));
        modal.show();
    }
</script>
@endpush
@endsection

