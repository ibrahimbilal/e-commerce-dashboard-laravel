@props([
    'user' => null,
    'size' => 'md',
])

@php
    $user = $user ?? auth()->user();
    $sizeClass = match ($size) {
        'sm' => 'avatar-initials-sm',
        'lg' => 'avatar-initials-lg',
        default => '',
    };

    $avatarUrl = $user?->avatar_url ?? null;
    if (! $avatarUrl && filled($user?->profile_picture)) {
        $avatarUrl = asset($user->profile_picture);
    }

    $initials = '—';
    if ($user) {
        $first = trim((string) ($user->first_name ?? ''));
        $last = trim((string) ($user->last_name ?? ''));
        if ($first !== '' || $last !== '') {
            $initials = strtoupper(substr($first, 0, 1).substr($last, 0, 1));
        } elseif (filled($user->email)) {
            $initials = strtoupper(substr($user->email, 0, 2));
        }
    }
@endphp

@if ($avatarUrl)
    <img {{ $attributes->merge(['class' => 'avatar me-2', 'src' => $avatarUrl, 'alt' => '']) }} />
@else
    <span {{ $attributes->merge(['class' => 'avatar-initials me-2 '.$sizeClass, 'aria-hidden' => 'true']) }}>{{ $initials }}</span>
@endif
