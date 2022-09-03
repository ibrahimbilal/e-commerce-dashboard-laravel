<div class="page-header">
    <div class="row">
        <div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
            <!-- Page Title-->
            <div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
                <h1 class="page-title">{{ $page_title }}</h1>
				@if ( isset($add_route_name) )
					<a class="add-btn btn text-capitalize" href="{{ route($add_route_name) }}"><span class="icon"><i class="fi-rr-add"> </i></span>{{ __('buttons.add_new') }}</a>
				@endif
            </div>
            <!-- Breadcrumbs-->
            <div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
                <div class="breadcrumbs d-flex justify-content-between align-items-center">
                    {{-- Fixed Items --}}
                    <a class="item text-capitalize d-flex justify-content-between align-items-center"
                        href="{{ route('admin.index') }}">
                        <span class="icon">
                            <i class="fi-rr-apps"> </i>
                        </span> {{ __('admin.menu.dashboard.title') }}
                    </a>
                    <span class="angle">
                        <span class="icon">
							@if (!is_rtl())
								<i class="fi-rr-angle-double-right"></i>
							@else
								<i class="fi-rr-angle-double-left"></i>
							@endif
                        </span>
                    </span>
                    {{-- Dynamic Items --}}

                    @foreach ($breadcrumbs_items as $index => $item)
						@if (count($breadcrumbs_items) == 1)
							<span class="item text-capitalize d-flex justify-content-between align-items-center">{{ $item }}</span>
						@elseif (count( $breadcrumbs_items ) != $index + 1)
							@if (isset(array_to_object($item)->route_name))
								<a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route(array_to_object($item)->route_name) }}">{{ array_to_object($item)->title }}</a>
							@else
								<span class="item text-capitalize d-flex justify-content-between align-items-center">{{ array_to_object($item)->title }}</span>
							@endif
							<span class="angle">
								<span class="icon">
									@if (!is_rtl())
										<i class="fi-rr-angle-double-right"></i>
									@else
										<i class="fi-rr-angle-double-left"></i>
									@endif
								</span>
							</span>
                        @else
                            <span class="item text-capitalize d-flex justify-content-between align-items-center">{{ array_to_object($item)->title }}</span>
						@endif
					@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
