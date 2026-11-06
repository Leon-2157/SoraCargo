@extends('layouts.app')

@section('title', $title ?? 'Modul SoraCargo')

@section('content')
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="text-dark mb-0 fw-bold">{{ $title ?? 'Modul Administrasi' }}</h3>
        <p class="text-muted small mb-0">{{ $description ?? 'Halaman modul operasional logistik SoraCargo.' }}</p>
    </div>
    <div>
        <a href="{{ url('/admin') }}" class="btn btn-outline-primary btn-sm shadow-sm">
            <x-icon name="arrow-left" size="0.95rem" class="me-1" /> Kembali ke Dasbor
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body text-center py-5">
        <div class="mb-3">
            <x-icon name="{{ $icon ?? 'layers' }}" size="3.5rem" class="text-primary opacity-50" />
        </div>
        <h5 class="fw-bold text-dark mb-1">{{ $title ?? 'Modul Terdaftar' }}</h5>
        <p class="text-muted small max-w-md mx-auto mb-4" style="max-width: 480px;">
            Modul ini telah terdaftar dalam sistem arsitektur navigasi SoraCargo Superadmin. Anda dapat merancang antarmuka tabel atau komponen spesifiknya melalui Bootstrap Studio.
        </p>
        <div class="d-inline-flex gap-2">
            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                <x-icon name="check-circle" size="0.95rem" class="me-1" /> Rute & Skema Terverifikasi
            </span>
            <span class="badge bg-light text-dark border px-3 py-2">
                <x-icon name="shield-check" size="0.95rem" class="me-1" /> Hak Akses: Superadmin
            </span>
        </div>
    </div>
</div>
@endsection
