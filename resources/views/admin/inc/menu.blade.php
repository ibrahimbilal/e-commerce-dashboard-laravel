<!-- Side Menu-->
<div class="dashbord-menu main-box menu-padding">
    <!-- Menu Header-->
    <div class="menu-header">
		<a href="{{ route('admin.index') }}">
			<i class="fi-rr-shop"> </i>
			<span class="title">Admin Panel</span>
		</a>
    </div>
    <!-- Menu Links-->
    <div class="menu-links d-flex flex-column">
		@php
			$menu_groups = array_to_object(get_dashboard_menu())
		@endphp
		@foreach ($menu_groups as $menu)
			<ul class="menu-list-group">
				@foreach ($menu as $menu_item)
					<li class="list-item {{ $menu_item->has_submeu ? 'has-submenu' : '' }} {{ in_array(Route::currentRouteName(), $menu_item->active_if) ? 'active' : '' }}">
						<a href="{{ $menu_item->route_name ? route($menu_item->route_name ) : 'javascript:void(0)' }}">
							<i class="fi-rr-{{ $menu_item->icon }}"> </i>
							<span class="title">{{ $menu_item->title }}</span>
							@if( $menu_item->badge )
								<span class="title badge">{{ $menu_item->badge }}</span>
							@endif
							@if ( $menu_item->has_submeu )
								<span class="icon">
									<i class="fi-rr-angle-small-down">
									</i>
								</span>
							@endif
						</a>
						@if ( $menu_item->has_submeu )
							<ul class="submenu">
								@foreach ( $menu_item->submenu_items as $sub_items )
									<li class="list-item {{ in_array(Route::currentRouteName(), $sub_items->active_if) ? 'active' : '' }}">
										<a href="{{ $sub_items->route_name ? route($sub_items->route_name) : 'javascript:void(0)' }}">
											<i class="fi-rr-circle"> </i>
											<span class="title">{{ $sub_items->title }}</span>
										</a>
									</li>
								@endforeach
							</ul>
						@endif
					</li>
				@endforeach
			</ul>
		@endforeach

        <!-- Menu Collaps Button-->
        <ul class="menu-list-group">
            <li class="list-item" id="collaps">
				<a href="javascript:void(0)">
					<i class="fi-rr-list"> </i>
					<span class="title">collaps</span>
				</a>
			</li>
        </ul>
    </div>
</div>
