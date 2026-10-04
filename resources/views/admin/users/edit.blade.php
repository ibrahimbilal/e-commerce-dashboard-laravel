@extends('admin.layout')

@section('title', 'Edit User')

@push('stylesheet')
    <!-- Data Tables -->
    <link href="{{ asset('css/datatables'.$rtl_ext.'.min.css') }}" rel="stylesheet">
    <!-- Date Picker-->
    <link href="{{ asset('css/pickadate.css') }}" rel="stylesheet">
	<!-- Sweet Alert 2 -->
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.users.edit'),
        'breadcrumbs_items' => [['title' => __('admin.menu.users.title'), 'route_name' => 'users.index'], ['title' => __('admin.menu.users.edit')]],
    ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="edit-user" method="POST" enctype="multipart/form-data">
		@method('PUT')
        <div class="col-sm-12 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.user_details') }}</h2>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="first-name">{{ __('forms.first_name') }}</label>
                    <input class="form-control" id="first-name" name="first_name" type="text" value="{{ $user->first_name }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="last-name">{{ __('forms.last_name') }}</label>
                    <input class="form-control" id="last-name" name="last_name" type="text" value="{{ $user->last_name }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="email">{{ __('forms.email') }}</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="mobile">{{ __('forms.mobile') }}</label>
                    <input class="form-control" id="mobile" name="mobile" type="tel" value="{{ $user->mobile }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="birth-date">{{ __('forms.birth_date') }}</label>
                    <div class="position-relative w-100">
                        <input class="form-control" id="birth-date" name="birth_date" type="text"
                            data-toggle="datepicker" data-value="{{ $user->birth_date }}">
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">{{ __('forms.gender.title') }}</label>
                    <label class="radio-label" for="male">
                        <input class="input-radio" id="male" name="gender" type="radio" value="male" @checked($user->gender == 'male')>{{ __('forms.gender.male') }}
                    </label>
                    <label class="radio-label" for="female">
                        <input class="input-radio" id="female" name="gender" type="radio" value="female" @checked($user->gender == 'female')>{{ __('forms.gender.female') }}
                    </label>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-role">{{ __('forms.role.title') }}</label>
                    <select class="form-select w-100 flex-grow-1" id="user-role" name="role_name">
                        @forelse ($roles as $role)
                            <option value="{{ $role->name }}" @selected($user->role_name == $role->name)>
                                {{ $role->name }}
							</option>
						@empty
							<option value="">{{ __('forms.role.no_roles')  }}</option>
						@endforelse
                    </select>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-status">{{ __('forms.status.title') }}</label>
                    <select class="form-select w-100 flex-grow-1" id="user-status" name="status">
                        <option value="not_verified" @selected($user->status == 'not_verified')>{{ __('forms.status.not_verified') }}</option>
                        <option value="verified" @selected($user->status == 'verified')>{{ __('forms.status.verified') }}</option>
                        <option value="blocked" @selected($user->status == 'blocked')>{{ __('forms.status.blocked') }}</option>
                    </select>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-is-active">{{ __('forms.is_active') }}</label>
                    <label class="switch">
                        @if ((int) auth()->id() === (int) $user->id)
                            <input class="switch" id="user-is-active" type="checkbox" @checked($user->is_active) disabled>
                        @else
                            <input type="hidden" name="is_active" value="0">
                            <input class="switch" id="user-is-active" name="is_active" type="checkbox" value="1"
                                @checked(old('is_active', $user->is_active))>
                        @endif
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-language">{{ __('forms.lang') }}</label>
                    <select class="form-select" id="user-language" name="language">
                        <option value="en" @selected($user->language == 'en')>English</option>
                        <option value="ar" @selected($user->language == 'ar')>Arabic</option>
                        <option value="fr" @selected($user->language == 'fr')>French</option>
                    </select>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title mb-2" for="profile-picture">{{ __('forms.profile_picture.title') }}</label>
						<small>{{ __("forms.profile_picture.sub") }}</small>
                    </div>
                    @if ($user->profile_picture)
						<div class="item-content">
							<label for="pp" class="btn regular-btn" style="width: 150px">
								{{ __('buttons.change_image') }}
								<input type="file" name="profile_picture" id="pp" accept=".jpg, .jpeg, .png" style="display: none">
								<input id="remove_pp" type="hidden" name="remove_pp">
							</label>
							<div class="selected-img">
								<div class="img-holder mt-3">
									<img class="preview" src="{{ URL::asset($user->profile_picture) }}" width="70">
									<span class="overlay"><i class="fi-rr-trash"> </i><span>{{ __('buttons.remove') }}</span></span>
								</div>
							</div>
						</div>
					@else
						<div class="item-content">
							<label for="pp" class="btn regular-btn" style="width: 150px">
								{{ __('buttons.upload_image') }}
								<input type="file" name="profile_picture" id="pp" accept=".jpg, .jpeg, .png" style="display: none">
								<input id="remove_pp" type="hidden" name="remove_pp">
							</label>
							<div class="selected-img" style="display: none">
								<div class="img-holder mt-3">
									<img class="preview" width="70">
									<span class="overlay"><i class="fi-rr-trash"> </i><span>{{ __('buttons.remove') }}</span></span>
								</div>
							</div>
						</div>
					@endif
                </div>
            </div>
			<div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">{{ __('admin.sections.password') }}</h2>
                    <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                        <label class="item-title" for="new-password">{{ __('forms.new_password') }}</label>
                        <div class="with-icon">
                            <input class="form-control" id="password" name="password" type="password" autocomplete="off">
                            <span class="show-pass"><i class="fi-rr-eye"> </i></span>
                        </div>
                        <button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password"
                            type="button">{{ __('buttons.generate') }}</button>
                    </div>
                    <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                        <label class="item-title" for="confirm-password">{{ __('forms.confirm_password') }}</label>
                        <div class="with-icon">
                            <input class="form-control" id="confirm-password" name="password_confirmation"
                                type="password" autocomplete="off">
                            <span class="show-pass"><i class="fi-rr-eye"> </i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces">
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.registered_at') }}</label><span
                        class="ms-2">{{ format_date($user->created_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.updated_at') }}</label><span
                        class="ms-2">{{ format_date($user->updated_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.last_login') }}</label><span class="ms-2">{{ end($sessions)->last_active_formated }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.device') }}</label><span class="ms-2">{{ ucfirst($sessions[0]->agent->device) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.ip_address') }}</label><span class="ms-2">{{ $sessions[0]->ip_address }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.ip_country') }}</label><span class="ms-2">{{ $sessions[0]->country }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">{{ __('metas.ip_city') }}</label><span class="ms-2">{{ $sessions[0]->city }}</span>
                </div>
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <a class="btn trans-btn w-100 text-start delete" href="{{ route('users.destroy', $user->id) }}"
						data-confirm-delete="soft"
						data-confirm-ajax
						data-http-method="DELETE"
						data-redirect-on-success
						data-post-type="user"><span
                            class="icon me-1"><i class="fi-rr-trash"> </i></span>{{ __('buttons.delete') }}</a>
                    <button class="btn solid-btn" type="submit">{{ __('buttons.update') }}</button>
                </div>
            </div>
        </div>
	</form>
	<div class="row d-block clearfix">
        <div class="col-sm-12 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">{{ __('admin.sections.sessions') }}</h2>
                    <div class="form-item second mt-3">
						<small>{{ __('admin.pages.users.sessions.desc_1') }}</small>
						<small class="mt-2 d-block">{{ __('admin.pages.users.sessions.desc_2') }}</small>
					</div>
                    <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                        <div class="item-title">
                            <label class="item-title mb-2">{{ __('admin.pages.users.sessions.sub_section') }}</label>
                        </div>
                        <div class="item-content">
							@if (count($sessions) > 0)
								<div class="sessions-list">
									<!-- Other Browser Sessions -->
									@foreach ($sessions as $session)
										<div class="session-item">
											<div class="icon">
												@if ($session->agent->is_desktop)
													<i class="fi-rr-computer"> </i>
												@else
													<i class="fi-rr-smartphone"> </i>
												@endif
											</div>
											<div class="details">
												<div class="browser">{{ $session->agent->platform ? $session->agent->platform : __('admin.unknown') }} - {{ $session->agent->browser ? $session->agent->browser : __('admin.unknown') }}</div>
												<div class="status">
													<span class="ip">{{ $session->ip_address }},</span>
													<span class="login @if($session->is_current_device) this @endif">
														@if ($session->is_current_device)
															{{ __('admin.pages.users.sessions.this_device') }}
														@else
															{{ __('admin.pages.users.sessions.last_active') }} {{ $session->last_active }}
														@endif
													</span>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							@endif
                            {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#confirm-password-modal" class="btn solid-btn mt-3">{{ __('buttons.logout_sesstion') }}</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary">
                    <h2 class="box-title item-title">{{ __('admin.sections.activities') }}</h2>
                    <div class="table-holder mt-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="activities">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">Activiy</th>
                                        <th class="text-uppercase">Post Type</th>
                                        <th class="text-uppercase">Post Title</th>
                                        <th class="text-uppercase">Activity Date</th>
                                        <th class="text-uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="status text-uppercase create">create</td>
                                        <td class="text-capitalize">Product</td>
                                        <td class="text-capitalize">Apple Ipad Pro 64GB</td>
                                        <td>14:58 26/03/2021</td>
                                        <td>
                                            <div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"
                                                    href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye">
                                                        </i></span>view</a></div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <!-- Data Table-->
    <script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
    <!-- Date Picker-->
    <script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script>
        // Data Tables
        let product_table = $('#activities').DataTable({
            dom: 'Bfrtip',
            columnDefs: [{
                    bSortable: false,
                    aTargets: [4]
                },
                {
                    bSearchable: false,
                    aTargets: [0, 1, 2, 3]
                }
            ],
            order: [
                [3, 'desc']
            ],
            language: {
                info: "Show _START_ To _END_ Of _TOTAL_ Activity",
                buttons: {
                    pageLength: 'Show %d',
                    colvis: 'Columns'
                }
            },
            stateSave: true,
            paging: true,
            searching: true,
            lengthMenu: [
                [10, 15, 25, 50, 75, 100],
                ['10 Activities', '15 Activities', '25 Activities', '50 Activities', '75 Activities',
                    '100 Activities'
                ]
            ],
            buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
                extend: 'collection',
                text: 'Export',
                className: 'btn btn-group',
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'dropdown-item'
                    }
                ]
            }, 'colvis'] : ['pageLength', {
                extend: 'collection',
                text: 'Export',
                className: 'btn btn-group',
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'dropdown-item'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'dropdown-item'
                    }
                ]
            }, 'colvis']
        });

		// upload image
		$('#pp').on('change', function () {
			var output = $('.selected-img'),
				file = this.files[0],
				src = URL.createObjectURL(file);

			output.find('.preview').attr('src', src);
			output.find('.img-holder').append('<span class="overlay added" style="opacity:1;padding-top:0;color:#FFF;display: flex;justify-content: center;align-items: center;"><i class="rotate fi-rr-spinner" style="color:#FFF;margin: 0;width: 20px;height: 20px;transform-origin: center;text-align: center;line-height: 26px;"></i></span>');
			output.show(500);
			$('#remove_pp').val('');
			setTimeout(() => {
				output.find('.img-holder').find('.added').fadeOut('100');
			}, 1500);
		});

		// remove image
		$('.overlay').on('click', function() {
			var output = $('.selected-img');
			$('#pp').val('');
			$('#remove_pp').val(true);
			output.hide(500);
			output.find('.added').remove();
			output.find('.preview').removeAttr('src');

		});

		let SwalOptions = {
			showConfirmButton: true,
			confirmButtonColor: 'var(--main-color)',
			confirmButtonText: "{{ __('alerts.btn_text') }}",
			scrollbarPadding: false,
		};

        // form Ajax Request
        $('form#edit-user').on('submit', function(e) {
            e.preventDefault();

			var callAjax = false,
				fileInputElement = document.getElementById("pp");

			if ( fileInputElement.files.length !== 0 ) {

				var fileName = fileInputElement.files[0].name,
					fileSize = fileInputElement.files[0].size / 1024, // File In KB
					fileType = fileInputElement.files[0].type,
					allowTypes = new Array('image/jpeg', 'image/png', 'image/jpg');

					if ($.inArray(fileType, allowTypes) !== -1) {
						callAjax = true;
						if (fileSize < 1024) {
							callAjax = true;
						} else {
							Swal.fire({
								...SwalOptions,
								icon: 'error',
								titleText: "{{ __('alerts.ops') }}",
								html: ["<div class='alerts danger'>",
										"<ul class='list' style='text-align: start'>",
										"<li class='content'>{{ __('alerts.users.request.image_size') }}</li>",
										"</ul>",
										"</div>",].join("\n")
							});
							callAjax = false;
						}
					} else {
						Swal.fire({
							...SwalOptions,
							icon: 'error',
							titleText: "{{ __('alerts.ops') }}",
							html: ["<div class='alerts danger'>",
										"<ul class='list' style='text-align: start'>",
										"<li class='content'>{{ __('alerts.users.request.image_type') }}</li>",
										"</ul>",
										"</div>",].join("\n")
						});
						callAjax = false;
					}

			} else {
				callAjax = true;
			}

			if ( callAjax ) {
				var formData = new FormData(this);
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},
					type: 'POST',
					url: "{{ route('users.update', $user->id) }}",
					data: formData,
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function() {
						Swal.fire({
							...SwalOptions,
							titleText: "{{ __('alerts.request.before_sent_title') }}",
							text: "{{ __('alerts.request.before_sent_text') }}",
							didOpen: () => {
								Swal.showLoading()
							}
						});
					},
					success: function(res) {
						if (res.success) {
							AdminSwalSuccess({
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
			}
        });
    </script>
@endpush
