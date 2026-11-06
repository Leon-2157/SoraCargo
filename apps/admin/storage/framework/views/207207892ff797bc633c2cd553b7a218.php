<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'class' => '',
    'size' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name',
    'class' => '',
    'size' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $iconName = strtolower(trim($name));
    $filePath = public_path("assets/icons/lucide/{$iconName}.svg");
    
    if (!file_exists($filePath)) {
        // Fallback aliases
        $aliases = [
            'dashboard' => 'layout-dashboard',
            'home' => 'layout-dashboard',
            'manifest' => 'file-text',
            'operator' => 'user-cog',
            'operators' => 'user-cog',
            'retail' => 'user',
            'corporate' => 'building-2',
            'escrow' => 'vault',
            'invoice' => 'file-text',
            'invoices' => 'file-text',
            'tariffs' => 'tags',
            'ports' => 'anchor',
            'hscode' => 'barcode',
            'staff' => 'badge-check',
            'gateways' => 'message-circle',
            'ai' => 'bot',
            'audit' => 'shield',
            'emergency' => 'alert-triangle',
            'whatsapp' => 'brand-whatsapp',
            'check' => 'check-circle-2',
            'clock' => 'clock',
            'warning' => 'alert-triangle',
            'danger' => 'alert-circle',
        ];
        $alias = $aliases[$iconName] ?? 'circle';
        $filePath = public_path("assets/icons/lucide/{$alias}.svg");
    }

    $svgContent = file_exists($filePath) ? file_get_contents($filePath) : '';

    // Merge class attributes
    $baseClass = 'lucide-icon inline-block align-middle';
    $customClass = trim("{$baseClass} {$class}");

    if ($svgContent) {
        if ($size) {
            $svgContent = preg_replace('/width="1em" height="1em"/', 'width="' . e($size) . '" height="' . e($size) . '"', $svgContent, 1);
        }
        $svgContent = preg_replace('/<svg /', '<svg class="' . e($customClass) . '" ', $svgContent, 1);
    }
?>

<?php echo $svgContent; ?>


<?php /**PATH /home/leon/Downloads/SoraCargo/apps/admin/resources/views/components/icon.blade.php ENDPATH**/ ?>