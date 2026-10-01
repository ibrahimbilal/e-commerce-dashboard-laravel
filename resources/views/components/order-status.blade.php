@props([
    'status' => null,
])

@php
    $title = match (true) {
        is_object($status) => (string) ($status->title ?? ''),
        is_string($status) => $status,
        default => '',
    };
    $displayTitle = trim($title) !== '' ? trim($title) : '—';
    $normalized = strtolower(str_replace(['-', '_'], ' ', trim($title)));

    $colorClass = match (true) {
        in_array($normalized, ['completed', 'delivered', 'paid'], true) => 'success',
        in_array($normalized, ['pending', 'on hold'], true) => 'warning',
        in_array($normalized, ['cancelled', 'canceled', 'failed'], true) => 'danger',
        in_array($normalized, ['processing', 'shipped'], true) => 'primary',
        $normalized === 'refunded' => 'dark',
        default => '',
    };

    $cellClass = trim('status text-capitalize '.$colorClass);
@endphp

<td {{ $attributes->merge(['class' => $cellClass]) }}>{{ $displayTitle }}</td>
