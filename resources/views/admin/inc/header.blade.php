<header class="main-box d-flex justify-content-between align-items-center">
    <!-- Search Form-->
    <div class="search-area d-flex justify-content-between align-items-center">
        <div class="action-item d-flex justify-content-between align-items-center me-4 d-lg-none">
			<span class="icon" id="menu-btn"><i class="fi-rr-menu-burger"> </i></span>
		</div>
        <div class="action-item d-flex justify-content-between align-items-center me-4 d-sm-none">
			<span class="icon" id="search-btn"><i class="fi-rr-search"> </i></span>
		</div>
        <form class="search-form d-none d-sm-block">
            <input class="search-input" type="text" name="s" placeholder="{{ __('admin.header.search.placeholder') }}" autocomplete="off">
            <button class="submit" type="submit"><i class="fi-rr-search"> </i></button>
        </form>
    </div>
    <!-- Mobile Search Form-->
    <div class="mobile search-area align-items-center"><span class="close"><i class="fi-rr-cross"> </i></span>
        <form class="search-form d-flex">
            <input class="search-input" type="text" name="s" placeholder="{{ __('admin.header.search.placeholder') }}" autocomplete="off">
            <button class="submit" type="submit"><i class="fi-rr-search"> </i></button>
        </form>
    </div>
    <div class="action-area flex-row-reverse d-flex justify-content-between align-items-center">
        <!-- Full Screen -->
        <div class="action-item d-flex justify-content-between align-items-center d-none d-sm-flex">
			<span class="icon"
					id="expand"
					tooltip="{{ __('admin.header.tooltips.full_screen') }}"
					main-tooltip="{{ __('admin.header.tooltips.full_screen') }}"
					alt-tooltip="{{ __('admin.header.tooltips.exit_full_screen') }}"
					flow="left">
				<i class="fi-rr-expand"> </i>
			</span>
		</div>
        <!-- Theme Mode-->
        <div class="action-item d-flex justify-content-between align-items-center">
			<span class="icon"
				id="theme-mode"
                tooltip="{{ __('admin.header.tooltips.dark_mode') }}"
				main-tooltip="{{ __('admin.header.tooltips.dark_mode') }}"
				alt-tooltip="{{ __('admin.header.tooltips.light_mode') }}"
				flow="left">
				<i class="fi-rr-moon-stars"> </i>
			</span>
		</div>
        <!-- Notifications Button-->
        <div class="action-item d-flex justify-content-between align-items-center relative"><span
                class="icon header-btn" id="notify" data-window="#notify-window"><i class="fi-rr-bell"> </i><span
                    class="dot"></span></span></div>
        <!-- Messages Button-->
        <div class="action-item d-flex justify-content-between align-items-center"><span class="icon header-btn"
                id="messages" data-window="#messages-window"><i class="fi-rr-envelope"> </i><span
                    class="dot"></span></span></div>
        <!-- User Area-->
        <div class="header-btn action-item user-area flex-row-reverse d-flex justify-content-between align-items-center"
            id="user" data-window="#user-window"><span class="icon"><i class="fi-rr-angle-small-down">
                </i></span>
            <div class="user-name d-none d-xl-block me-2">{{ user_full_name() }}</div>
			@if (Auth::user()->profile_picture)
				<img class="avatar me-2" src="{{ URL::asset(Auth::user()->profile_picture) }}">
			@else
				<img class="avatar me-2" src="{{ asset('images/avatars/' . Auth::user()->gender . '-avatar.png') }}">
			@endif
        </div>
    </div>
    <!-- Notifications-->
    <div class="float-window main-box" id="notify-window">
        <div class="win-head d-flex justify-content-between align-items-center">
            <p class="head-title mb-0">{{ __('admin.header.notifications.title') }}</p>
			<span class="icon mark-as-read" title="{{ __('admin.header.mark_all_read') }}"><i class="fi-rr-list-check"> </i></span>
        </div>
        <div class="win-body scrollbar">
            <ul class="notify-list p-0 m-0">
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2 doted"><img class="avatar" width="56"
                            src="{{ asset('/images/avatars/image-02.png') }}"></div>
                    <div class="content">
                        <p><b>Vince Fleming</b> has Changed <b>"Austin Wade"</b> Order Status</p><span class="date">5
                            min ago</span>
                    </div>
                </li>
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2 doted"><img class="avatar" width="56"
                            src="{{ asset('/images/products/image-4.png') }}"></div>
                    <div class="content">
                        <p><b>Austin Wade</b> has requested a new order </p><span class="date">15 min ago</span>
                    </div>
                </li>
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2"><img class="avatar" width="56"
                            src="{{ asset('/images/avatars/image-03.png') }}"></div>
                    <div class="content">
                        <p><b>Daniil Lobachev</b> has Published a new product</p><span class="date">25 min ago</span>
                    </div>
                </li>
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2 doted"><img class="avatar" width="56"
                            src="{{ asset('/images/avatars/image-02.png') }}"></div>
                    <div class="content">
                        <p><b>Vince Fleming</b> has Changed <b>"Austin Wade"</b> Order Status</p><span class="date">5
                            min ago</span>
                    </div>
                </li>
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2 doted"><img class="avatar" width="56"
                            src="{{ asset('/images/products/image-4.png') }}"></div>
                    <div class="content">
                        <p><b>Austin Wade</b> has requested a new order </p><span class="date">15 min ago</span>
                    </div>
                </li>
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2"><img class="avatar" width="56"
                            src="{{ asset('/images/avatars/image-03.png') }}"></div>
                    <div class="content">
                        <p><b>Daniil Lobachev</b> has Published a new product</p><span class="date">25 min ago</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="win-footer"> <a class="view-all" href="#">{{ __('admin.header.view_all') }}</a></div>
    </div>
    <!-- Messages-->
    <div class="float-window main-box" id="messages-window">
        <div class="win-head d-flex justify-content-between align-items-center">
            <p class="head-title mb-0">{{ __('admin.header.messages.title') }}</p>
			<span class="icon mark-as-read" title="{{ __('admin.header.mark_all_read') }}"><i class="fi-rr-eye"> </i></span>
        </div>
        <div class="win-body scrollbar">
            <ul class="notify-list p-0 m-0">
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2 doted"><img class="avatar" width="56"
                            src="{{ asset('/images/avatars/image-02.png') }}"></div>
                    <div class="content">
                        <div class="name">Vince Fleming</div>
                        <div class="msg">please talk to me</div><span class="date">5 min ago</span>
                    </div>
                </li>
                <li class="notify-item d-flex align-items-center">
                    <div class="img me-2"><img class="avatar" width="56"
                            src="{{ asset('/images/avatars/image-03.png') }}"></div>
                    <div class="content">
                        <div class="name">Daniil Lobachev</div>
                        <div class="msg">I published the product on the product</div><span class="date">25 min ago</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="win-footer"> <a class="view-all" href="#">{{ __('admin.header.view_all') }}</a></div>
    </div>
    <!-- User Options-->
    <div class="float-window main-box user-window pb-3" id="user-window">
        <div class="win-body">
            <ul class="notify-list p-0 m-0">
                <li class="notify-item d-flex align-items-center">
					<a class="link" href="{{ route('users.profile') }}">{{ __('admin.header.profile') }}</a>
                </li>
                <li class="notify-item d-flex align-items-center">
					<form action="{{route('logout')}}" method="POST">
						@csrf
						<button class="btn text-start trans-btn link" type="submit">{{ __('admin.header.logout') }}</button>
					</form>
				</li>
            </ul>
        </div>
    </div>
</header>
