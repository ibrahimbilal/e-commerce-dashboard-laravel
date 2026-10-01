@props([
    'subject' => null,
])

@php
    $registeredAt = $subject?->created_at;
    $updatedAt = $subject?->updated_at;
    $lastLogin = data_get($subject, 'last_login_at') ?? data_get($subject, 'last_logged_in_at');
    $ipAddress = data_get($subject, 'ip_address');
    $device = data_get($subject, 'device');
    $ipCountry = data_get($subject, 'ip_country') ?? data_get($subject, 'country');
@endphp

<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">Registered At:</label><span class="ms-2">{{ $registeredAt?->format('H:i d/m/Y') ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">{{ $updatedAt?->format('H:i d/m/Y') ?? '—' }}</span>
</div>
@if ($lastLogin)
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">Last Logged In:</label><span class="ms-2">{{ \Illuminate\Support\Carbon::parse($lastLogin)->format('H:i d/m/Y') }}</span>
</div>
@endif
@if (filled($device))
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">Device:</label><span class="ms-2">{{ $device }}</span>
</div>
@endif
@if (filled($ipAddress))
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">iP Address:</label><span class="ms-2">{{ $ipAddress }}</span>
</div>
@endif
@if (filled($ipCountry))
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">ip country:</label><span class="ms-2">{{ $ipCountry }}</span>
</div>
@endif
