<aside>
<!-- Side Menu-->
<div class="dashbord-menu main-box menu-padding">
<!-- Menu Header-->
<div class="menu-header"><a href="{{ route('dashboard') }}"><i class="fi-rr-shop"> </i><span class="title">Admin Panel</span></a></div>
<!-- Menu Links-->
<div class="menu-links d-flex flex-column">
<ul class="menu-list-group">
<li class="list-item active"><a href="{{ route('dashboard') }}"><i class="fi-rr-apps"> </i><span class="title">dashboard</span></a></li>
</ul>
<ul class="menu-list-group">
<li class="list-item has-submenu"><a href="{{ route('products.index') }}"><i class="fi-rr-shopping-bag"> </i><span class="title">products</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item"><a href="{{ route('attributes.index') }}"><i class="fi-rr-circle"> </i><span class="title">attributes</span></a></li>
<li class="list-item"><a href="{{ route('reviews.index') }}"><i class="fi-rr-circle"> </i><span class="title">reviews</span></a></li>
</ul>
</li>
<li class="list-item"><a href="{{ route('categories.index') }}"><i class="fi-rr-folder"> </i><span class="title">categories</span></a></li>
<li class="list-item"><a href="{{ route('tags.index') }}"><i class="fi-rr-label"> </i><span class="title">tags</span></a></li>
<li class="list-item has-submenu @if(request()->routeIs('discounts.*', 'coupons.*')) active @endif"><a href="{{ route('discounts.index') }}"><i class="fi-rr-badge-percent"> </i><span class="title">discounts</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item @if(request()->routeIs('coupons.*')) active @endif"><a href="{{ route('coupons.index') }}"><i class="fi-rr-circle"> </i><span class="title">coupons</span></a></li>
</ul>
</li>
</ul>
<ul class="menu-list-group">
<li class="list-item"><a href="{{ route('customers.index') }}"><i class="fi-rr-users"> </i><span class="title">customers</span></a></li>
<li class="list-item @if(request()->routeIs('addresses.*')) active @endif"><a href="{{ route('addresses.index') }}"><i class="fi-rr-marker"> </i><span class="title">addresses</span></a></li>
<li class="list-item has-submenu @if(request()->routeIs('orders.*', 'order-statuses.*')) active @endif"><a href="{{ route('orders.index') }}"><i class="fi-rr-box"> </i><span class="title">order</span><span class="title badge">35</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item @if(request()->routeIs('order-statuses.*')) active @endif"><a href="{{ route('order-statuses.index') }}"><i class="fi-rr-circle"> </i><span class="title">order statuses</span></a></li>
</ul>
</li>
<li class="list-item"><a href="{{ route('invoices.index') }}"><i class="fi-rr-document"> </i><span class="title">invoices</span></a></li>
</ul>
<ul class="menu-list-group">
<li class="list-item has-submenu"><a href="{{ route('analytics.overview') }}"><i class="fi-rr-stats"> </i><span class="title">analytics</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item"><a href="{{ route('analytics.overview') }}"><i class="fi-rr-circle"> </i><span class="title">overview</span></a></li>
</ul>
</li>
<li class="list-item"><a href="{{ route('marketing.index') }}"><i class="fi-rr-megaphone"> </i><span class="title">marketing</span></a></li>
</ul>
<ul class="menu-list-group">
<li class="list-item"><a href="{{ route('users.index') }}"><i class="fi-rr-user"> </i><span class="title">users</span></a></li>
<li class="list-item"><a href="{{ route('roles.index') }}"><i class="fi-rr-key"> </i><span class="title">roles</span></a></li>
</ul>
<ul class="menu-list-group">
<li class="list-item"><a href="{{ route('gallery.index') }}"><i class="fi-rr-picture"> </i><span class="title">gallery</span></a></li>
<li class="list-item"><a href="{{ route('languages.index') }}"><i class="fi-rr-world"> </i><span class="title">languages</span></a></li>
<li class="list-item has-submenu"><a href="{{ route('settings.index') }}"><i class="fi-rr-settings"> </i><span class="title">settings</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item"><a href="{{ route('settings.index') }}"><i class="fi-rr-circle"> </i><span class="title">general</span></a></li>
<li class="list-item"><a href="{{ route('settings.theme') }}"><i class="fi-rr-circle"> </i><span class="title">theme</span></a></li>
<li class="list-item"><a href="{{ route('settings.store') }}"><i class="fi-rr-circle"> </i><span class="title">store</span></a></li>
<li class="list-item"><a href="{{ route('settings.currencies') }}"><i class="fi-rr-circle"> </i><span class="title">currencies</span></a></li>
<li class="list-item"><a href="{{ route('settings.emails') }}"><i class="fi-rr-circle"> </i><span class="title">emails</span></a></li>
<li class="list-item"><a href="./payment-settings.html"><i class="fi-rr-circle"> </i><span class="title">payment</span></a></li>
</ul>
</li>
<li class="list-item has-submenu"><a href="javascript:void(0)"><i class="fi-rr-browser"> </i><span class="title">Errors</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item"><a href="{{ route('errors.400') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">400</span></a></li>
<li class="list-item"><a href="{{ route('errors.401') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">401</span></a></li>
<li class="list-item"><a href="{{ route('errors.403') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">403</span></a></li>
<li class="list-item"><a href="{{ route('errors.404') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">404</span></a></li>
<li class="list-item"><a href="{{ route('errors.500') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">500</span></a></li>
<li class="list-item"><a href="{{ route('errors.503') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">503</span></a></li>
</ul>
</li>
<li class="list-item has-submenu"><a href="javascript:void(0)"><i class="fi-rr-browser"> </i><span class="title">auth pages</span><span class="icon"><i class="fi-rr-angle-small-down"> </i></span></a>
<ul class="submenu">
<li class="list-item"><a href="{{ route('login') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">login</span></a></li>
@if (Route::has('register'))
<li class="list-item"><a href="{{ route('register') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">register</span></a></li>
@endif
<li class="list-item"><a href="{{ route('password.request') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">forgot-password</span></a></li>
<li class="list-item"><a href="{{ route('password.reset', 'sample-token') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">reset-password</span></a></li>
<li class="list-item"><a href="{{ route('two-factor.login') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">2fa-code</span></a></li>
<li class="list-item"><a href="{{ route('two-factor.recovery') }}" target="_blank"><i class="fi-rr-circle"> </i><span class="title">2fa-recovery</span></a></li>
</ul>
</li>
</ul>
<!-- Menu Collaps Button-->
<ul class="menu-list-group">
<li class="list-item" id="collaps"><a href="javascript:void(0)"><i class="fi-rr-list"> </i><span class="title">collaps</span></a></li>
</ul>
</div>
</div>
</aside>
