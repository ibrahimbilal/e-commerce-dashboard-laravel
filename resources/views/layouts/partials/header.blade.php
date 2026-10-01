@php
    $authUser = auth()->user();
    $displayName = $authUser
        ? trim(($authUser->first_name ?? '').' '.($authUser->last_name ?? '')) ?: ($authUser->email ?? 'Account')
        : 'Account';
    $roleName = $authUser?->getRoleNames()?->first();
    $profileUrl = null;
    if ($authUser) {
        if ($authUser->can('edit users') && Route::has('users.edit')) {
            $profileUrl = route('users.edit', $authUser);
        } elseif (Route::has('profile.edit')) {
            $profileUrl = route('profile.edit');
        }
    }
@endphp
<header class="main-box d-flex justify-content-between align-items-center">
<!-- Search Form-->
<div class="search-area d-flex justify-content-between align-items-center">
<div class="action-item d-flex justify-content-between align-items-center me-4 d-lg-none"><span class="icon" id="menu-btn"><i class="fi-rr-menu-burger"> </i></span></div>
</div>
<div class="action-area flex-row-reverse d-flex justify-content-between align-items-center">
<!-- Full Screen -->
<div class="action-item d-flex justify-content-between align-items-center d-none d-sm-flex"><span alt-tooltip="Exit Full Screen" class="icon" flow="left" id="expand" main-tooltip="Full Screen" tooltip="Full Screen"><i class="fi-rr-expand"> </i></span></div>
<!-- Theme Mode-->
<div class="action-item d-flex justify-content-between align-items-center"><span alt-tooltip="Light Mode" class="icon" flow="left" id="theme-mode" main-tooltip="Dark Mode" tooltip="Dark Mode"><i class="fi-rr-moon-stars"> </i></span></div>
<!-- Notifications Button-->
<div class="action-item d-flex justify-content-between align-items-center relative"><span class="icon header-btn" data-window="#notify-window" id="notify"><i class="fi-rr-bell"> </i></span></div>
<!-- Messages Button-->
<div class="action-item d-flex justify-content-between align-items-center"><span class="icon header-btn" data-window="#messages-window" id="messages"><i class="fi-rr-envelope"> </i></span></div>
<!-- User Area-->
<div class="header-btn action-item user-area flex-row-reverse d-flex justify-content-between align-items-center" data-window="#user-window" id="user"><span class="icon"><i class="fi-rr-angle-small-down"> </i></span>
<div class="user-meta d-none d-xl-block me-2 text-end">
    <x-user-avatar :user="$authUser" size="lg" class="me-2"/>
    <div class="user-name">{{ $displayName }}</div>
</div>
</div>
<!-- Notifications-->
<div class="float-window main-box" id="notify-window">
<div class="win-head d-flex justify-content-between align-items-center">
<p class="head-title mb-0">Notifications</p>
</div>
<div class="win-body scrollbar">
<p class="empty-state mb-0">No notifications yet.</p>
</div>
</div>
<!-- Messages-->
<div class="float-window main-box" id="messages-window">
<div class="win-head d-flex justify-content-between align-items-center">
<p class="head-title mb-0">Messages</p>
</div>
<div class="win-body scrollbar">
<p class="empty-state mb-0">No messages yet.</p>
</div>
</div>
<!-- User Options-->
<div class="float-window main-box user-window" id="user-window">
<div class="win-body">
<ul class="notify-list p-0">
@if ($profileUrl)
<li class="notify-item d-flex align-items-center"><a class="link" href="{{ $profileUrl }}">My Account</a></li>
@endif
<li class="notify-item d-flex align-items-center"><form method="POST" action="{{ route('logout') }}" class="d-inline w-100">@csrf<button type="submit" class="link border-0 bg-transparent p-0 text-start">Logout</button></form></li>
</ul>
</div>
</div>
</header>
