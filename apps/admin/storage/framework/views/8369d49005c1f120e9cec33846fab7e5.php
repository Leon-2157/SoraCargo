<!DOCTYPE html>
<html data-bs-theme="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $__env->yieldContent('title', 'Admin Central'); ?> - SoraCargo Global Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/bootstrap/css/bootstrap.min.css')); ?>">
    <!-- FontAwesome v5.12.0 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <!-- Theme Custom Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/styles.min.css')); ?>">
    
    <style>
        .sidebar-brand-text span {
            font-weight: 800;
            letter-spacing: 0.05rem;
        }
        .badge-domestic {
            background-color: #0284c7;
            color: #fff;
        }
        .badge-international {
            background-color: #7c3aed;
            color: #fff;
        }
        .badge-active {
            background-color: #10b981;
            color: #fff;
        }
        .badge-pending {
            background-color: #f59e0b;
            color: #fff;
        }
        .badge-suspended {
            background-color: #ef4444;
            color: #fff;
        }
        .badge-locked {
            background-color: #f59e0b;
            color: #fff;
        }
        .badge-blacklisted {
            background-color: #1f2937;
            color: #fff;
        }
        .badge-b2b {
            background-color: #4f46e5;
            color: #fff;
        }
        .badge-retail {
            background-color: #0d9488;
            color: #fff;
        }

        /* Lucide Icon Styling */
        .lucide-icon {
            display: inline-block;
            vertical-align: -0.15em;
            stroke-width: 2px;
            stroke: currentColor;
            fill: none;
        }
        .sidebar .nav-item .nav-link .lucide-icon {
            width: 1.15rem;
            height: 1.15rem;
            margin-right: 0.5rem;
            opacity: 0.85;
            transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
        }
        .sidebar .nav-item .nav-link:hover .lucide-icon,
        .sidebar .nav-item .nav-link:not(.collapsed) .lucide-icon {
            opacity: 1;
            transform: scale(1.08);
        }
        .sidebar .sidebar-brand-icon .lucide-icon {
            width: 2.2rem;
            height: 2.2rem;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- SIDEBAR -->
        <nav class="navbar align-items-start p-0 sidebar sidebar-dark accordion bg-gradient-primary navbar-dark">
            <div class="container-fluid d-flex flex-column p-0">
                <!-- Brand -->
                <a class="navbar-brand d-flex justify-content-center align-items-center m-0 sidebar-brand" href="<?php echo e(url('/admin')); ?>">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'ship','size' => '2rem','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ship','size' => '2rem','class' => 'text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                    </div>
                    <div class="mx-3 sidebar-brand-text">
                        <span>SoraCargo</span>
                    </div>
                </a>
                <hr class="my-0 sidebar-divider">

                <!-- Navigation List -->
                <ul class="navbar-nav text-light" id="accordionSidebar">

                    <!-- 2. OPERASIONAL -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('admin/bookings*') || request()->is('admin/operators*') || request()->is('admin/escalations*') || request()->is('admin/fleets*') ? '' : 'collapsed'); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOperasional" aria-expanded="<?php echo e(request()->is('admin/bookings*') || request()->is('admin/operators*') || request()->is('admin/escalations*') || request()->is('admin/fleets*') ? 'true' : 'false'); ?>" aria-controls="collapseOperasional">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'truck']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'truck']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                            <span>Operasional</span>
                        </a>
                        <div id="collapseOperasional" class="collapse <?php echo e(request()->is('admin/bookings*') || request()->is('admin/operators*') || request()->is('admin/escalations*') || request()->is('admin/fleets*') ? 'show' : ''); ?>" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Manajemen Armada:</h6>
                                <a class="collapse-item <?php echo e(request()->is('admin/bookings*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/bookings')); ?>">Daftar Booking & Pesanan</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/fleets*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/fleets')); ?>">Pelacakan & Manifes</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/operators*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/operators')); ?>">Manajemen Operator</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/escalations*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/escalations')); ?>">Pusat Darurat & Kendala</a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider my-2">

                    <!-- 3. PELANGGAN -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('admin/customers*') ? '' : 'collapsed'); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePelanggan" aria-expanded="<?php echo e(request()->is('admin/customers*') ? 'true' : 'false'); ?>" aria-controls="collapsePelanggan">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'users']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                            <span>Pelanggan</span>
                        </a>
                        <div id="collapsePelanggan" class="collapse <?php echo e(request()->is('admin/customers*') ? 'show' : ''); ?>" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Buku Klien:</h6>
                                <a class="collapse-item <?php echo e(request()->is('admin/customers/retail*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/customers/retail')); ?>">Pelanggan Retail</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/customers/corporate*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/customers/corporate')); ?>">Mitra Perusahaan B2B</a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider my-2">

                    <!-- 4. KEUANGAN -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('admin/finance*') || request()->is('admin/escrow*') ? '' : 'collapsed'); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKeuangan" aria-expanded="<?php echo e(request()->is('admin/finance*') || request()->is('admin/escrow*') ? 'true' : 'false'); ?>" aria-controls="collapseKeuangan">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'wallet']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'wallet']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                            <span>Keuangan</span>
                        </a>
                        <div id="collapseKeuangan" class="collapse <?php echo e(request()->is('admin/finance*') || request()->is('admin/escrow*') ? 'show' : ''); ?>" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Arus Kas & Transaksi:</h6>
                                <a class="collapse-item <?php echo e(request()->is('admin/finance/escrow*') || request()->is('admin/escrow*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/finance/escrow')); ?>">Rekening Bersama</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/finance/invoices*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/finance/invoices')); ?>">Faktur & Penagihan</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/finance/reports*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/finance/reports')); ?>">Pusat Laporan & Pajak</a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider my-2">

                    <!-- 5. LOGISTIK -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('admin/logistics*') ? '' : 'collapsed'); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLogistik" aria-expanded="<?php echo e(request()->is('admin/logistics*') ? 'true' : 'false'); ?>" aria-controls="collapseLogistik">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'boxes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'boxes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                            <span>Logistik</span>
                        </a>
                        <div id="collapseLogistik" class="collapse <?php echo e(request()->is('admin/logistics*') ? 'show' : ''); ?>" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Master Wilayah & Tarif:</h6>
                                <a class="collapse-item <?php echo e(request()->is('admin/logistics/tariffs*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/logistics/tariffs')); ?>">Tarif & Rute Ekspedisi</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/logistics/ports*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/logistics/ports')); ?>">Pelabuhan & Depo</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/logistics/hscode*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/logistics/hscode')); ?>">Kamus Barang & Cukai</a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider my-2">

                    <!-- 6. SISTEM -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('admin/staff*') || request()->is('admin/gateways*') || request()->is('admin/ai-service*') || request()->is('admin/audit*') ? '' : 'collapsed'); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSistem" aria-expanded="<?php echo e(request()->is('admin/staff*') || request()->is('admin/gateways*') || request()->is('admin/ai-service*') || request()->is('admin/audit*') ? 'true' : 'false'); ?>" aria-controls="collapseSistem">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'sliders-horizontal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'sliders-horizontal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                            <span>Sistem</span>
                        </a>
                        <div id="collapseSistem" class="collapse <?php echo e(request()->is('admin/staff*') || request()->is('admin/gateways*') || request()->is('admin/ai-service*') || request()->is('admin/audit*') ? 'show' : ''); ?>" data-bs-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <h6 class="collapse-header">Infrastruktur & Tim:</h6>
                                <a class="collapse-item <?php echo e(request()->is('admin/staff*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/staff')); ?>">Kelola Staf & Hak Akses</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/gateways*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/gateways')); ?>">Gerbang Pesan & Email</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/ai-service*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/ai-service')); ?>">Pengaturan Mesin AI</a>
                                <a class="collapse-item <?php echo e(request()->is('admin/audit*') ? 'active' : ''); ?>" href="<?php echo e(url('/admin/audit')); ?>">Catatan Aktivitas</a>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Sidebar Toggler -->
                <div class="text-center d-none d-md-inline mt-3">
                    <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
                </div>
            </div>
        </nav>

        <!-- CONTENT WRAPPER -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <!-- TOPBAR NAVBAR -->
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none me-3 rounded-circle text-primary" id="sidebarToggleTop" type="button">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'menu','size' => '1.25rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'menu','size' => '1.25rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                        </button>

                        <!-- Topbar Page Title & Navigation Dropdown -->
                        <div class="d-flex align-items-center me-auto">
                            <?php if(request()->is('admin') || request()->is('/') || request()->is('admin/dashboard*')): ?>
                                <?php
                                    $currentScope = request()->get('scope', 'domestik');
                                    $currentLabel = ($currentScope === 'internasional') ? 'Internasional' : 'Domestik';
                                ?>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 border shadow-sm rounded-3 bg-white fw-bold text-dark" type="button" id="dashboardDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.95rem;">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'layout-dashboard','size' => '1.15rem','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'layout-dashboard','size' => '1.15rem','class' => 'text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                        <span>Dashboard <span class="text-muted fw-normal">&rsaquo;</span> <span class="text-primary"><?php echo e($currentLabel); ?></span></span>
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 py-1 mt-1 animated--fade-in" aria-labelledby="dashboardDropdown" style="min-width: 200px;">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 <?php echo e($currentScope !== 'internasional' ? 'active bg-primary text-white fw-bold' : 'text-dark'); ?>" href="<?php echo e(url('/admin?scope=domestik')); ?>">
                                                <span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'map-pin','size' => '1rem','class' => 'me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'map-pin','size' => '1rem','class' => 'me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Domestik</span>
                                                <?php if($currentScope !== 'internasional'): ?> <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.9rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.9rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php endif; ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 <?php echo e($currentScope === 'internasional' ? 'active bg-primary text-white fw-bold' : 'text-dark'); ?>" href="<?php echo e(url('/admin?scope=internasional')); ?>">
                                                <span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'globe','size' => '1rem','class' => 'me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'globe','size' => '1rem','class' => 'me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Internasional</span>
                                                <?php if($currentScope === 'internasional'): ?> <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.9rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.9rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php endif; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <?php
                                    $autoTitle = 'Large Language Models';
                                    if (request()->is('admin/bookings*')) $autoTitle = 'Daftar Booking & Pesanan Pengiriman';
                                    elseif (request()->is('admin/fleets*')) $autoTitle = 'Pelacakan Armada & Manifes Muatan';
                                    elseif (request()->is('admin/operators*')) $autoTitle = 'Tata Kelola Operator Regional Hub';
                                    elseif (request()->is('admin/escalations*')) $autoTitle = 'Pusat Darurat & Kendala Lapangan';
                                    elseif (request()->is('admin/customers/retail*')) $autoTitle = 'Buku Klien Pelanggan Retail';
                                    elseif (request()->is('admin/customers/corporate*')) $autoTitle = 'Mitra Perusahaan Logistik B2B';
                                    elseif (request()->is('admin/finance/escrow*') || request()->is('admin/escrow*')) $autoTitle = 'Rekening Bersama (Escrow Vault)';
                                    elseif (request()->is('admin/finance/invoices*')) $autoTitle = 'Faktur & Penagihan';
                                    elseif (request()->is('admin/finance/reports*')) $autoTitle = 'Pusat Laporan & Rekonsiliasi Pajak';
                                    elseif (request()->is('admin/logistics/tariffs*')) $autoTitle = 'Tarif & Rute Ekspedisi';
                                    elseif (request()->is('admin/logistics/ports*')) $autoTitle = 'Pelabuhan & Depo Petikemas';
                                    elseif (request()->is('admin/logistics/hscode*')) $autoTitle = 'Kamus Barang & Cukai (HS Code)';
                                    elseif (request()->is('admin/staff*')) $autoTitle = 'Kelola Staf & Hak Akses';
                                    elseif (request()->is('admin/gateways*')) $autoTitle = 'Gerbang Pesan & Notifikasi';
                                    elseif (request()->is('admin/ai-service*')) $autoTitle = 'Large Language Models';
                                    elseif (request()->is('admin/audit*')) $autoTitle = 'Catatan Aktivitas & Audit Forensik';
                                ?>
                                <h4 class="text-dark mb-0 fw-bold" style="font-size: 1.35rem; font-weight: 700; letter-spacing: -0.025em; color: #1e293b;">
                                    <?php echo $__env->yieldContent('page_title', $autoTitle); ?>
                                </h4>
                            <?php endif; ?>
                        </div>

                        <!-- Topbar Right Items -->
                        <ul class="navbar-nav flex-nowrap ms-auto align-items-center">
                            <!-- Alerts / Notifications -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'bell','size' => '1.2rem','class' => 'text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bell','size' => '1.2rem','class' => 'text-gray-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                    <span class="badge bg-danger badge-counter">2</span>
                                </a>
                                <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header bg-primary">
                                        Pusat Notifikasi Darurat
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="me-3">
                                            <div class="bg-danger icon-circle text-white p-2 rounded-circle">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert-triangle','size' => '1rem','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert-triangle','size' => '1rem','class' => 'text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">Baru Saja · Hub Tj. Perak</div>
                                            <span class="font-weight-bold">Armada SRA-B12 butuh approval biaya Tugboat Rp 35jt (Badai).</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="me-3">
                                            <div class="bg-warning icon-circle text-white p-2 rounded-circle">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','size' => '1rem','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','size' => '1rem','class' => 'text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">10 Menit lalu · SLA Warning</div>
                                            <span>SLA WhatsApp di Hub Priok melewati 15 menit tanpa respons.</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Lihat Semua Alert</a>
                                </div>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- User Information: Private Developer/Internal IP Node Indicator -->
                            <li class="nav-item d-flex align-items-center">
                                <div class="d-flex align-items-center gap-2 px-2 py-1 bg-light rounded-pill border">
                                    <span class="text-dark small fw-bold px-1" style="font-size: 0.82rem; letter-spacing: -0.01em;">
                                        Superadmin
                                    </span>
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 28px; height: 28px;" title="Private Subnet Network Node (Developer IP Access Only)">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'globe','size' => '1rem','class' => 'text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'globe','size' => '1rem','class' => 'text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- PAGE BODY CONTENT -->
                <div class="container-fluid pb-4">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>

        <!-- Scroll to Top Button-->
        <a class="border rounded d-inline scroll-to-top" href="#page-top">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'chevron-up','size' => '1.1rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'chevron-up','size' => '1.1rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
        </a>
    </div>

    <!-- Global SoraBot AI Copilot Widget (Tersedia di Seluruh Halaman) -->
    <?php echo $__env->make('partials.ai-copilot', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <!-- Template Custom Script -->
    <script src="<?php echo e(asset('assets/js/script.min.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/layouts/app.blade.php ENDPATH**/ ?>