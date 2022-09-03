@extends('admin.layout')

@section('title', 'Add Role')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.roles.add'),
        'breadcrumbs_items' => [['title' => __('admin.menu.roles.title'), 'route_name' => 'roles.index'], ['title' => __('admin.menu.roles.add')]],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <form class="item-form row" id="add-role" method="POST">
        <div class="col-sm-12">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">{{ __('admin.sections.role_name') }}</h2>
                    <input class="form-control" id="role-name" name="role_title" type="text">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8 mb-3">
            <div class="main-box box-spaces mb-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-item primary">
                        <h2 class="box-title item-title mb-0">{{ __('admin.sections.permissions') }}</h2>
                    </div>
                    <div class="select-all">
						<a class="btn btn-primary btn-rounded me-2 py-1 text-capitalize">{{ __('buttons.select_all') }}</a>
                    </div>
                </div>
                <div class="tabs-holder">
                    <div class="tabs-boxs border-none">
                        <div class="tab-box active">
                            <div class="table-responsive">
                                <table class="table mb-0 border-0">
                                    <tbody>
                                        @foreach ($grouped as $title => $items)

											@if ( empty($title) )
												<tr>
													<td class="border-0">
														<div class="alerts warning">
															<ul class="list" style="text-align: start">
																<li class="content">{{ __('admin.pages.roles.no_permissions') }}</li>
															</ul>
														</div>
													</td>
												</tr>
											@else
												<tr class="bg-active">
													<td class="border-0 p-4">
														<h3 class="h6 text-capitalize text-nowrap mb-0">
															<strong>{{ __('admin.menu.' . $title . '.title') }}</strong>
														</h3>
													</td>
													<td class="border-0 p-4">
														<div class="w-100">
															@foreach ($items as $perms)
																@foreach ($perms as $item)
																	<div class="d-flex ms-2">
																		<label class="switch text-start">
																			<input class="switch" type="checkbox"name="permissions[]" value="{{ $item->name }}">
																			<span class="slider"></span>
																		</label>
																		<span class="text-capitalize ms-2">
																			{{ __('admin.prefix.' . permissions_name($item->name, 'prefix')) }}
																			{{ __('admin.menu.' . permissions_name($item->name, 'name') . '.title') }}
																		</span>
																	</div>
																@endforeach
															@endforeach
														</div>
													</td>
												</tr>
											@endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="main-box box-spaces">
                <button class="btn solid-btn w-100" type="submit">{{ __('buttons.create') }}</button>
            </div>
        </div>
        </div>
    </form>

@endsection

@push('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script>
        $('.select-all > a').on('click', function() {
			if ( !$(this).hasClass('clicked') ) {
				$('input[type=checkbox]').attr('checked', 'checked');
				$(this).addClass('clicked');
				$(this).text("{{ __('buttons.unselect_all') }}");
			} else {
				$('input[type=checkbox]').removeAttr('checked');
				$(this).removeClass('clicked');
				$(this).text("{{ __('buttons.select_all') }}");
			}
        });

		let SwalOptions = {
			showConfirmButton: true,
			confirmButtonColor: 'var(--main-color)',
			confirmButtonText: "{{ __('alerts.btn_text') }}",
			scrollbarPadding: false,
		};

        // Ajax Call
        $('form#add-role').on('submit', function(e) {
            e.preventDefault();

            var data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('roles.store') }}",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                data: data,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
							...SwalOptions,
                            icon: 'success',
                            title: res.text,
                            willClose: () => {
                                window.location.replace(res.redirect);
                            }
                        });
                    } else {
						Swal.fire({
							...SwalOptions,
							icon: 'error',
							titleText: "{{ __('alerts.ops') }}",
							html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
								Object.keys(res.errors).map(k => '<li class="content">' + res.errors[k] + '</li>').join('') + '</ul></div>',
						});
					}
				},
				error: function(res) {
					Swal.fire({
						...SwalOptions,
						icon: 'error',
						titleText: "{{ __('alerts.ops') }}",
						html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
							Object.keys(res.responseJSON.errors).map(k => '<li class="content">' + res.responseJSON.errors[k] + '</li>').join('') + '</ul></div>',
					});
				}
            });
        });
    </script>
@endpush
