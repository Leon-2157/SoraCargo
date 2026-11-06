<?php $__env->startSection('title', 'Daftar Booking & Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header & Actions -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Daftar Booking & Pesanan Pengiriman</h3>
            <span class="badge bg-primary-subtle text-primary border border-primary fw-semibold px-2 py-1">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'package','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'package','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Logistik Masuk
            </span>
        </div>
        <p class="text-muted small mb-0">Monitoring seluruh order masuk dari shipper retail dan corporate B2B sebelum armada diberangkatkan.</p>
    </div>
    <div class="mt-3 mt-sm-0">
        <button class="btn btn-primary btn-sm shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#createBookingModal">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'plus','size' => '0.9rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plus','size' => '0.9rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> + Buat Booking Manual
        </button>
    </div>
</div>

<!-- Flash Notifications -->
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check-circle','class' => 'me-2 text-success flex-shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check-circle','class' => 'me-2 text-success flex-shrink-0']); ?>
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
            <div><?php echo e(session('success')); ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert-circle','class' => 'me-2 text-danger flex-shrink-0 mt-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert-circle','class' => 'me-2 text-danger flex-shrink-0 mt-1']); ?>
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
            <div>
                <strong>Validasi Gagal:</strong>
                <ul class="mb-0 ps-3 mt-1 small">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Radar KPI Summary Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: Total Bookings -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-primary shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Booking Aktif</div>
                        <div class="text-dark fw-bold h4 mb-0"><?php echo e($totalBookingsCount); ?> Pesanan</div>
                        <div class="text-muted text-xs mt-1">
                            Retail LCL &amp; B2B Kontainer
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-primary-subtle p-3 rounded-circle text-primary">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'package','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'package','size' => '1.5rem']); ?>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Cargo Weight -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-success shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Tonase Muatan Kargo</div>
                        <div class="text-dark fw-bold h4 mb-0"><?php echo e(number_format($totalWeightKg / 1000, 1, ',', '.')); ?> Ton</div>
                        <div class="text-muted text-xs mt-1">
                            Total: <?php echo e(number_format($totalWeightKg, 0, ',', '.')); ?> kg terdaftar
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-success-subtle p-3 rounded-circle text-success">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'boxes','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'boxes','size' => '1.5rem']); ?>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Volume (CBM) -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-warning shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Kubikasi Petikemas</div>
                        <div class="text-dark fw-bold h4 mb-0"><?php echo e(number_format($totalVolumeCbm, 1, ',', '.')); ?> CBM</div>
                        <div class="text-muted text-xs mt-1">
                            Ruang kapal &amp; CY Depo terpakai
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-warning-subtle p-3 rounded-circle text-warning">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'ship','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ship','size' => '1.5rem']); ?>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Protected Escrow Funds -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-4 border-info shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-info fw-bold text-xs mb-1">Saldo Dana Escrow</div>
                        <div class="text-dark fw-bold h4 mb-0">Rp <?php echo e(number_format($totalEscrowProtected, 0, ',', '.')); ?></div>
                        <div class="text-muted text-xs mt-1">
                            <span class="text-success fw-semibold">100% Dijamin:</span> Rekening penampung
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-info-subtle p-3 rounded-circle text-info">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'vault','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'vault','size' => '1.5rem']); ?>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card: Cargo Bookings Register -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="text-primary m-0 fw-bold">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'calendar-check','class' => 'me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'calendar-check','class' => 'me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Daftar Pesanan &amp; Surat Jalan Kargo
        </h6>
        <span class="badge bg-light text-primary border">Total <?php echo e($totalBookingsCount); ?> Pesanan Terdata</span>
    </div>

    <div class="card-body">
        <!-- In-Page Tab Filters (Semua, Retail LCL, Corporate FCL, Charter Truk) -->
        <ul class="nav nav-pills mb-3 border-bottom pb-2" id="bookingTab">
            <li class="nav-item me-1">
                <a class="nav-link <?php echo e(empty($type) ? 'active' : ''); ?> py-1 px-3 small fw-bold" href="<?php echo e(route('admin.bookings.index', array_filter(['status' => $status, 'channel' => $channel, 'search' => $search]))); ?>">
                    Semua Booking (<?php echo e($totalBookingsCount); ?>)
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link <?php echo e($type === 'RETAIL_LCL' ? 'active' : ''); ?> py-1 px-3 small fw-bold" href="<?php echo e(route('admin.bookings.index', array_filter(['type' => 'RETAIL_LCL', 'status' => $status, 'channel' => $channel, 'search' => $search]))); ?>">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'user','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Retail LCL (<?php echo e($retailCount); ?>)
                </a>
            </li>
            <li class="nav-item me-1">
                <a class="nav-link <?php echo e($type === 'CORPORATE_FCL' ? 'active' : ''); ?> py-1 px-3 small fw-bold" href="<?php echo e(route('admin.bookings.index', array_filter(['type' => 'CORPORATE_FCL', 'status' => $status, 'channel' => $channel, 'search' => $search]))); ?>">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'building-2','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'building-2','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Corporate FCL (<?php echo e($corporateCount); ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($type === 'CHARTER_TRUCK' ? 'active' : ''); ?> py-1 px-3 small fw-bold" href="<?php echo e(route('admin.bookings.index', array_filter(['type' => 'CHARTER_TRUCK', 'status' => $status, 'channel' => $channel, 'search' => $search]))); ?>">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'truck','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'truck','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Charter Truk (<?php echo e($charterCount); ?>)
                </a>
            </li>
        </ul>

        <!-- Filter & Search Controls Form -->
        <form method="GET" action="<?php echo e(route('admin.bookings.index')); ?>" class="row mb-3 g-2">
            <?php if(!empty($type)): ?>
                <input type="hidden" name="type" value="<?php echo e($type); ?>">
            <?php endif; ?>
            <div class="col-md-3 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Status:</label>
                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" <?php echo e(empty($status) || $status === 'all' ? 'selected' : ''); ?>>Semua Status</option>
                        <option value="BOOKED" <?php echo e($status === 'BOOKED' ? 'selected' : ''); ?>>BOOKED (Terdaftar)</option>
                        <option value="GATE_IN" <?php echo e($status === 'GATE_IN' ? 'selected' : ''); ?>>GATE_IN (Depo CY)</option>
                        <option value="CUSTOMS_INSPECTION" <?php echo e($status === 'CUSTOMS_INSPECTION' ? 'selected' : ''); ?>>CUSTOMS_INSPECTION (Cukai)</option>
                        <option value="SAILING" <?php echo e($status === 'SAILING' ? 'selected' : ''); ?>>SAILING (Berlayar)</option>
                        <option value="DELIVERED" <?php echo e($status === 'DELIVERED' ? 'selected' : ''); ?>>DELIVERED (Terkirim)</option>
                        <option value="WEATHER_HOLD" <?php echo e($status === 'WEATHER_HOLD' ? 'selected' : ''); ?>>WEATHER_HOLD (Tahan Cuaca)</option>
                        <option value="CLAIM_HOLD" <?php echo e($status === 'CLAIM_HOLD' ? 'selected' : ''); ?>>CLAIM_HOLD (Klaim Rusak)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 text-nowrap">
                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0 small text-muted">Bea Cukai:</label>
                    <select name="channel" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="all" <?php echo e(empty($channel) || $channel === 'all' ? 'selected' : ''); ?>>Semua Jalur</option>
                        <option value="GREEN_CHANNEL" <?php echo e($channel === 'GREEN_CHANNEL' ? 'selected' : ''); ?>>Jalur Hijau</option>
                        <option value="YELLOW_CHANNEL" <?php echo e($channel === 'YELLOW_CHANNEL' ? 'selected' : ''); ?>>Jalur Kuning</option>
                        <option value="RED_CHANNEL" <?php echo e($channel === 'RED_CHANNEL' ? 'selected' : ''); ?>>Jalur Merah (DG)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <input type="search" name="search" class="form-control" placeholder="Cari resi, nama pengirim, atau nama perusahaan..." value="<?php echo e($search); ?>">
                    <button class="btn btn-outline-secondary" type="submit">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'search']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'search']); ?>
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
                    <?php if(!empty($search) || (!empty($status) && $status !== 'all') || (!empty($channel) && $channel !== 'all')): ?>
                        <a href="<?php echo e(route('admin.bookings.index', array_filter(['type' => $type]))); ?>" class="btn btn-outline-danger" title="Reset Filter">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'x']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'x']); ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle my-0" id="bookingsTable">
                <thead class="table-light">
                    <tr>
                        <th>No. Resi &amp; Layanan</th>
                        <th>Shipper / Pengirim</th>
                        <th>Rute &amp; Moda</th>
                        <th>Muatan &amp; HS Code</th>
                        <th>Jalur Cukai</th>
                        <th>Status Kargo</th>
                        <th>Escrow Ledger</th>
                        <th class="text-center">Aksi Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $route = $item->route;
                            $shipper = $item->shipper;
                            $company = $item->company;
                            $escrow = $item->escrowLedger;
                        ?>
                        <tr>
                            <!-- 1. Resi & Layanan -->
                            <td>
                                <a href="javascript:void(0)" onclick="openTrackingModal('<?php echo e($item->id); ?>', '<?php echo e($item->tracking_number); ?>')" class="fw-bold font-monospace text-primary text-decoration-none" title="Buka Riwayat Pelacakan GPS & Checkpoint">
                                    <?php echo e($item->tracking_number); ?>

                                </a>
                                <div class="mt-1">
                                    <?php if($item->booking_type === 'RETAIL_LCL'): ?>
                                        <span class="badge badge-retail">RETAIL_LCL</span>
                                    <?php elseif($item->booking_type === 'CORPORATE_FCL'): ?>
                                        <span class="badge badge-b2b">CORPORATE_FCL</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-white">CHARTER_TRUCK</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-muted text-xs mt-1">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','size' => '0.75rem','class' => 'me-1']); ?>
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
                                    <?php echo e($item->created_at ? $item->created_at->format('d/m/Y H:i') : '-'); ?>

                                </div>
                            </td>

                            <!-- 2. Shipper / Pengirim -->
                            <td>
                                <div class="fw-semibold text-dark"><?php echo e($shipper ? $shipper->name : '-'); ?></div>
                                <?php if($company): ?>
                                    <div class="text-primary small fw-bold"><?php echo e($company->company_name); ?></div>
                                <?php endif; ?>
                                <div class="text-muted text-xs"><?php echo e($shipper ? $shipper->phone : '-'); ?></div>
                            </td>

                            <!-- 3. Rute & Moda -->
                            <td>
                                <?php if($route): ?>
                                    <div>
                                        <span class="badge bg-light text-dark border">
                                            <?php echo e($route->origin_port_id); ?> &rarr; <?php echo e($route->destination_port_id); ?>

                                        </span>
                                    </div>
                                    <div class="text-muted text-xs mt-1">
                                        <?php if($route->transport_mode === 'SEA_RORO'): ?>
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'ship','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ship','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kapal RORO (Nusantara)
                                        <?php elseif($route->transport_mode === 'SEA_CONTAINER'): ?>
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'ship','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ship','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kapal Kontainer FCL
                                        <?php else: ?>
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'truck','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'truck','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Ekspedisi Truk Darat
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <!-- 4. Muatan & HS Code -->
                            <td>
                                <div class="fw-bold text-dark font-monospace small">
                                    <?php echo e(number_format($item->total_weight_kg, 0, ',', '.')); ?> kg / <?php echo e($item->total_volume_cbm); ?> CBM
                                </div>
                                <div class="mt-1">
                                    <?php if($item->cargo_type === 'DANGEROUS_GOODS'): ?>
                                        <span class="badge bg-danger text-white">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert-triangle','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert-triangle','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> DG Class 3
                                        </span>
                                    <?php elseif($item->cargo_type === 'REEFER_PERISHABLE'): ?>
                                        <span class="badge bg-info text-white">Kargo Dingin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary text-white">General Cargo</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-muted text-xs font-monospace mt-1">
                                    HS: <?php echo e($item->hs_code ?? '0901.11.10'); ?>

                                </div>
                            </td>

                            <!-- 5. Jalur Cukai -->
                            <td>
                                <?php if($item->customs_channel === 'GREEN_CHANNEL'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-check','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-check','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Jalur Hijau
                                    </span>
                                <?php elseif($item->customs_channel === 'YELLOW_CHANNEL'): ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file-text','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file-text','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Jalur Kuning
                                    </span>
                                <?php elseif($item->customs_channel === 'RED_CHANNEL'): ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert-triangle','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert-triangle','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Jalur Merah
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>

                            <!-- 6. Status Kargo -->
                            <td>
                                <?php if($item->cargo_status === 'BOOKED'): ?>
                                    <span class="badge bg-primary">BOOKED</span>
                                <?php elseif($item->cargo_status === 'GATE_IN'): ?>
                                    <span class="badge bg-info text-white">GATE_IN</span>
                                <?php elseif($item->cargo_status === 'CUSTOMS_INSPECTION'): ?>
                                    <span class="badge bg-warning text-dark">INSPECTION</span>
                                <?php elseif($item->cargo_status === 'SAILING'): ?>
                                    <span class="badge badge-domestic">SAILING</span>
                                <?php elseif($item->cargo_status === 'DELIVERED'): ?>
                                    <span class="badge badge-active">DELIVERED</span>
                                <?php elseif($item->cargo_status === 'WEATHER_HOLD'): ?>
                                    <span class="badge bg-danger text-white">WEATHER_HOLD</span>
                                <?php elseif($item->cargo_status === 'CLAIM_HOLD'): ?>
                                    <span class="badge badge-suspended">CLAIM_HOLD</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo e($item->cargo_status); ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- 7. Rekening Escrow -->
                            <td>
                                <?php if($escrow): ?>
                                    <div class="fw-bold text-dark font-monospace small">
                                        Rp <?php echo e(number_format($escrow->total_paid_amount, 0, ',', '.')); ?>

                                    </div>
                                    <div class="mt-1">
                                        <?php if($escrow->escrow_status === 'HELD_IN_ESCROW'): ?>
                                            <span class="badge bg-secondary">Tertampung 100%</span>
                                        <?php elseif($escrow->escrow_status === 'PARTIALLY_RELEASED'): ?>
                                            <span class="badge bg-primary">Tahap Cair</span>
                                        <?php elseif($escrow->escrow_status === 'FULLY_SETTLED'): ?>
                                            <span class="badge bg-success">Lunas Tuntas</span>
                                        <?php elseif($escrow->escrow_status === 'DISPUTE_FROZEN'): ?>
                                            <span class="badge bg-danger">Dibekukan</span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted text-xs">Belum Ada Escrow</span>
                                <?php endif; ?>
                            </td>

                            <!-- 8. Aksi Kelola Status & Lacak -->
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" type="button"
                                        onclick="openTrackingModal('<?php echo e($item->id); ?>', '<?php echo e($item->tracking_number); ?>')"
                                        title="Buka Riwayat Checkpoint & GPS Tracking">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'map-pin','size' => '0.8rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'map-pin','size' => '0.8rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Lacak
                                    </button>
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="openStatusModal('<?php echo e($item->id); ?>', '<?php echo e($item->tracking_number); ?>', '<?php echo e($item->cargo_status); ?>')"
                                        title="Ubah Status Kargo & Escrow">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'sliders-horizontal','size' => '0.8rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'sliders-horizontal','size' => '0.8rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Status
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'package','size' => '2.5rem','class' => 'mb-2 text-secondary opacity-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'package','size' => '2.5rem','class' => 'mb-2 text-secondary opacity-50']); ?>
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
                                    <div class="fw-bold">Tidak ada data pesanan booking ditemukan</div>
                                    <div class="small">Silakan ubah filter kategori atau kata kunci pencarian Anda.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="row mt-4 align-items-center">
            <div class="col-md-6">
                <p class="text-muted small mb-0">
                    Menampilkan <?php echo e($bookings->firstItem() ?? 0); ?> sampai <?php echo e($bookings->lastItem() ?? 0); ?> dari <?php echo e($bookings->total()); ?> pesanan kargo
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-md-end mt-2 mt-md-0">
                <?php echo e($bookings->links()); ?>

            </div>
        </div>
    </div>
</div>

<!-- MODAL 1: UPDATE CARGO STATUS -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="statusModalLabel">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'sliders-horizontal','class' => 'me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'sliders-horizontal','class' => 'me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Perbarui Status Kargo: <span id="modalTrackingTitle" class="font-monospace"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'info','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'info','class' => 'me-1']); ?>
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
                        Perubahan status operasional akan secara otomatis memicu pelepasan bertahap (*milestone release*) dana rekening bersama Escrow kepada operator pelayaran.
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Status Kargo Operasional</label>
                        <select name="cargo_status" id="modalStatusSelect" class="form-select form-select-sm" required>
                            <option value="BOOKED">BOOKED (Pesanan Terdaftar)</option>
                            <option value="GATE_IN">GATE_IN (Kargo Masuk Depo / CY) &rarr; Rilis 30% Escrow</option>
                            <option value="CUSTOMS_INSPECTION">CUSTOMS_INSPECTION (Pemeriksaan Bea Cukai)</option>
                            <option value="SAILING">SAILING (Kapal/Truk Berlayar) &rarr; Rilis 40% Escrow</option>
                            <option value="DELIVERED">DELIVERED (Muatan Diterima Konsumen) &rarr; Rilis 30% Selesai</option>
                            <option value="WEATHER_HOLD">WEATHER_HOLD (Tahan Cuaca Buruk BMKG)</option>
                            <option value="CLAIM_HOLD">CLAIM_HOLD (Bekukan Kasus Klaim Kerusakan)</option>
                            <option value="CANCELLED">CANCELLED (Batalkan Pengiriman)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check-circle','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check-circle','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Simpan Status Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: CREATE MANUAL BOOKING -->
<div class="modal fade" id="createBookingModal" tabindex="-1" aria-labelledby="createBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="createBookingModalLabel">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'plus','class' => 'me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plus','class' => 'me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>Buat Pesanan Kargo Baru (Manual Dispatch)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.bookings.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="alert alert-info small py-2 mb-3">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'info','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'info','class' => 'me-1']); ?>
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
                        Formulir ini digunakan Superadmin untuk menginput order offline dari shipper korporat/retail dan langsung mengalokasikan akun penampung dana Escrow 3-tahap.
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Shipper Selection -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Shipper / Pelanggan Pengirim <span class="text-danger">*</span></label>
                            <select name="shipper_id" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Klien Terdaftar --</option>
                                <?php $__currentLoopData = $shippers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($shp->id); ?>">
                                        <?php echo e($shp->name); ?> (<?php echo e($shp->email); ?>) [<?php echo e($shp->user_type); ?>]
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Route Selection -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Rute Pengiriman Pelabuhan <span class="text-danger">*</span></label>
                            <select name="route_id" class="form-select form-select-sm" required>
                                <option value="" disabled selected>-- Pilih Rute Ekspedisi --</option>
                                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($rt->id); ?>">
                                        <?php echo e($rt->originPort->name); ?> (<?php echo e($rt->origin_port_id); ?>) &rarr; <?php echo e($rt->destinationPort->name); ?> (<?php echo e($rt->destination_port_id); ?>) [<?php echo e($rt->transport_mode); ?>]
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Booking Type -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tipe Booking <span class="text-danger">*</span></label>
                            <select name="booking_type" class="form-select form-select-sm" required>
                                <option value="RETAIL_LCL">RETAIL_LCL (Konsolidasi Muatan)</option>
                                <option value="CORPORATE_FCL">CORPORATE_FCL (Petikemas Penuh)</option>
                                <option value="CHARTER_TRUCK">CHARTER_TRUCK (Carter Truk Darat)</option>
                            </select>
                        </div>

                        <!-- Cargo Type -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kategori Kargo <span class="text-danger">*</span></label>
                            <select name="cargo_type" class="form-select form-select-sm" required>
                                <option value="GENERAL_CARGO">GENERAL_CARGO (Umum)</option>
                                <option value="DANGEROUS_GOODS">DANGEROUS_GOODS (DG Class 3)</option>
                                <option value="REEFER_PERISHABLE">REEFER_PERISHABLE (Kargo Dingin)</option>
                            </select>
                        </div>

                        <!-- HS Code -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kamus HS Code Bea Cukai</label>
                            <select name="hs_code" class="form-select form-select-sm">
                                <option value="">-- Pilih HS Code --</option>
                                <?php $__currentLoopData = $hsCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($hs->code); ?>">
                                        <?php echo e($hs->code); ?> - <?php echo e(Str::limit($hs->description_id, 30)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Weight -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Bobot (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_weight_kg" class="form-control form-control-sm" placeholder="Contoh: 1500" required>
                        </div>

                        <!-- Volume -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Total Volume (CBM) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="total_volume_cbm" class="form-control form-control-sm" placeholder="Contoh: 4.5" required>
                        </div>

                        <!-- Declared Value -->
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Nilai Deklarasi Barang (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="1000" name="declared_goods_value" class="form-control form-control-sm" placeholder="Contoh: 50000000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Petugas Operator Regional Hub Penanggung Jawab</label>
                        <select name="assigned_operator_id" class="form-select form-select-sm">
                            <option value="">-- Tetapkan Operator Lapangan (Opsional) --</option>
                            <?php $__currentLoopData = $operators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($op->id); ?>">
                                    <?php echo e($op->user->name); ?> (<?php echo e($op->employee_id); ?>) - <?php echo e($op->hub ? $op->hub->name : '-'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'plus','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plus','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Terbitkan Booking &amp; Buat Escrow
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: TIMELINE PELACAKAN MILESTONE & GPS CHECKPOINT (ops.tracking_events) -->
<div class="modal fade" id="trackingEventsModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'map-pin','size' => '1.25rem','class' => 'text-info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'map-pin','size' => '1.25rem','class' => 'text-info']); ?>
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
                    <div>
                        <h6 class="modal-title fw-bold mb-0" id="trackingModalLabel">
                            Riwayat Pelacakan &amp; GPS Checkpoint
                        </h6>
                        <span id="trackModalNo" class="font-monospace small text-info"></span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span id="trackModalStatusBadge" class="badge"></span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <!-- Ringkasan Rute & Muatan -->
                <div class="card border-0 bg-light mb-4 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row g-3 align-items-center text-xs">
                            <div class="col-md-4">
                                <div class="text-muted text-uppercase fw-semibold">Shipper / Pengirim</div>
                                <div id="trackShipper" class="fw-bold text-dark text-truncate mt-1">-</div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-muted text-uppercase fw-semibold">Rute Pelayaran / Ekspedisi</div>
                                <div class="fw-bold text-primary mt-1">
                                    <span id="trackOrigin">-</span> &rarr; <span id="trackDestination">-</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-muted text-uppercase fw-semibold">Bobot &amp; Volume</div>
                                <div id="trackSpecs" class="fw-bold text-dark mt-1">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Container -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'activity','size' => '1rem','class' => 'me-1 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'activity','size' => '1rem','class' => 'me-1 text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Jejak Riwayat Milestone Lapangan
                        </h6>
                        <span id="trackEventCount" class="badge bg-secondary">0 Checkpoint</span>
                    </div>

                    <div id="trackingTimelineLoading" class="text-center py-4">
                        <span class="spinner-border text-primary" style="width: 2rem; height: 2rem;"></span>
                        <div class="small text-muted mt-2">Memuat jejak koordinat dari database...</div>
                    </div>

                    <div id="trackingTimelineContent" class="tracking-timeline" style="display: none;">
                        <!-- Injected via JavaScript -->
                    </div>

                    <div id="trackingTimelineEmpty" class="text-center py-4 bg-light rounded border" style="display: none;">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'navigation','size' => '2rem','class' => 'text-muted opacity-50 mb-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'navigation','size' => '2rem','class' => 'text-muted opacity-50 mb-2']); ?>
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
                        <div class="fw-semibold text-dark small">Belum ada rekaman checkpoint GPS untuk resi ini</div>
                        <div class="text-muted text-xs">Gunakan form di bawah untuk mencatat milestone pertama.</div>
                    </div>
                </div>

                <!-- Form Tambah Checkpoint Baru -->
                <div class="card border-primary-subtle shadow-sm">
                    <div class="card-header bg-white py-2 px-3 border-bottom d-flex justify-content-between align-items-center cursor-pointer"
                        data-bs-toggle="collapse" data-bs-target="#collapseAddCheckpoint" aria-expanded="false" style="cursor: pointer;">
                        <div class="fw-bold text-primary small">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'plus-circle','size' => '0.9rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plus-circle','size' => '0.9rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Catat Checkpoint Lapangan Baru
                        </div>
                        <span class="text-muted text-xs">Klik untuk buka/tutup form &rsaquo;</span>
                    </div>
                    <div id="collapseAddCheckpoint" class="collapse">
                        <div class="card-body p-3">
                            <form id="addCheckpointForm">
                                <div class="mb-2">
                                    <label class="form-label text-xs fw-bold">Nama Checkpoint / Aktivitas Lapangan <span class="text-danger">*</span></label>
                                    <input type="text" id="cpEventName" class="form-control form-control-sm" placeholder="Contoh: Petikemas Masuk CY Dermaga Priok / Selesai Pemeriksaan Fisik Bea Cukai" required>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label text-xs fw-bold">Status Kargo Terkait</label>
                                        <select id="cpStatus" class="form-select form-select-sm">
                                            <option value="GATE_IN">GATE_IN (Masuk Depo/Dermaga)</option>
                                            <option value="CUSTOMS_INSPECTION">CUSTOMS_INSPECTION (Pemeriksaan Cukai)</option>
                                            <option value="SAILING">SAILING (Armada Berlayar)</option>
                                            <option value="DELIVERED">DELIVERED (Tiba di Tujuan)</option>
                                            <option value="WEATHER_HOLD">WEATHER_HOLD (Ditahan Cuaca)</option>
                                            <option value="CLAIM_HOLD">CLAIM_HOLD (Ditahan Klaim)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-xs fw-bold">Latitude (GPS)</label>
                                        <input type="number" step="0.000001" id="cpLatitude" class="form-control form-control-sm" placeholder="-6.1033">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-xs fw-bold">Longitude (GPS)</label>
                                        <input type="number" step="0.000001" id="cpLongitude" class="form-control form-control-sm" placeholder="106.8828">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" id="btnSubmitCheckpoint" class="btn btn-sm btn-primary">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Simpan Checkpoint ke Database
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.tracking-timeline {
    position: relative;
    padding-left: 28px;
    margin-left: 10px;
}
.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 8px;
    bottom: 8px;
    width: 2px;
    background: #e2e8f0;
}
.timeline-item {
    position: relative;
    padding-bottom: 24px;
}
.timeline-item:last-child {
    padding-bottom: 0;
}
.timeline-dot {
    position: absolute;
    left: -28px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #94a3b8;
    border: 3px solid #fff;
    box-shadow: 0 0 0 1px #cbd5e1;
}
.timeline-item.active .timeline-dot {
    background: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.25);
    animation: pulseDot 2s infinite;
}
@keyframes pulseDot {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script>
let currentActiveBookingId = null;

function openStatusModal(id, trackingNo, currentStatus) {
    document.getElementById('modalTrackingTitle').innerText = trackingNo;
    document.getElementById('modalStatusSelect').value = currentStatus;
    document.getElementById('updateStatusForm').action = '/admin/bookings/' + id + '/status';

    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

function openTrackingModal(bookingId, trackingNo) {
    currentActiveBookingId = bookingId;
    document.getElementById('trackModalNo').innerText = trackingNo;
    document.getElementById('trackingTimelineLoading').style.display = 'block';
    document.getElementById('trackingTimelineContent').style.display = 'none';
    document.getElementById('trackingTimelineEmpty').style.display = 'none';

    const modalEl = document.getElementById('trackingEventsModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();

    fetch('/admin/bookings/' + bookingId + '/tracking')
        .then(res => res.json())
        .then(data => {
            document.getElementById('trackingTimelineLoading').style.display = 'none';
            if (data.success && data.booking) {
                const b = data.booking;
                document.getElementById('trackShipper').innerText = b.shipper_name || '-';
                document.getElementById('trackOrigin').innerText = b.origin || '-';
                document.getElementById('trackDestination').innerText = b.destination || '-';
                document.getElementById('trackSpecs').innerText = Number(b.weight).toLocaleString('id-ID') + ' kg / ' + Number(b.volume).toLocaleString('id-ID') + ' CBM';

                // Status badge
                const badge = document.getElementById('trackModalStatusBadge');
                badge.innerText = b.cargo_status;
                badge.className = 'badge ' + (b.cargo_status === 'SAILING' ? 'bg-primary' : (b.cargo_status === 'DELIVERED' ? 'bg-success' : 'bg-info'));

                const events = data.events || [];
                document.getElementById('trackEventCount').innerText = events.length + ' Checkpoint';

                if (events.length > 0) {
                    renderTimeline(events);
                    document.getElementById('trackingTimelineContent').style.display = 'block';
                } else {
                    document.getElementById('trackingTimelineEmpty').style.display = 'block';
                }
            }
        })
        .catch(() => {
            document.getElementById('trackingTimelineLoading').style.display = 'none';
            document.getElementById('trackingTimelineEmpty').style.display = 'block';
        });
}

function renderTimeline(events) {
    const container = document.getElementById('trackingTimelineContent');
    let html = '';

    events.forEach((ev, idx) => {
        const isActive = idx === 0; // Paling atas adalah event terbaru
        const statusBadgeClass = ev.current_status === 'SAILING' ? 'bg-primary-subtle text-primary border border-primary' :
            (ev.current_status === 'DELIVERED' ? 'bg-success-subtle text-success border border-success' :
            (ev.current_status === 'WEATHER_HOLD' ? 'bg-danger-subtle text-danger border border-danger' : 'bg-light text-dark border'));

        let gpsHtml = '';
        if (ev.latitude && ev.longitude) {
            gpsHtml = `
                <a href="https://www.openstreetmap.org/?mlat=${ev.latitude}&mlon=${ev.longitude}#map=14/${ev.latitude}/${ev.longitude}" target="_blank" class="badge bg-light text-primary border text-decoration-none" title="Lihat di OpenStreetMap">
                    📍 ${ev.latitude.toFixed(4)}, ${ev.longitude.toFixed(4)}
                </a>
            `;
        }

        html += `
            <div class="timeline-item ${isActive ? 'active' : ''}">
                <div class="timeline-dot"></div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="badge ${statusBadgeClass} text-xs font-monospace px-2 py-0">${ev.current_status}</span>
                    <span class="text-muted text-xs">${ev.timestamp} (${ev.time_ago})</span>
                </div>
                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">${ev.event_name}</h6>
                <div class="d-flex align-items-center gap-2 mt-2" style="font-size: 0.75rem;">
                    ${gpsHtml}
                    <span class="text-muted">👤 ${ev.operator_name || 'Petugas Lapangan'}</span>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

// Handler Submit Checkpoint Baru
document.addEventListener('DOMContentLoaded', function () {
    const cpForm = document.getElementById('addCheckpointForm');
    if (cpForm) {
        cpForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!currentActiveBookingId) return;

            const nameInput = document.getElementById('cpEventName');
            const statusSelect = document.getElementById('cpStatus');
            const latInput = document.getElementById('cpLatitude');
            const lngInput = document.getElementById('cpLongitude');
            const submitBtn = document.getElementById('btnSubmitCheckpoint');

            const payload = {
                event_name: nameInput.value.trim(),
                current_status: statusSelect.value,
                latitude: latInput.value ? parseFloat(latInput.value) : null,
                longitude: lngInput.value ? parseFloat(lngInput.value) : null,
            };

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            fetch('/admin/bookings/' + currentActiveBookingId + '/tracking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>",
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Simpan Checkpoint ke Database';

                if (data.success) {
                    nameInput.value = '';
                    latInput.value = '';
                    lngInput.value = '';

                    // Tutup accordion
                    const collapseEl = document.getElementById('collapseAddCheckpoint');
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                    if (bsCollapse) bsCollapse.hide();

                    // Re-fetch dan render ulang timeline
                    openTrackingModal(currentActiveBookingId, document.getElementById('trackModalNo').innerText);
                } else {
                    alert('Gagal menyimpan checkpoint: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Simpan Checkpoint ke Database';
                alert('Gagal menghubungi server.');
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/operations/bookings.blade.php ENDPATH**/ ?>