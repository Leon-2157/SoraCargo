<?php $__env->startSection('title', 'Mitra Corporate B2B'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="text-dark mb-0 fw-bold">Manajemen Mitra Corporate B2B</h3>
            <span class="badge badge-b2b fw-semibold px-2 py-1">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'building-2','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'building-2','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Klien Korporat
            </span>
        </div>
        <p class="text-muted small mb-0">Verifikasi legalitas Maker-Checker (NIB/NPWP/Akta), evaluasi risiko kredit, serta penetapan plafon &amp; termin TOP (Term of Payment 30–60 hari).</p>
    </div>
    <div class="mt-3 mt-sm-0 d-flex gap-2">
        <a href="<?php echo e(route('admin.customers.corporate.export')); ?>" class="btn btn-outline-success btn-sm shadow-sm">
            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file-spreadsheet','size' => '0.9rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file-spreadsheet','size' => '0.9rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Ekspor Rekap Kredit (CSV)
        </a>
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
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Quick Antrean Action Bar (Jika ada pending approval) -->
<?php if($pendingMakerCount > 0 || $pendingCheckerCount > 0): ?>
    <div class="alert alert-warning border-start border-4 border-warning shadow-sm mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','class' => 'text-warning flex-shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','class' => 'text-warning flex-shrink-0']); ?>
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
                    <strong>Pemberitahuan Antrean Persetujuan (Maker-Checker):</strong>
                    <span class="ms-2 small text-dark">
                        <?php if($pendingMakerCount > 0): ?>
                            <span class="badge bg-warning text-dark me-1"><?php echo e($pendingMakerCount); ?> Menunggu Validasi Legalitas (Maker)</span>
                        <?php endif; ?>
                        <?php if($pendingCheckerCount > 0): ?>
                            <span class="badge bg-info text-white"><?php echo e($pendingCheckerCount); ?> Menunggu Penetapan Plafon (Checker)</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <?php if($pendingMakerCount > 0): ?>
                    <a href="<?php echo e(route('admin.customers.corporate', ['kyc' => 'PENDING_VERIFICATION'])); ?>" class="btn btn-sm btn-outline-dark fw-semibold">
                        Lihat Antrean Maker
                    </a>
                <?php endif; ?>
                <?php if($pendingCheckerCount > 0): ?>
                    <a href="<?php echo e(route('admin.customers.corporate', ['kyc' => 'LEGALITY_VERIFIED'])); ?>" class="btn btn-sm btn-outline-primary fw-semibold">
                        Lihat Antrean Checker
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- KPI Radar Korporat B2B Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Total Mitra Perusahaan</div>
                        <h4 class="fw-bold mb-0 mt-1"><?php echo e(number_format($totalCompaniesCount)); ?> <span class="fs-6 fw-normal text-muted">PT/CV</span></h4>
                        <div class="small text-success mt-1">
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
<?php endif; ?> <?php echo e($activeCorporateCount); ?> Aktif Terverifikasi
                        </div>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'building-2','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'building-2','size' => '1.5rem']); ?>
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

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Total Plafon Disetujui</div>
                        <h4 class="fw-bold mb-0 mt-1 text-success">Rp <?php echo e(number_format($totalApprovedCredit / 1000000, 0, ',', '.')); ?> <span class="fs-6 fw-normal text-muted">Juta</span></h4>
                        <div class="small text-muted mt-1">Plafon kredit B2B berjalan</div>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'coins','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'coins','size' => '1.5rem']); ?>
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

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-info h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Plafon Kredit Terpakai</div>
                        <h4 class="fw-bold mb-0 mt-1 text-info">Rp <?php echo e(number_format($totalUsedCredit / 1000000, 0, ',', '.')); ?> <span class="fs-6 fw-normal text-muted">Juta</span></h4>
                        <?php
                            $utilTotal = $totalApprovedCredit > 0 ? round(($totalUsedCredit / $totalApprovedCredit) * 100, 1) : 0;
                        ?>
                        <div class="small text-muted mt-1">Utilisasi: <strong><?php echo e($utilTotal); ?>%</strong> dari total</div>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-circle">
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

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Tunggakan Overdue / SP</div>
                        <h4 class="fw-bold mb-0 mt-1 <?php echo e($overdueCount > 0 ? 'text-danger' : 'text-dark'); ?>">
                            <?php echo e(number_format($overdueCount)); ?> <span class="fs-6 fw-normal text-muted">Mitra</span>
                        </h4>
                        <div class="small <?php echo e($overdueCount > 0 ? 'text-danger' : 'text-muted'); ?> mt-1">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-alert','size' => '0.8rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-alert','size' => '0.8rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> SP1 / SP2 Lock / SP3 Legal
                        </div>
                    </div>
                    <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert-triangle','size' => '1.5rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert-triangle','size' => '1.5rem']); ?>
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

<!-- Filter Toolbar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="<?php echo e(route('admin.customers.corporate')); ?>" class="row g-2 align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'search','size' => '0.85rem','class' => 'text-muted']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'search','size' => '0.85rem','class' => 'text-muted']); ?>
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
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari PT/CV, NIB, NPWP, PIC, atau Email..." value="<?php echo e($search); ?>">
                </div>
            </div>

            <div class="col-lg-3 col-md-3">
                <select name="kyc" class="form-select form-select-sm">
                    <option value="all">Semua Status KYC / Approval</option>
                    <option value="PENDING_VERIFICATION" <?php echo e($kyc === 'PENDING_VERIFICATION' ? 'selected' : ''); ?>>⏳ Tahap 1: Menunggu Validasi Legalitas (Maker)</option>
                    <option value="LEGALITY_VERIFIED" <?php echo e($kyc === 'LEGALITY_VERIFIED' ? 'selected' : ''); ?>>📝 Tahap 2: Menunggu Plafon (Checker)</option>
                    <option value="VERIFIED_APPROVED" <?php echo e($kyc === 'VERIFIED_APPROVED' ? 'selected' : ''); ?>>✅ Terverifikasi &amp; Plafon Aktif</option>
                    <option value="REJECTED" <?php echo e($kyc === 'REJECTED' ? 'selected' : ''); ?>>❌ Berkas Ditolak</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-3">
                <select name="debt" class="form-select form-select-sm">
                    <option value="all">Semua Tahap Penagihan</option>
                    <option value="HEALTHY" <?php echo e($debt === 'HEALTHY' ? 'selected' : ''); ?>>🟢 Lancar (Healthy)</option>
                    <option value="SP1_ISSUED" <?php echo e($debt === 'SP1_ISSUED' ? 'selected' : ''); ?>>🟡 SP-1 (Overdue 1–6 Hari)</option>
                    <option value="SP2_LOCKED" <?php echo e($debt === 'SP2_LOCKED' ? 'selected' : ''); ?>>🔴 SP-2 Booking Terkunci (Overdue 7+ Hari)</option>
                    <option value="SP3_LEGAL_COLLECTION" <?php echo e($debt === 'SP3_LEGAL_COLLECTION' ? 'selected' : ''); ?>>⚫ SP-3 Kuasa Hukum / Sita Jaminan</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                    Filter
                </button>
                <?php if($search || ($kyc && $kyc !== 'all') || ($debt && $debt !== 'all')): ?>
                    <a href="<?php echo e(route('admin.customers.corporate')); ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Corporate Clients Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-3 py-3">Nama Perusahaan &amp; Legalitas</th>
                    <th class="py-3">Kontak PIC</th>
                    <th class="py-3">Status Maker-Checker KYC</th>
                    <th class="py-3">Plafon Kredit &amp; TOP</th>
                    <th class="py-3">Tahap Penagihan</th>
                    <th class="py-3">Izin Booking</th>
                    <th class="pe-3 py-3 text-end">Aksi Terpadu</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $credit = $company->credit;
                        $limit = $credit ? (float) $credit->credit_limit_amount : 0;
                        $used = $credit ? (float) $credit->used_credit_amount : 0;
                        $remaining = max(0, $limit - $used);
                        $utilPercent = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;
                        $isLocked = $company->user && $company->user->status === 'BOOKING_LOCKED';
                        
                        // Clean phone number for WhatsApp
                        $waPhone = preg_replace('/[^0-9]/', '', $company->pic_phone);
                        if (str_starts_with($waPhone, '0')) {
                            $waPhone = '62' . substr($waPhone, 1);
                        }
                    ?>
                    <tr>
                        <!-- Perusahaan & NIB/NPWP -->
                        <td class="ps-3 py-3">
                            <div class="fw-bold text-dark">
                                <a href="<?php echo e(route('admin.customers.corporate.show', $company->id)); ?>" class="text-dark text-decoration-none hover-primary">
                                    <?php echo e($company->company_name); ?>

                                </a>
                            </div>
                            <div class="small text-muted mt-1">
                                <span class="badge bg-light text-secondary border font-monospace">NIB: <?php echo e($company->nib); ?></span>
                                <span class="badge bg-light text-secondary border font-monospace ms-1">NPWP: <?php echo e($company->npwp); ?></span>
                            </div>
                            <div class="text-truncate small text-muted mt-1" style="max-width: 260px;" title="<?php echo e($company->company_address); ?>">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'compass','size' => '0.75rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'compass','size' => '0.75rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php echo e($company->company_address); ?>

                            </div>
                        </td>

                        <!-- Kontak PIC -->
                        <td class="py-3">
                            <div class="fw-semibold text-dark"><?php echo e($company->pic_name); ?></div>
                            <div class="small text-muted"><?php echo e($company->user->email ?? '-'); ?></div>
                            <div class="mt-1">
                                <a href="https://wa.me/<?php echo e($waPhone); ?>?text=Halo%20<?php echo e(urlencode($company->pic_name)); ?>%20(<?php echo e(urlencode($company->company_name)); ?>),%20kami%20dari%20Tim%20SoraCargo." 
                                   target="_blank" 
                                   class="btn btn-outline-success btn-xs py-0 px-2 rounded-pill shadow-xs" 
                                   title="Kirim pesan WhatsApp langsung ke PIC">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'brand-whatsapp','size' => '0.75rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'brand-whatsapp','size' => '0.75rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php echo e($company->pic_phone); ?>

                                </a>
                            </div>
                        </td>

                        <!-- Status KYC Maker-Checker -->
                        <td class="py-3">
                            <?php if(!$credit || $credit->kyc_status === 'PENDING_VERIFICATION'): ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1">
                                    ⏳ Menunggu Validasi Dokumen (Maker)
                                </span>
                                <div class="small text-muted mt-1">Staf Ops perlu cek NIB/NPWP</div>
                            <?php elseif($credit->kyc_status === 'LEGALITY_VERIFIED'): ?>
                                <span class="badge bg-info-subtle text-info border border-info fw-semibold px-2 py-1">
                                    📝 Berkas Sah - Menunggu Plafon (Checker)
                                </span>
                                <div class="small text-muted mt-1">
                                    Divalidasi oleh: <?php echo e($credit->legalityVerifier->name ?? 'Ops Staff'); ?>

                                </div>
                            <?php elseif($credit->kyc_status === 'VERIFIED_APPROVED'): ?>
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    ✅ Terverifikasi &amp; Plafon Aktif
                                </span>
                                <div class="small text-muted mt-1">
                                    Disetujui: <?php echo e($credit->creditApprover->name ?? $credit->verifiedBy->name ?? 'Finance Admin'); ?>

                                </div>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1">
                                    ❌ Berkas Ditolak
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Plafon Kredit & TOP -->
                        <td class="py-3" style="min-width: 200px;">
                            <?php if($credit && $limit > 0): ?>
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="text-muted">Limit: <strong>Rp <?php echo e(number_format($limit, 0, ',', '.')); ?></strong></span>
                                    <span class="badge bg-secondary-subtle text-secondary border">TOP <?php echo e($credit->top_days); ?> Hari</span>
                                </div>
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar <?php echo e($utilPercent > 85 ? 'bg-danger' : ($utilPercent > 60 ? 'bg-warning' : 'bg-primary')); ?>" 
                                         role="progressbar" 
                                         style="width: <?php echo e(min(100, $utilPercent)); ?>%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1" style="font-size: 0.75rem;">
                                    <span class="text-danger">Terpakai: Rp <?php echo e(number_format($used, 0, ',', '.')); ?></span>
                                    <span class="text-success">Sisa: Rp <?php echo e(number_format($remaining, 0, ',', '.')); ?> (<?php echo e(100 - $utilPercent); ?>%)</span>
                                </div>
                            <?php else: ?>
                                <span class="text-muted small italic">Plafon belum ditetapkan</span>
                            <?php endif; ?>
                        </td>

                        <!-- Tahap Penagihan -->
                        <td class="py-3">
                            <?php $stage = $credit->debt_enforcement_stage ?? 'HEALTHY'; ?>
                            <?php if($stage === 'HEALTHY'): ?>
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    🟢 Lancar (Healthy)
                                </span>
                            <?php elseif($stage === 'SP1_ISSUED'): ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning fw-semibold px-2 py-1">
                                    🟡 SP-1 (Overdue)
                                </span>
                            <?php elseif($stage === 'SP2_LOCKED'): ?>
                                <span class="badge bg-danger text-white fw-semibold px-2 py-1">
                                    🔴 SP-2 Locked
                                </span>
                            <?php elseif($stage === 'SP3_LEGAL_COLLECTION'): ?>
                                <span class="badge bg-dark text-white fw-semibold px-2 py-1">
                                    ⚫ SP-3 Kuasa Hukum
                                </span>
                            <?php endif; ?>

                            <?php if($credit && $credit->dispensation_notes): ?>
                                <div class="small text-info mt-1" title="<?php echo e($credit->dispensation_notes); ?>">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'badge-check','size' => '0.75rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'badge-check','size' => '0.75rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Dispensasi Aktif
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- Izin Booking -->
                        <td class="py-3">
                            <?php if($isLocked): ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger fw-semibold px-2 py-1">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'ban','size' => '0.75rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ban','size' => '0.75rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Booking Dikunci
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success border border-success fw-semibold px-2 py-1">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.75rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.75rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Izin Aktif
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi Terpadu -->
                        <td class="pe-3 py-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="<?php echo e(route('admin.customers.corporate.show', $company->id)); ?>" class="btn btn-outline-primary btn-sm shadow-xs" title="Buka Detail Lengkap 360°">
                                    Detail 360°
                                </a>

                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-light btn-sm border shadow-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opsi
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                        <!-- Tahap 1: Validasi Maker -->
                                        <li>
                                            <button class="dropdown-item py-2 small" type="button" data-bs-toggle="modal" data-bs-target="#makerModal<?php echo e($company->id); ?>">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file-check','size' => '0.85rem','class' => 'me-2 text-warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file-check','size' => '0.85rem','class' => 'me-2 text-warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> [Tahap 1] Validasi Legalitas (Maker)
                                            </button>
                                        </li>
                                        <!-- Tahap 2: Persetujuan Checker -->
                                        <li>
                                            <button class="dropdown-item py-2 small" type="button" data-bs-toggle="modal" data-bs-target="#checkerModal<?php echo e($company->id); ?>">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'shield-check','size' => '0.85rem','class' => 'me-2 text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'shield-check','size' => '0.85rem','class' => 'me-2 text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> [Tahap 2] Penetapan Plafon (Checker)
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <!-- Lock/Unlock Booking -->
                                        <li>
                                            <button class="dropdown-item py-2 small <?php echo e($isLocked ? 'text-success' : 'text-danger'); ?>" type="button" data-bs-toggle="modal" data-bs-target="#lockModal<?php echo e($company->id); ?>">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => ''.e($isLocked ? 'check-circle' : 'ban').'','size' => '0.85rem','class' => 'me-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($isLocked ? 'check-circle' : 'ban').'','size' => '0.85rem','class' => 'me-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php echo e($isLocked ? 'Buka Kunci Booking (Dispensasi)' : 'Kunci Izin Booking Kargo'); ?>

                                            </button>
                                        </li>
                                        <!-- Kirim SP WhatsApp -->
                                        <li>
                                            <button class="dropdown-item py-2 small text-warning" type="button" data-bs-toggle="modal" data-bs-target="#spModal<?php echo e($company->id); ?>">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'brand-whatsapp','size' => '0.85rem','class' => 'me-2 text-success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'brand-whatsapp','size' => '0.85rem','class' => 'me-2 text-success']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kirim Surat Peringatan (WhatsApp)
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- MODAL 1: Maker Validasi Legalitas -->
                    <div class="modal fade" id="makerModal<?php echo e($company->id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="<?php echo e(route('admin.customers.corporate.verify_legality', $company->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold fs-6">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'file-check','class' => 'text-warning me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'file-check','class' => 'text-warning me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> [Tahap 1 Maker] Validasi Legalitas Dokumen
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="alert alert-secondary small mb-3">
                                            <strong><?php echo e($company->company_name); ?></strong><br>
                                            NIB: <code><?php echo e($company->nib); ?></code> | NPWP: <code><?php echo e($company->npwp); ?></code><br>
                                            PIC: <?php echo e($company->pic_name); ?> (<?php echo e($company->pic_phone); ?>)
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Keputusan Validasi Berkas Operasional <span class="text-danger">*</span></label>
                                            <select name="legality_status" class="form-select form-select-sm" required>
                                                <option value="LEGALITY_VERIFIED" <?php echo e(($credit->kyc_status ?? '') === 'LEGALITY_VERIFIED' ? 'selected' : ''); ?>>
                                                    ✅ Dokumen Sah &amp; Lengkap (Teruskan ke Checker Finance)
                                                </option>
                                                <option value="REJECTED" <?php echo e(($credit->kyc_status ?? '') === 'REJECTED' ? 'selected' : ''); ?>>
                                                    ❌ Berkas Tidak Lengkap / Ditolak
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Catatan Hasil Pemeriksaan Legalitas <span class="text-danger">*</span></label>
                                            <textarea name="legality_notes" class="form-control form-control-sm" rows="3" placeholder="Contoh: NIB dan NPWP telah dicocokkan via OSS Cloud. Akta Perusahaan sah..." required><?php echo e($credit->legality_notes ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold">Simpan Keputusan Maker</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 2: Checker Persetujuan Plafon Kredit -->
                    <div class="modal fade" id="checkerModal<?php echo e($company->id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="<?php echo e(route('admin.customers.corporate.approve_credit', $company->id)); ?>">
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
<?php endif; ?> [Tahap 2 Checker] Penetapan Plafon Kredit &amp; TOP
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="alert alert-info small mb-3">
                                            <strong><?php echo e($company->company_name); ?></strong><br>
                                            Status Dokumen Maker: <strong><?php echo e($credit->kyc_status ?? 'PENDING'); ?></strong><br>
                                            Catatan Maker: <em><?php echo e($credit->legality_notes ?? 'Belum ada catatan maker'); ?></em>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Batas Plafon Kredit B2B (IDR) <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light">Rp</span>
                                                <input type="number" step="1000000" name="credit_limit_amount" class="form-control" value="<?php echo e($credit->credit_limit_amount ?? 500000000); ?>" required>
                                            </div>
                                            <div class="form-text small">Nominal pagu kredit maksimum untuk penagihan berjangka.</div>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label small fw-bold">Term of Payment (TOP) <span class="text-danger">*</span></label>
                                                <select name="top_days" class="form-select form-select-sm" required>
                                                    <option value="14" <?php echo e(($credit->top_days ?? 30) == 14 ? 'selected' : ''); ?>>14 Hari Kalender</option>
                                                    <option value="30" <?php echo e(($credit->top_days ?? 30) == 30 ? 'selected' : ''); ?>>30 Hari Kalender (Standar)</option>
                                                    <option value="45" <?php echo e(($credit->top_days ?? 30) == 45 ? 'selected' : ''); ?>>45 Hari Kalender</option>
                                                    <option value="60" <?php echo e(($credit->top_days ?? 30) == 60 ? 'selected' : ''); ?>>60 Hari Kalender</option>
                                                    <option value="90" <?php echo e(($credit->top_days ?? 30) == 90 ? 'selected' : ''); ?>>90 Hari (Prioritas Khusus)</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small fw-bold">Tahap Penagihan Awal <span class="text-danger">*</span></label>
                                                <select name="debt_enforcement_stage" class="form-select form-select-sm" required>
                                                    <option value="HEALTHY" <?php echo e(($credit->debt_enforcement_stage ?? 'HEALTHY') === 'HEALTHY' ? 'selected' : ''); ?>>🟢 Lancar (Healthy)</option>
                                                    <option value="SP1_ISSUED" <?php echo e(($credit->debt_enforcement_stage ?? '') === 'SP1_ISSUED' ? 'selected' : ''); ?>>🟡 SP-1 Overdue</option>
                                                    <option value="SP2_LOCKED" <?php echo e(($credit->debt_enforcement_stage ?? '') === 'SP2_LOCKED' ? 'selected' : ''); ?>>🔴 SP-2 Locked</option>
                                                    <option value="SP3_LEGAL_COLLECTION" <?php echo e(($credit->debt_enforcement_stage ?? '') === 'SP3_LEGAL_COLLECTION' ? 'selected' : ''); ?>>⚫ SP-3 Kuasa Hukum</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Nomor Referensi Bank Guarantee (Jika Ada)</label>
                                            <input type="text" name="bank_guarantee_ref" class="form-control form-control-sm" placeholder="Contoh: BG-88291-MND" value="<?php echo e($credit->bank_guarantee_ref ?? ''); ?>">
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label small fw-bold">Catatan Evaluasi Risiko Kredit (Checker)</label>
                                            <textarea name="checker_notes" class="form-control form-control-sm" rows="2" placeholder="Catatan persetujuan risiko keuangan..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">Setujui Plafon (Checker Final)</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 3: Kunci / Pulihkan Izin Booking -->
                    <div class="modal fade" id="lockModal<?php echo e($company->id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="<?php echo e(route('admin.customers.corporate.lock', $company->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold fs-6">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => ''.e($isLocked ? 'check-circle' : 'ban').'','class' => ''.e($isLocked ? 'text-success' : 'text-danger').' me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($isLocked ? 'check-circle' : 'ban').'','class' => ''.e($isLocked ? 'text-success' : 'text-danger').' me-1']); ?>
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
                                            <?php echo e($isLocked ? 'Buka Kunci Booking Kargo (Pemberian Dispensasi)' : 'Kunci Izin Booking Kargo (Lock Booking)'); ?>

                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <?php if($isLocked): ?>
                                            <p class="small text-muted mb-3">
                                                Mitra <strong><?php echo e($company->company_name); ?></strong> saat ini terkunci. Memberikan dispensasi akan memulihkan izin pembuatan order booking petikemas baru bagi akun ini.
                                            </p>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Alasan Dispensasi Pemulihan <span class="text-danger">*</span></label>
                                                <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Telah ada surat pernyataan transfer bertahap dari Direktur Utama..." required></textarea>
                                            </div>
                                        <?php else: ?>
                                            <p class="small text-danger mb-3">
                                                Perhatian: Mengunci izin booking akan menolak semua pembuatan order pengiriman kargo baru dari mitra <strong><?php echo e($company->company_name); ?></strong> secara instan.
                                            </p>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Alasan Penguncian Akses</label>
                                                <textarea name="reason" class="form-control form-control-sm" rows="3" placeholder="Contoh: Tagihan faktur INV-202611 melewati batas toleransi TOP (SP2)..."></textarea>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn <?php echo e($isLocked ? 'btn-success' : 'btn-danger'); ?> btn-sm fw-bold">
                                            <?php echo e($isLocked ? 'Buka Kunci (Aktifkan Dispensasi)' : 'Konfirmasi Kunci Booking'); ?>

                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL 4: Kirim SP WhatsApp -->
                    <div class="modal fade" id="spModal<?php echo e($company->id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST" action="<?php echo e(route('admin.customers.corporate.send_warning', $company->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold fs-6">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'brand-whatsapp','class' => 'text-success me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'brand-whatsapp','class' => 'text-success me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kirim Surat Peringatan Tagihan via WhatsApp
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="alert alert-secondary small mb-3">
                                            Tujuan: <strong><?php echo e($company->pic_name); ?></strong> (<?php echo e($company->pic_phone); ?>)<br>
                                            Perusahaan: <?php echo e($company->company_name); ?>

                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Pilih Tingkat Surat Peringatan <span class="text-danger">*</span></label>
                                            <select name="sp_stage" class="form-select form-select-sm" required>
                                                <option value="SP1_ISSUED">🟡 SP-1 (Peringatan Jatuh Tempo Hari ke-1)</option>
                                                <option value="SP2_LOCKED">🔴 SP-2 (Toleransi Hari ke-7 &amp; Penahanan Booking)</option>
                                                <option value="SP3_LEGAL_COLLECTION">⚫ SP-3 (Eskalasi Kuasa Hukum &amp; Sita Jaminan Bank)</option>
                                            </select>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label small fw-bold">Catatan Tambahan untuk PIC</label>
                                            <textarea name="custom_message" class="form-control form-control-sm" rows="3" placeholder="Pesan resmi akan diteruskan melalui Baileys WhatsApp Gateway terverifikasi SoraCargo..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success btn-sm fw-bold">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'brand-whatsapp','size' => '0.85rem','class' => 'me-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'brand-whatsapp','size' => '0.85rem','class' => 'me-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kirim Pesan Resmi Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'building-2','size' => '2.5rem','class' => 'text-secondary opacity-50 mb-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'building-2','size' => '2.5rem','class' => 'text-secondary opacity-50 mb-2']); ?>
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
                            <div class="fw-semibold">Tidak ada data mitra perusahaan yang sesuai dengan filter.</div>
                            <div class="small">Coba ubah kata kunci pencarian atau reset filter.</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($companies->hasPages()): ?>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan <strong><?php echo e($companies->firstItem()); ?></strong> - <strong><?php echo e($companies->lastItem()); ?></strong> dari <strong><?php echo e($companies->total()); ?></strong> mitra
                </div>
                <div>
                    <?php echo e($companies->links()); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/customers/corporate.blade.php ENDPATH**/ ?>