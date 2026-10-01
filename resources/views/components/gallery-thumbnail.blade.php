@props(['gallery'])

@php
    $path = $gallery->url ?? '';
    if ($path === '') {
        $src = asset('assets/images/product-placeholder.svg');
    } elseif (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        $src = $path;
    } elseif (str_starts_with($path, 'storage/')) {
        $src = asset($path);
    } else {
        $src = asset('storage/'.ltrim($path, '/'));
    }
@endphp

<img {{ $attributes->merge(['src' => $src, 'alt' => '']) }} />
