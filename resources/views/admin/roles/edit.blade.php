@extends('admin.layout')

@section('title', 'Edit Role')

@push('stylesheet')
	<!-- Sweet Alert 2 -->
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.roles.edit'),
        'breadcrumbs_items' => [['title' => __('admin.menu.roles.title'), 'route_name' => 'roles.index'], ['title' => __('admin.menu.roles.edit')]],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <form class="item-form row" id="edit-role" data-post-type="role">
        <div class="col-sm-12">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">{{ __('admin.sections.role_name') }}</h2>
                    <input class="form-control" id="role-title" name="role_title" type="text" value="{{ $role->name }}">
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
																		<input class="switch"
																				type="checkbox"
																				name="permissions[]"
																				value="{{ $item->name }}"
																				@checked(in_array($item->id, $role_permissions))
																				>
																		<span class="slider"></span>
																	</label>
																	<span class="text-capitalize ms-2">
																		{{ __('admin.prefix.' . permissions_name($item->name, 'prefix')) }}
																		{{-- {{ __('admin.menu.' . permissions_name($item->name, 'name') . '.title') }} --}}
																	</span>
																</div>
															@endforeach
														@endforeach
													</div>
												</td>
											</tr>
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
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.created_at') }}</label><span class="ms-2">{{ format_date($role->created_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.updated_at') }}</label><span class="ms-2">{{ format_date($role->updated_at) }}</span>
                </div>
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <a class="btn trans-btn w-100 text-start delete" href="{{ route('roles.destroy', $role->id) }}">
						<span class="icon me-1"><i class="fi-rr-trash"> </i></span>{{ __('buttons.delete') }}
					</a>
                    <button class="btn solid-btn" type="submit">{{ __('buttons.update') }}</button>
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
        $('form#edit-role').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type: 'PUT',
                url: "{{ route('roles.update', $role->id) }}",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                data: data,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            ...SwalOptions,
							icon: 'success',
							titleText: res.text,
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

		// Delete Role
		$('a.trans-btn.delete').on('click', function(e) {
			e.preventDefault();
			Swal.fire({
				...SwalOptions,
				title: "{{ __('alerts.confirm.title') }}",
                text: "{{ __('alerts.confirm.delete.text') }}",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('alerts.confirm.delete.yes') }}",
                cancelButtonText: "{{ __('alerts.confirm.no') }}",
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'DELETE',
						url: "{{ route('roles.destroy', $role->id) }}",
						headers: {
							"X-CSRF-TOKEN": "{{ csrf_token() }}",
						},
						success: function(res) {
							if (res.success) {
								Swal.fire({
									...SwalOptions,
									titleText: res.title,
									text: res.text,
									icon: 'success',
									willClose: () => {
										window.location.replace(res.redirect);
									}
								});
							} else {
								Swal.fire({
									...SwalOptions,
									icon: 'error',
									titleText: "{{ __('alerts.ops') }}",
									html: '<ul class="errors-list">' + Object.keys(res.errors).map(k =>
											'<li class="content">' + res.errors[k] + '</li>').join('') +
										'</ul>',
								});
							}
						}
					});

				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						...SwalOptions,
						title: "{{ __('alerts.cancel.title') }}",
                        text: "{{ __('alerts.cancel.delete.text') }}",
						icon: 'error',
						timer: 1500,
						timerProgressBar: true,
						showConfirmButton: false,
					})
				}
			})
		});
    </script>
@endpush
