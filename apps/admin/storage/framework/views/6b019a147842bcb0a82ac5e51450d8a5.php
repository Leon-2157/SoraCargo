<?php $__env->startSection('title', 'Large Language Models'); ?>
<?php $__env->startSection('page_title', 'Large Language Models'); ?>

<?php $__env->startSection('content'); ?>
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

<div id="dynamicPageAlert" class="d-none"></div>

<!-- 4 KPI Cards (Matching Design System) -->
<div class="row g-3 mb-4">
    <!-- Card 1: MODEL AI -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em;">MODEL AI</span>
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'bot','size' => '1.25rem','class' => 'text-muted opacity-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bot','size' => '1.25rem','class' => 'text-muted opacity-50']); ?>
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
            <h4 class="fw-bold mb-1 font-monospace text-dark" style="font-size: 1.35rem;" id="cardModelName"><?php echo e($modelName ?: 'Belum Dikonfigurasi'); ?></h4>
            <div class="text-muted" style="font-size: 0.78rem;">Penalaran logistik mendalam</div>
        </div>
    </div>

    <!-- Card 2: KONSUMSI TOKEN BULANAN -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em;">KONSUMSI TOKEN BULANAN</span>
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'link-2','size' => '1.25rem','class' => 'text-muted opacity-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'link-2','size' => '1.25rem','class' => 'text-muted opacity-50']); ?>
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
            <h4 class="fw-bold mb-1 text-dark" style="font-size: 1.35rem;"><?php echo e(number_format($usageTokens)); ?></h4>
            <?php $tokenPct = round(($usageTokens / $quotaTokens) * 100, 1); ?>
            <div class="text-muted" style="font-size: 0.78rem;"><?php echo e($tokenPct); ?>% dari kuota <?php echo e(number_format($quotaTokens / 1000000, 1)); ?>M</div>
        </div>
    </div>

    <!-- Card 3: TEMPERATURE (KREATIVITAS) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold" style="color: #d97706; font-size: 0.72rem; letter-spacing: 0.06em;">TEMPERATURE (KREATIVITAS)</span>
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'sliders','size' => '1.25rem','class' => 'text-muted opacity-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'sliders','size' => '1.25rem','class' => 'text-muted opacity-50']); ?>
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
            <h4 class="fw-bold mb-1 text-dark" style="font-size: 1.35rem;" id="cardTemperature"><?php echo e($temperature); ?></h4>
            <div class="fw-medium d-flex align-items-center gap-1" id="cardTempLabel" style="font-size: 0.78rem;">
                <?php if($temperature <= 0.35): ?>
                    <span class="text-success d-flex align-items-center gap-1"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'check','size' => '0.85rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'check','size' => '0.85rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Presisi Faktual Tinggi</span>
                <?php elseif($temperature <= 0.70): ?>
                    <span class="text-primary d-flex align-items-center gap-1"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'activity','size' => '0.85rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'activity','size' => '0.85rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Seimbang & Fleksibel</span>
                <?php else: ?>
                    <span class="text-warning d-flex align-items-center gap-1"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'alert-triangle','size' => '0.85rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alert-triangle','size' => '0.85rem']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> Kreatif & Eksploratif</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Card 4: BATAS MAKS OUTPUT -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm rounded-3 p-3 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-success fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em;">BATAS MAKS OUTPUT</span>
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'layers','size' => '1.25rem','class' => 'text-muted opacity-50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'layers','size' => '1.25rem','class' => 'text-muted opacity-50']); ?>
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
            <h4 class="fw-bold mb-1 text-dark" style="font-size: 1.35rem;" id="cardMaxTokens"><?php echo e($maxTokens); ?> Tokens</h4>
            <div class="text-muted" style="font-size: 0.78rem;" id="cardMaxTokensLabel">&plusmn; <?php echo e(number_format(round($maxTokens * 0.75))); ?> kata per respon</div>
        </div>
    </div>
</div>

<!-- Two Columns Layout: Setting Model LLM & Simulator Sandbox LLM -->
<div class="row g-4">
    <!-- Col 1: Setting Model LLM -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
            <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom-0">
                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'user-check','size' => '1.15rem','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'user-check','size' => '1.15rem','class' => 'text-primary']); ?>
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
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">Setting Model LLM</h6>
                </div>
                <!-- Tombol Tambah Model Manual (+) Pojok Kanan Atas -->
                <button type="button" class="btn btn-sm btn-light border text-primary rounded px-2 py-1 shadow-xs" data-bs-toggle="modal" data-bs-target="#addModelModal" title="Tambah Model LLM Baru" style="background-color: #f0f7ff; border-color: #bfdbfe !important;">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'plus','size' => '1.1rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plus','size' => '1.1rem']); ?>
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
            </div>

            <div class="px-4 pb-4 pt-1">
                <form id="formAiSettings" action="<?php echo e(route('admin.ai-service.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Pilihan Arsitektur Model LLM <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                <select name="ai_model_name" id="aiModelSelect" class="form-select form-select-sm" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.88rem; padding: 0.45rem 0.75rem;" required>
                                    <?php $__empty_1 = true; $__currentLoopData = $availableModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($m['id']); ?>" <?php echo e($modelName === $m['id'] ? 'selected' : ''); ?>>
                                            <?php echo e($m['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value="" disabled selected>-- Belum ada model LLM (Klik [+] untuk tambah) --</option>
                                    <?php endif; ?>
                                </select>
                                <button type="button" class="btn btn-sm btn-outline-danger px-2.5 py-1 d-flex align-items-center justify-content-center" id="btnDeleteModel" title="Hapus Model Terpilih" <?php echo e(empty($availableModels) ? 'disabled' : ''); ?> style="border-radius: 8px;">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'trash-2','size' => '1rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'trash-2','size' => '1rem']); ?>
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
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-dark mb-1">Temperature <span class="text-danger">*</span></label>
                            <input type="number" step="0.05" min="0" max="1" name="ai_temperature" id="aiTemperatureInput" class="form-control form-control-sm text-center" value="<?php echo e($temperature); ?>" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.88rem; padding: 0.45rem 0.75rem;" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-dark mb-1">Max Tokens <span class="text-danger">*</span></label>
                            <input type="number" name="ai_max_tokens" id="aiMaxTokensInput" class="form-control form-control-sm text-center" value="<?php echo e($maxTokens); ?>" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.88rem; padding: 0.45rem 0.75rem;" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">System Instruction SoraBot <span class="text-danger">*</span></label>
                        <textarea name="ai_system_prompt" id="aiSystemPromptInput" class="form-control font-monospace" rows="11" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.85rem; line-height: 1.5; color: #334155;" required><?php echo e($systemPrompt); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm" style="background-color: #2563eb; border-radius: 8px; font-size: 0.88rem;">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'upload','size' => '1rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'upload','size' => '1rem']); ?>
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
                            <span>Simpan Kalibrasi Mesin AI</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Col 2: Simulator Sandbox LLM -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-3 h-100 bg-white">
            <div class="d-flex justify-content-between align-items-center py-3 px-4 border-bottom-0">
                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'message-square','size' => '1.15rem','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'message-square','size' => '1.15rem','class' => 'text-primary']); ?>
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
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 1.05rem;">Simulator Sandbox LLM</h6>
                </div>
                <span class="badge bg-light text-secondary border px-2.5 py-1 fw-medium" id="sandboxModelBadge" style="border-radius: 6px; font-size: 0.8rem;"><?php echo e($modelName ?: 'Belum Terpilih'); ?></span>
            </div>

            <div class="px-4 pb-4 pt-1 d-flex flex-column">
                <label class="form-label small fw-semibold text-dark mb-1">Promt Simulator:</label>
                <textarea id="simulatorPrompt" class="form-control" rows="3" placeholder="Contoh: Apakah rute Surabaya ke Makassar saat ini mengalami penundaan cuaca buruk?" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.86rem; color: #334155;"><?php echo e(session('last_query')); ?></textarea>

                <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center gap-2 py-2 mt-3 fw-semibold shadow-xs" id="btnExecuteSimulator" style="border-radius: 8px; border-color: #3b82f6; color: #2563eb; font-size: 0.88rem;">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'clock','size' => '1.05rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'clock','size' => '1.05rem']); ?>
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
                    <span id="simBtnText">Eksekusi Uji Coba Respon</span>
                </button>

                <label class="form-label small fw-semibold text-dark mt-3 mb-1">Output Respons Asisten AI:</label>
                <div class="rounded-3 p-3 flex-grow-1" style="background-color: #1e293b; color: #f8fafc; font-size: 0.84rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; min-height: 240px; white-space: pre-wrap; line-height: 1.6; overflow-y: auto;" id="simulatorOutput"><?php echo e(session('test_result') ?? 'Siap menjalankan simulasi. Masukkan kueri di atas untuk menguji ketepatan guardrail instruksi SoraBot.'); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-up Tambah Model LLM Manual (Desain Presisi Sesuai Mockup) -->
<div class="modal fade" id="addModelModal" tabindex="-1" aria-labelledby="addModelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-1.5 rounded-2 bg-primary bg-opacity-10 text-primary">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'cpu','size' => '1.2rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cpu','size' => '1.2rem']); ?>
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
                        <h6 class="modal-title fw-bold text-dark mb-0" id="addModelModalLabel">Tambah Konfigurasi Model LLM</h6>
                        <span class="text-muted text-xs">Integrasikan endpoint inferensi model secara mandiri (manual).</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <form id="addModelForm">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">Nama Model <span class="text-danger">*</span></label>
                        <input type="text" id="modalModelName" class="form-control" placeholder="Contoh: ag/gemini-3.8-flash-low / gpt-4o / claude-3-5-sonnet" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.88rem;" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark mb-1">API Endpoint / Base URL <span class="text-danger">*</span></label>
                        <input type="url" id="modalModelUrl" class="form-control" placeholder="http://localhost:20128/v1" value="http://localhost:20128/v1" style="border-radius: 8px; border-color: #d1d5db; font-size: 0.88rem;" required>
                        <span class="text-muted text-xs">URL REST API endpoint gateway inferensi AI (e.g. 9Router / OpenAI Compatible / Gemini API).</span>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-dark mb-1">API Key / Secret Token <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" id="modalModelApiKey" class="form-control" placeholder="sk-... / AIzaSy..." style="border-top-left-radius: 8px; border-bottom-left-radius: 8px; border-color: #d1d5db; font-size: 0.88rem;" required>
                            <button class="btn btn-outline-secondary" type="button" id="btnToggleApiKey" style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-color: #d1d5db;">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'eye','size' => '1rem','id' => 'eyeIcon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'eye','size' => '1rem','id' => 'eyeIcon']); ?>
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
                        </div>
                        <span class="text-muted text-xs">Kredensial disimpan aman untuk otorisasi request HTTP inferensi.</span>
                    </div>

                    <div id="modalTestFeedback" class="mt-3 d-none"></div>
                </form>
            </div>

            <div class="modal-footer border-top px-4 py-3 d-flex justify-content-between align-items-center">
                <!-- Pojok Kiri Bawah: Tombol Tes Koneksi -->
                <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" id="btnTestConnection" style="border-radius: 8px; border-color: #3b82f6; color: #2563eb; font-size: 0.88rem;">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'activity','size' => '1rem','id' => 'testConnIcon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'activity','size' => '1rem','id' => 'testConnIcon']); ?>
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
                    <span id="testConnText">Tes Koneksi</span>
                </button>

                <!-- Pojok Kanan Bawah: Tombol Batal & Tambahkan -->
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border text-secondary px-3 py-2 fw-medium" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.88rem;">Batal</button>
                    <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" id="btnAddModelSubmit" style="background-color: #2563eb; border-radius: 8px; font-size: 0.88rem;">
                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon','data' => ['name' => 'plus-circle','size' => '1rem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plus-circle','size' => '1rem']); ?>
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
                        <span>Tambahkan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const aiModelSelect = document.getElementById('aiModelSelect');
    const aiTemperatureInput = document.getElementById('aiTemperatureInput');
    const aiMaxTokensInput = document.getElementById('aiMaxTokensInput');
    const cardModelName = document.getElementById('cardModelName');
    const cardTemperature = document.getElementById('cardTemperature');
    const cardMaxTokens = document.getElementById('cardMaxTokens');
    const sandboxModelBadge = document.getElementById('sandboxModelBadge');
    const btnDeleteModel = document.getElementById('btnDeleteModel');
    const cardTempLabel = document.getElementById('cardTempLabel');
    const cardMaxTokensLabel = document.getElementById('cardMaxTokensLabel');

    // Sinkronisasi Interaktif Input Setting ke Stat Cards
    if (aiModelSelect) {
        aiModelSelect.addEventListener('change', function () {
            const selectedVal = this.value;
            if (cardModelName) cardModelName.textContent = selectedVal || 'Belum Dikonfigurasi';
            if (sandboxModelBadge) sandboxModelBadge.textContent = selectedVal || 'Belum Terpilih';
            if (btnDeleteModel) btnDeleteModel.disabled = !selectedVal;
        });
    }

    if (aiTemperatureInput) {
        aiTemperatureInput.addEventListener('input', function () {
            const val = parseFloat(this.value) || 0;
            if (cardTemperature) cardTemperature.textContent = this.value || '0';
            if (cardTempLabel) {
                if (val <= 0.35) {
                    cardTempLabel.innerHTML = '<span class="text-success d-flex align-items-center gap-1">✓ Presisi Faktual Tinggi</span>';
                } else if (val <= 0.70) {
                    cardTempLabel.innerHTML = '<span class="text-primary d-flex align-items-center gap-1">⚡ Seimbang & Fleksibel</span>';
                } else {
                    cardTempLabel.innerHTML = '<span class="text-warning d-flex align-items-center gap-1">✨ Kreatif & Eksploratif</span>';
                }
            }
        });
    }

    if (aiMaxTokensInput) {
        aiMaxTokensInput.addEventListener('input', function () {
            const val = parseInt(this.value) || 0;
            if (cardMaxTokens) cardMaxTokens.textContent = (this.value || '0') + ' Tokens';
            if (cardMaxTokensLabel) cardMaxTokensLabel.innerHTML = `&plusmn; ${Math.round(val * 0.75).toLocaleString()} kata per respon`;
        });
    }

    // Toggle Tampilan API Key (Password / Text)
    const btnToggleApiKey = document.getElementById('btnToggleApiKey');
    const modalModelApiKey = document.getElementById('modalModelApiKey');
    if (btnToggleApiKey && modalModelApiKey) {
        btnToggleApiKey.addEventListener('click', function () {
            if (modalModelApiKey.type === 'password') {
                modalModelApiKey.type = 'text';
            } else {
                modalModelApiKey.type = 'password';
            }
        });
    }

    // Tes Koneksi API Endpoint via AJAX
    const btnTestConnection = document.getElementById('btnTestConnection');
    const modalTestFeedback = document.getElementById('modalTestFeedback');
    const testConnText = document.getElementById('testConnText');

    if (btnTestConnection) {
        btnTestConnection.addEventListener('click', async function () {
            const url = document.getElementById('modalModelUrl').value.trim();
            const apiKey = modalModelApiKey.value.trim();
            const modelName = document.getElementById('modalModelName').value.trim();

            if (!url) {
                showModalFeedback(false, 'Harap isi URL Endpoint terlebih dahulu.');
                return;
            }
            if (!apiKey) {
                showModalFeedback(false, 'Harap isi API Key / Secret Token terlebih dahulu.');
                return;
            }

            // Status Loading
            btnTestConnection.disabled = true;
            testConnText.textContent = 'Menguji...';
            showModalFeedback('loading', 'Menguji konektivitas soket ke endpoint host...');

            try {
                const response = await fetch("<?php echo e(route('admin.ai-service.test')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        api_url: url,
                        api_key: apiKey,
                        model_name: modelName
                    })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    showModalFeedback(true, `✓ ${data.message}`);
                } else {
                    showModalFeedback(false, `✗ ${data.message || 'Gagal terhubung ke endpoint API.'}`);
                }
            } catch (err) {
                showModalFeedback(false, '✗ Terjadi kegagalan jaringan saat menghubungi server lokal.');
            } finally {
                btnTestConnection.disabled = false;
                testConnText.textContent = 'Tes Koneksi';
            }
        });
    }

    function showModalFeedback(type, message) {
        if (!modalTestFeedback) return;
        modalTestFeedback.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-info');

        if (type === 'loading') {
            modalTestFeedback.className = 'alert alert-info py-2 px-3 small rounded-3 mb-0 d-flex align-items-center gap-2';
            modalTestFeedback.innerHTML = `<div class="spinner-border spinner-border-sm text-info" role="status"></div><span>${message}</span>`;
        } else if (type === true) {
            modalTestFeedback.className = 'alert alert-success py-2 px-3 small rounded-3 mb-0 d-flex align-items-center gap-2';
            modalTestFeedback.innerHTML = `<span class="fw-bold text-success">${message}</span>`;
        } else {
            modalTestFeedback.className = 'alert alert-danger py-2 px-3 small rounded-3 mb-0 d-flex align-items-center gap-2';
            modalTestFeedback.innerHTML = `<span class="fw-bold text-danger">${message}</span>`;
        }
    }

    // Submit Tambah Model LLM Baru via AJAX
    const btnAddModelSubmit = document.getElementById('btnAddModelSubmit');
    if (btnAddModelSubmit) {
        btnAddModelSubmit.addEventListener('click', async function () {
            const name = document.getElementById('modalModelName').value.trim();
            const url = document.getElementById('modalModelUrl').value.trim();
            const apiKey = modalModelApiKey.value.trim();

            if (!name || !url || !apiKey) {
                showModalFeedback(false, 'Semua bidang formulir wajib diisi.');
                return;
            }

            btnAddModelSubmit.disabled = true;
            btnAddModelSubmit.innerHTML = `<div class="spinner-border spinner-border-sm me-1" role="status"></div> Menyimpan...`;

            try {
                const response = await fetch("<?php echo e(route('admin.ai-service.models.store')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        api_url: url,
                        api_key: apiKey
                    })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    // Jika sebelumnya select kosong atau hanya ada opsi disabled placeholder
                    if (aiModelSelect.options.length === 1 && aiModelSelect.options[0].disabled) {
                        aiModelSelect.innerHTML = '';
                    }

                    // Tambahkan model baru ke select option
                    const newOpt = document.createElement('option');
                    newOpt.value = data.model.id;
                    newOpt.textContent = data.model.name;
                    newOpt.selected = true;
                    aiModelSelect.appendChild(newOpt);

                    if (btnDeleteModel) btnDeleteModel.disabled = false;

                    // Trigger event sinkronisasi
                    aiModelSelect.dispatchEvent(new Event('change'));

                    // Tutup modal
                    const modalEl = document.getElementById('addModelModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();

                    // Notifikasi Sukses di Halaman Utama
                    const alertContainer = document.getElementById('dynamicPageAlert');
                    if (alertContainer) {
                        alertContainer.className = 'alert alert-success alert-dismissible fade show shadow-sm mb-4';
                        alertContainer.innerHTML = `
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-success fw-bold">✓</span>
                                <div>${data.message} Model terpilih otomatis.</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                    }

                    // Reset form modal
                    document.getElementById('addModelForm').reset();
                    modalTestFeedback.classList.add('d-none');
                } else {
                    showModalFeedback(false, data.message || 'Gagal menyimpan model LLM.');
                }
            } catch (err) {
                showModalFeedback(false, 'Terjadi kesalahan jaringan.');
            } finally {
                btnAddModelSubmit.disabled = false;
                btnAddModelSubmit.innerHTML = `<span class="me-1">+</span> Tambahkan`;
            }
        });
    }

    // Hapus Model LLM Terpilih
    if (btnDeleteModel && aiModelSelect) {
        btnDeleteModel.addEventListener('click', async function () {
            const selectedVal = aiModelSelect.value;
            const selectedText = aiModelSelect.options[aiModelSelect.selectedIndex]?.text || selectedVal;

            if (!selectedVal) {
                alert('Pilih model yang ingin dihapus terlebih dahulu.');
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menghapus model "${selectedText}"?`)) {
                return;
            }

            btnDeleteModel.disabled = true;
            try {
                const response = await fetch("<?php echo e(route('admin.ai-service.models.delete')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ model_id: selectedVal })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    aiModelSelect.remove(aiModelSelect.selectedIndex);

                    if (aiModelSelect.options.length === 0) {
                        const emptyOpt = document.createElement('option');
                        emptyOpt.value = '';
                        emptyOpt.disabled = true;
                        emptyOpt.selected = true;
                        emptyOpt.textContent = '-- Belum ada model LLM (Klik [+] untuk tambah) --';
                        aiModelSelect.appendChild(emptyOpt);
                        btnDeleteModel.disabled = true;
                        if (cardModelName) cardModelName.textContent = 'Belum Dikonfigurasi';
                        if (sandboxModelBadge) sandboxModelBadge.textContent = 'Belum Terpilih';
                    } else {
                        aiModelSelect.selectedIndex = 0;
                        btnDeleteModel.disabled = false;
                        aiModelSelect.dispatchEvent(new Event('change'));
                    }

                    const alertContainer = document.getElementById('dynamicPageAlert');
                    if (alertContainer) {
                        alertContainer.className = 'alert alert-warning alert-dismissible fade show shadow-sm mb-4';
                        alertContainer.innerHTML = `
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-warning fw-bold">✓</span>
                                <div>${data.message}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                    }
                } else {
                    alert(data.message || 'Gagal menghapus model.');
                    btnDeleteModel.disabled = false;
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan saat menghapus model.');
                btnDeleteModel.disabled = false;
            }
        });
    }

    // Eksekusi Simulator Sandbox LLM secara Real-Time (Tanpa Reload Halaman)
    const btnExecuteSimulator = document.getElementById('btnExecuteSimulator');
    const simulatorPrompt = document.getElementById('simulatorPrompt');
    const simulatorOutput = document.getElementById('simulatorOutput');
    const simBtnText = document.getElementById('simBtnText');

    if (btnExecuteSimulator && simulatorPrompt && simulatorOutput) {
        btnExecuteSimulator.addEventListener('click', async function () {
            const query = simulatorPrompt.value.trim();
            if (!query) {
                alert('Silakan ketik kueri uji coba terlebih dahulu.');
                simulatorPrompt.focus();
                return;
            }

            btnExecuteSimulator.disabled = true;
            simBtnText.textContent = 'Memproses Inferensi LLM...';
            simulatorOutput.textContent = 'Menghubungi kluster mesin inferensi SoraBot...\nGuardrail filter diterapkan: Active\nMenghitung respons konteks logistik maritim...';

            try {
                const response = await fetch("<?php echo e(route('admin.ai-service.simulate')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        test_query: query
                    })
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    simulatorOutput.textContent = data.response;
                } else {
                    simulatorOutput.textContent = 'Gagal memproses simulasi: ' + (data.response || data.message || 'Respons tidak valid dari server.');
                }
            } catch (err) {
                simulatorOutput.textContent = 'Kesalahan jaringan saat melakukan inferensi simulator.';
            } finally {
                btnExecuteSimulator.disabled = false;
                simBtnText.textContent = 'Eksekusi Uji Coba Respon';
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/system/ai-service.blade.php ENDPATH**/ ?>