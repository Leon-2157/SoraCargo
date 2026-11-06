<?php $__env->startSection('title', 'Profil 360° Pelanggan Retail: ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumbs & Quick Back -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>" class="text-decoration-none">Dasbor</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.customers.retail.index')); ?>" class="text-decoration-none">Pelanggan Retail &amp; UMKM</a></li>
            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page"><?php echo e($user->name); ?></li>
        </ol>
    </nav>
    <a href="<?php echo e(route('admin.customers.retail.index')); ?>" class="btn btn-outline-secondary btn-sm shadow-xs">
        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'arrow-left','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow-left','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kembali ke Daftar Pelanggan
    </a>
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
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php
    $amlStatus = $user->kyc_aml_status ?? 'STANDARD_VERIFIED';
    $isLocked = $user->status === 'BOOKING_LOCKED';
    $isBlacklisted = $user->status === 'BLACKLISTED';

    $waPhone = preg_replace('/[^0-9]/', '', $user->phone ?? '');
    if (str_starts_with($waPhone, '0')) {
        $waPhone = '62' . substr($waPhone, 1);
    }
?>

<!-- Retail Customer Hero Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div class="d-flex gap-3">
                <div class="bg-success-subtle text-success p-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'user','size' => '2rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user','size' => '2rem']); ?>
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
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h4 class="fw-bold text-dark mb-0"><?php echo e($user->name); ?></h4>
                        
                        <!-- Account Status Badge -->
                        <?php if($user->status === 'ACTIVE'): ?>
                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1">🟢 Akun Aktif</span>
                        <?php elseif($isLocked): ?>
                            <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1">🟡 Izin Booking Dikunci</span>
                        <?php elseif($isBlacklisted): ?>
                            <span class="badge bg-danger text-white px-2 py-1">🔴 Masuk Daftar Hitam</span>
                        <?php endif; ?>

                        <!-- AML Status Badge -->
                        <?php if($amlStatus === 'AML_VERIFIED'): ?>
                            <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'badge-check','size' => '0.8rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'badge-check','size' => '0.8rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> KTP Terverifikasi Sah
                            </span>
                        <?php elseif($amlStatus === 'HIGH_VALUE_PENDING'): ?>
                            <span class="badge bg-warning text-dark fw-bold px-2 py-1">
                                ⏳ Menunggu Verifikasi KTP (Order > Rp 50Jt)
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mt-2">
                        <span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'boxes','size' => '0.8rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'boxes','size' => '0.8rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Komoditas: <strong class="text-dark"><?php echo e($user->business_type ?? 'Perorangan UMKM'); ?></strong></span>
                        <span>•</span>
                        <span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'barcode','size' => '0.8rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'barcode','size' => '0.8rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> NIK: <strong class="text-dark font-monospace"><?php echo e($user->nik ?? 'Belum Terdaftar'); ?></strong></span>
                        <span>•</span>
                        <span><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','size' => '0.8rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','size' => '0.8rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Terdaftar: <?php echo e($user->created_at->format('d M Y')); ?></span>
                    </div>

                    <div class="small text-muted mt-1">
                        Email: <strong><?php echo e($user->email); ?></strong> | WhatsApp: <strong><?php echo e($user->phone ?? '-'); ?></strong>
                    </div>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="d-flex flex-wrap gap-2">
                <?php if($user->phone): ?>
                    <a href="https://wa.me/<?php echo e($waPhone); ?>?text=Halo%20<?php echo e(urlencode($user->name)); ?>,%20kami%20dari%20Tim%20SoraCargo." 
                       target="_blank" 
                       class="btn btn-outline-success btn-sm shadow-xs fw-semibold">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'brand-whatsapp','size' => '0.9rem','class' => 'me-1 text-success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'brand-whatsapp','size' => '0.9rem','class' => 'me-1 text-success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Chat WhatsApp
                    </a>
                <?php endif; ?>

                <button class="btn btn-primary btn-sm shadow-xs fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#detailAmlModal">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-check','size' => '0.9rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-check','size' => '0.9rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Validasi NIK KTP (AML)
                </button>

                <button class="btn btn-warning btn-sm shadow-xs text-dark fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#detailStatusModal">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'user-cog','size' => '0.9rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user-cog','size' => '0.9rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Ubah Sanksi Akun
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Financial & Order Metrics -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Saldo Escrow Berjalan</div>
                <h4 class="fw-bold mb-0 mt-1 text-success">Rp <?php echo e(number_format($activeEscrowHold, 0, ',', '.')); ?></h4>
                <div class="small text-muted mt-1">Prepaid kargo sedang berlayar</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Total Nilai Kargo Selesai</div>
                <h4 class="fw-bold mb-0 mt-1 text-primary">Rp <?php echo e(number_format($totalGoodsValue, 0, ',', '.')); ?></h4>
                <div class="small text-muted mt-1">Akumulasi seluruh barang terkirim</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-info h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Total Pesanan Kargo</div>
                <h4 class="fw-bold mb-0 mt-1 text-dark"><?php echo e(number_format($totalOrdersCount)); ?> <span class="fs-6 fw-normal text-muted">Pesanan</span></h4>
                <div class="small text-muted mt-1">LCL &amp; Charter Truck</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-secondary h-100">
            <div class="card-body p-3">
                <div class="text-uppercase text-muted small fw-semibold">Pesanan Selesai Terkirim</div>
                <h4 class="fw-bold mb-0 mt-1 text-success"><?php echo e(number_format($completedOrdersCount)); ?> <span class="fs-6 fw-normal text-muted">Sukses</span></h4>
                <?php
                    $deliveryRate = $totalOrdersCount > 0 ? round(($completedOrdersCount / $totalOrdersCount) * 100, 1) : 100;
                ?>
                <div class="small text-muted mt-1">Success Rate: <strong><?php echo e($deliveryRate); ?>%</strong></div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom p-0">
        <ul class="nav nav-tabs card-header-tabs m-0 px-3 border-0" id="retailTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active py-3 fw-semibold" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'boxes','size' => '0.9rem','class' => 'me-1 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'boxes','size' => '0.9rem','class' => 'me-1 text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Riwayat Pesanan &amp; Rekening Bersama Escrow (<?php echo e($user->cargoBookings->count()); ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 fw-semibold" id="aml-tab" data-bs-toggle="tab" data-bs-target="#aml" type="button" role="tab">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-check','size' => '0.9rem','class' => 'me-1 text-success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-check','size' => '0.9rem','class' => 'me-1 text-success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kepatuhan Hukum &amp; KTP AML
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-3 fw-semibold" id="audit-tab" data-bs-toggle="tab" data-bs-target="#audit" type="button" role="tab">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield','size' => '0.9rem','class' => 'me-1 text-danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield','size' => '0.9rem','class' => 'me-1 text-danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Catatan Audit Forensik (<?php echo e($auditLogs->count()); ?>)
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="tab-content" id="retailTabContent">
            <!-- TAB 1: Riwayat Pesanan & Escrow -->
            <div class="tab-pane fade show active" id="orders" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Daftar Pengiriman Kargo &amp; Status Rekening Bersama</h6>
                    <a href="<?php echo e(route('admin.finance.escrow')); ?>" class="btn btn-outline-success btn-sm">
                        Buka Manajemen Escrow
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th>No. Resi / Tracking</th>
                                <th>Jenis Kargo</th>
                                <th>Rute Pelayaran</th>
                                <th>Nilai Barang</th>
                                <th>Status Escrow</th>
                                <th>Status Pengiriman</th>
                                <th>Tanggal Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $user->cargoBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $escrow = $booking->escrowLedger;
                                ?>
                                <tr>
                                    <td class="font-monospace fw-bold text-primary"><?php echo e($booking->tracking_number); ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border"><?php echo e($booking->cargo_type); ?></span>
                                    </td>
                                    <td>
                                        <?php echo e($booking->route->originPort->port_code ?? 'JKT'); ?> → <?php echo e($booking->route->destinationPort->port_code ?? 'SUB'); ?>

                                        <div class="text-muted small"><?php echo e($booking->total_weight_kg); ?> kg / <?php echo e($booking->total_volume_cbm); ?> CBM</div>
                                    </td>
                                    <td class="fw-semibold">Rp <?php echo e(number_format($booking->declared_goods_value, 0, ',', '.')); ?></td>
                                    <td>
                                        <?php if($escrow): ?>
                                            <span class="badge bg-success-subtle text-success border border-success">
                                                Rp <?php echo e(number_format($escrow->total_paid_amount, 0, ',', '.')); ?> (<?php echo e($escrow->escrow_status); ?>)
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small">Prepaid Belum Dibuat</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary">
                                            <?php echo e($booking->cargo_status); ?>

                                        </span>
                                    </td>
                                    <td class="text-muted small"><?php echo e($booking->created_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada riwayat booking kargo dari pelanggan ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: Kepatuhan AML & KTP -->
            <div class="tab-pane fade" id="aml" role="tabpanel">
                <h6 class="fw-bold text-dark mb-3">Informasi Kepatuhan Regulasi (PPATK &amp; Batas Transaksi Kargo)</h6>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border bg-light h-100">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Data Identitas Kependudukan</h6>
                                <table class="table table-sm table-borderless mb-0 small">
                                    <tr>
                                        <td class="text-muted" style="width: 170px;">Nama Lengkap:</td>
                                        <td class="fw-bold text-dark"><?php echo e($user->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nomor Induk Kependudukan:</td>
                                        <td><code class="fs-6"><?php echo e($user->nik ?? 'Belum Diisi'); ?></code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status Kepatuhan:</td>
                                        <td>
                                            <?php if($amlStatus === 'AML_VERIFIED'): ?>
                                                <span class="badge bg-success text-white">TERVERIFIKASI SAH</span>
                                            <?php elseif($amlStatus === 'HIGH_VALUE_PENDING'): ?>
                                                <span class="badge bg-warning text-dark">MENUNGGU VERIFIKASI IDENTITAS</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary text-white">STANDAR (OTP NO. HP)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Waktu Verifikasi KTP:</td>
                                        <td class="text-muted"><?php echo e($user->ktp_verified_at ? $user->ktp_verified_at->format('d/m/Y H:i') : '-'); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border bg-light h-100">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Ketentuan Regulasi Maritim</h6>
                                <p class="small text-muted mb-2">
                                    Sesuai standar operasional SoraCargo dan kepatuhan hukum logistik:
                                </p>
                                <ul class="small text-muted ps-3 mb-0">
                                    <li class="mb-1"><strong>Transaksi Reguler (&lt; Rp 50 Juta):</strong> Pengirim retail cukup memvalidasi nomor telepon WhatsApp dan email.</li>
                                    <li class="mb-1"><strong>Transaksi Bernilai Tinggi (&gt; Rp 50 Juta):</strong> Wajib mengunggah NIK KTP yang telah dicocokkan sebelum petikemas dapat diterbitkan Delivery Order (DO).</li>
                                    <li><strong>Dangerous Goods (DG):</strong> Memerlukan verifikasi identitas mutlak dan lembar Material Safety Data Sheet (MSDS).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Catatan Audit Forensik -->
            <div class="tab-pane fade" id="audit" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0">Catatan Aktivitas Sistem Terkait Pelanggan</h6>
                    <a href="<?php echo e(route('admin.audit')); ?>" class="btn btn-outline-dark btn-sm">
                        Pusat Audit Trail
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th>Waktu Kejadian</th>
                                <th>Staf Pelaksana</th>
                                <th>Jenis Tindakan</th>
                                <th>Alamat IP</th>
                                <th>Detail Payload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $auditLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-muted small font-monospace"><?php echo e($log->created_at->format('d/m/Y H:i:s')); ?></td>
                                    <td class="fw-semibold text-dark"><?php echo e($log->adminUser->name ?? 'Sistem'); ?></td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary border font-monospace">
                                            <?php echo e($log->action_type); ?>

                                        </span>
                                    </td>
                                    <td class="small text-muted font-monospace"><?php echo e($log->ip_address); ?></td>
                                    <td class="small">
                                        <pre class="bg-light p-2 rounded mb-0 text-muted" style="max-height: 80px; font-size: 0.75rem;"><?php echo e(json_encode($log->after_state_json ?? $log->before_state_json, JSON_PRETTY_PRINT)); ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada riwayat audit trail untuk pelanggan ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS ON DETAIL PAGE -->

<!-- MODAL 1: Verifikasi AML KTP NIK -->
<div class="modal fade" id="detailAmlModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="<?php echo e(route('admin.customers.retail.verify_aml', $user->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold fs-6">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-check','class' => 'text-primary me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-check','class' => 'text-primary me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Verifikasi Kepatuhan NIK KTP (AML)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-secondary small mb-3">
                        Pelanggan: <strong><?php echo e($user->name); ?></strong> (<?php echo e($user->email); ?>)
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Induk Kependudukan (NIK 16 Digit) <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control form-control-sm font-monospace" maxlength="16" placeholder="Contoh: 3171052309850002" value="<?php echo e($user->nik ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Bidang Usaha / Jenis Komoditas UMKM</label>
                        <input type="text" name="business_type" class="form-control form-control-sm" placeholder="Contoh: Grosir Kopi, Sparepart Motor, Tekstil..." value="<?php echo e($user->business_type ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Status Keputusan Verifikasi AML <span class="text-danger">*</span></label>
                        <select name="kyc_aml_status" class="form-select form-select-sm" required>
                            <option value="AML_VERIFIED" <?php echo e(($user->kyc_aml_status ?? '') === 'AML_VERIFIED' ? 'selected' : ''); ?>>
                                ✅ KTP Sah &amp; Valid (Boleh Kirim Kargo > Rp 50Jt / DG)
                            </option>
                            <option value="STANDARD_VERIFIED" <?php echo e(($user->kyc_aml_status ?? '') === 'STANDARD_VERIFIED' ? 'selected' : ''); ?>>
                                Standard (Khusus Transaksi Retail Reguler)
                            </option>
                            <option value="AML_REJECTED" <?php echo e(($user->kyc_aml_status ?? '') === 'AML_REJECTED' ? 'selected' : ''); ?>>
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
<div class="modal fade" id="detailStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="<?php echo e(route('admin.customers.retail.status', $user->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold fs-6">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'user-cog','class' => 'text-warning me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user-cog','class' => 'text-warning me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Penetapan Sanksi Administratif Akun
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-secondary small mb-3">
                        Pelanggan: <strong><?php echo e($user->name); ?></strong><br>
                        Status Terkini: <strong><?php echo e($user->status); ?></strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Status Akun Baru <span class="text-danger">*</span></label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="ACTIVE" <?php echo e($user->status === 'ACTIVE' ? 'selected' : ''); ?>>🟢 Aktif (Izin Pemesanan Normal)</option>
                            <option value="BOOKING_LOCKED" <?php echo e($user->status === 'BOOKING_LOCKED' ? 'selected' : ''); ?>>🟡 Kunci Izin Booking (Pembatalan Berulang / Investigasi)</option>
                            <option value="BLACKLISTED" <?php echo e($user->status === 'BLACKLISTED' ? 'selected' : ''); ?>>🔴 Masuk Daftar Hitam (Permanen)</option>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/customers/retail-detail.blade.php ENDPATH**/ ?>