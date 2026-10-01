<header class="main-box d-flex justify-content-between align-items-center">
<!-- Search Form-->
<div class="search-area d-flex justify-content-between align-items-center">
<div class="action-item d-flex justify-content-between align-items-center me-4 d-lg-none"><span class="icon" id="menu-btn"><i class="fi-rr-menu-burger"> </i></span></div>
<div class="action-item d-flex justify-content-between align-items-center me-4 d-sm-none"><span class="icon" id="search-btn"><i class="fi-rr-search"> </i></span></div>
<form class="search-form d-none d-sm-block">
<input autocomplete="off" class="search-input" name="s" placeholder="Search Here..." type="text"/>
<button class="submit" type="submit"><i class="fi-rr-search"> </i>
</button>
</form>
</div>
<!-- Mobile Search Form-->
<div class="mobile search-area align-items-center"><span class="close"><i class="fi-rr-cross"> </i></span>
<form class="search-form d-flex">
<input autocomplete="off" class="search-input" name="s" placeholder="Search Here..." type="text"/>
<button class="submit" type="submit"><i class="fi-rr-search"> </i>
</button>
</form>
</div>
<div class="action-area flex-row-reverse d-flex justify-content-between align-items-center">
<!-- Full Screen -->
<div class="action-item d-flex justify-content-between align-items-center d-none d-sm-flex"><span alt-tooltip="Exit Full Screen" class="icon" flow="left" id="expand" main-tooltip="Full Screen" tooltip="Full Screen"><i class="fi-rr-expand"> </i></span></div>
<!-- Theme Mode-->
<div class="action-item d-flex justify-content-between align-items-center"><span alt-tooltip="Light Mode" class="icon" flow="left" id="theme-mode" main-tooltip="Dark Mode" tooltip="Dark Mode"><i class="fi-rr-moon-stars"> </i></span></div>
<!-- Notifications Button-->
<div class="action-item d-flex justify-content-between align-items-center relative"><span class="icon header-btn" data-window="#notify-window" id="notify"><i class="fi-rr-bell"> </i><span class="dot"></span></span></div>
<!-- Messages Button-->
<div class="action-item d-flex justify-content-between align-items-center"><span class="icon header-btn" data-window="#messages-window" id="messages"><i class="fi-rr-envelope"> </i><span class="dot"></span></span></div>
<!-- User Area-->
<div class="header-btn action-item user-area flex-row-reverse d-flex justify-content-between align-items-center" data-window="#user-window" id="user"><span class="icon"><i class="fi-rr-angle-small-down"> </i></span>
<div class="user-name d-none d-xl-block me-2">Jayson Hinrichsen</div><img class="avatar me-2" src="{{ asset('assets/images/avatars/image-01.png') }}"/>
</div>
</div>
<!-- Notifications-->
<div class="float-window main-box" id="notify-window">
<div class="win-head d-flex justify-content-between align-items-center">
<p class="head-title mb-0">Notifications</p><span class="icon mark-as-read"><i class="fi-rr-list-check"> </i></span>
</div>
<div class="win-body scrollbar">
<ul class="notify-list p-0">
<li class="notify-item d-flex align-items-center">
<div class="img me-2 doted"><img class="avatar" src="{{ asset('assets/images/avatars/image-02.png') }}" width="56"/></div>
<div class="content">
<p><b>Vince Fleming</b> has Changed <b>"Austin Wade"</b> Order Status</p><span class="date">5 min ago</span>
</div>
</li>
<li class="notify-item d-flex align-items-center">
<div class="img me-2 doted"><img class="avatar" src="{{ asset('assets/images/products/image-4.png') }}" width="56"/></div>
<div class="content">
<p><b>Austin Wade</b> has requested a new order </p><span class="date">15 min ago</span>
</div>
</li>
<li class="notify-item d-flex align-items-center">
<div class="img me-2"><img class="avatar" src="{{ asset('assets/images/avatars/image-03.png') }}" width="56"/></div>
<div class="content">
<p><b>Daniil Lobachev</b> has Published a new product</p><span class="date">25 min ago</span>
</div>
</li>
<li class="notify-item d-flex align-items-center">
<div class="img me-2 doted"><img class="avatar" src="{{ asset('assets/images/avatars/image-02.png') }}" width="56"/></div>
<div class="content">
<p><b>Vince Fleming</b> has Changed <b>"Austin Wade"</b> Order Status</p><span class="date">5 min ago</span>
</div>
</li>
<li class="notify-item d-flex align-items-center">
<div class="img me-2 doted"><img class="avatar" src="{{ asset('assets/images/products/image-4.png') }}" width="56"/></div>
<div class="content">
<p><b>Austin Wade</b> has requested a new order </p><span class="date">15 min ago</span>
</div>
</li>
<li class="notify-item d-flex align-items-center">
<div class="img me-2"><img class="avatar" src="{{ asset('assets/images/avatars/image-03.png') }}" width="56"/></div>
<div class="content">
<p><b>Daniil Lobachev</b> has Published a new product</p><span class="date">25 min ago</span>
</div>
</li>
</ul>
</div>
<div class="win-footer"> <a class="view-all" href="#">View All</a></div>
</div>
<!-- Messages-->
<div class="float-window main-box" id="messages-window">
<div class="win-head d-flex justify-content-between align-items-center">
<p class="head-title mb-0">Messages</p><span class="icon mark-as-read"><i class="fi-rr-eye"> </i></span>
</div>
<div class="win-body scrollbar">
<ul class="notify-list p-0">
<li class="notify-item d-flex align-items-center">
<div class="img me-2 doted"><img class="avatar" src="{{ asset('assets/images/avatars/image-02.png') }}" width="56"/></div>
<div class="content">
<div class="name">Vince Fleming</div>
<div class="msg">please talk to me</div><span class="date">5 min ago</span>
</div>
</li>
<li class="notify-item d-flex align-items-center">
<div class="img me-2"><img class="avatar" src="{{ asset('assets/images/avatars/image-03.png') }}" width="56"/></div>
<div class="content">
<div class="name">Daniil Lobachev</div>
<div class="msg">I published the product on the product</div><span class="date">25 min ago</span>
</div>
</li>
</ul>
</div>
<div class="win-footer"> <a class="view-all" href="#">View All</a></div>
</div>
<!-- User Options-->
<div class="float-window main-box user-window" id="user-window">
<div class="win-body">
<ul class="notify-list p-0">
<li class="notify-item d-flex align-items-center"><a class="link" href="#">My Account</a></li>
<li class="notify-item d-flex align-items-center"><form method="POST" action="{{ route('logout') }}" class="d-inline w-100">@csrf<button type="submit" class="link border-0 bg-transparent p-0 text-start">Logout</button></form></li>
</ul>
</div>
</div>
</header>
