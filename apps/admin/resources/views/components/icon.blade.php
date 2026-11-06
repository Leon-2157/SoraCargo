@props([
    'name',
    'class' => '',
    'size' => null,
])

@php
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
@endphp

{!! $svgContent !!}

