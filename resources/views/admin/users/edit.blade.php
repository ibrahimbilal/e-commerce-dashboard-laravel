@extends('admin.layout')

@section('title', 'Edit User')

@section('stylesheet')
    <!-- Data Tables -->
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <!-- Date Picker-->
    <link href="{{ asset('css/pickadate.css') }}" rel="stylesheet">
@endsection

@section('content')
    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Edit User',
        'breadcrumbs_items' => [['title' => 'users', 'route_name' => 'users.index'], ['title' => 'edit']],
    ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="edit-user" method="POST" enctype="multipart/form-data">
		@method('PUT')
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">user details</h2>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="first-name">first name:</label>
                    <input class="form-control" id="first-name" name="first_name" type="text" value="{{ $user->first_name }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="last-name">last name:</label>
                    <input class="form-control" id="last-name" name="last_name" type="text" value="{{ $user->last_name }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="email">email address:</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="mobile">mobile:</label>
                    <input class="form-control" id="mobile" name="mobile" type="tel" value="{{ $user->mobile }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="birth-date">Birth Of Date:</label>
                    <div class="position-relative w-100">
                        <input class="form-control" id="birth-date" name="birth_date" type="text"
                            data-toggle="datepicker" data-value="{{ $user->birth_date }}">
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">gender:</label>
                    <label class="radio-label" for="male">
                        <input class="input-radio" id="male" name="gender" type="radio" value="male" @checked($user->gender == 'male')>Male
                    </label>
                    <label class="radio-label" for="female">
                        <input class="input-radio" id="female" name="gender" type="radio" value="female" @checked($user->gender == 'female')>Female
                    </label>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-role">role:</label>
                    <select class="form-select" id="user-role" name="role_id">
						@foreach ( $roles as $role )
							<option value="{{ $role->id }}" @selected($user->role_id == $role->id)>{{ $role->title }}</option>
						@endforeach
                    </select>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-status">status:</label>
                    <select class="form-select" id="user-status" name="status">
                        <option value="not_verified" @selected($user->status == 'not_verified')>not verified</option>
                        <option value="verified" @selected($user->status == 'verified')>verified</option>
                        <option value="blocked" @selected($user->status == 'blocked')>blocked</option>
                    </select>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-language">language:</label>
                    <select class="form-select" id="user-language" name="language">
                        <option value="en" @selected($user->language == 'en')>English</option>
                        <option value="ar" @selected($user->language == 'ar')>Arabic</option>
                        <option value="fr" @selected($user->language == 'fr')>French</option>
                    </select>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title mb-2" for="profile-picture">Profile Picture:</label>
						<small>{{ __("The Recommended Dimensions Is:\n500 X 500 (PX)") }}</small>
                    </div>
                    @if ($user->profile_picture)
						<div class="item-content">
							<label for="pp" class="btn regular-btn" style="width: 150px">
								Change Image
								<input type="file" name="profile_picture" id="pp" accept=".jpg, .jpeg, .png" style="display: none">
								<input id="remove_pp" type="hidden" name="remove_pp">
							</label>
							<div class="selected-img">
								<div class="img-holder mt-3">
									<img class="preview" src="{{ URL::asset('uploads/'. $user->profile_picture) }}" width="70">
									<span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span>
								</div>
							</div>
						</div>
					@else
						<div class="item-content">
							<label for="pp" class="btn regular-btn" style="width: 150px">
								Upload Image
								<input type="file" name="profile_picture" id="pp" accept=".jpg, .jpeg, .png" style="display: none">
								<input id="remove_pp" type="hidden" name="remove_pp">
							</label>
							<div class="selected-img" style="display: none">
								<div class="img-holder mt-3">
									<img class="preview" width="70">
									<span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span>
								</div>
							</div>
						</div>
					@endif
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces">
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Registered At:</label><span
                        class="ms-2">{{ format_date($user->created_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">updated at:</label><span
                        class="ms-2">{{ format_date($user->updated_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Last Logged In:</label><span class="ms-2">@isset($sessions) {{ end($sessions)->last_active_formated }} @endisset</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Device:</label><span class="ms-2">@isset($sessions) {{ ucfirst($sessions[0]->agent->device) }} @endisset</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP Address:</label><span class="ms-2">@isset($sessions) {{ $sessions[0]->ip_address }} @endisset</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP Country:</label><span class="ms-2">@isset($sessions) {{ $sessions[0]->country }} @endisset</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP City:</label><span class="ms-2">@isset($sessions) {{ $sessions[0]->city }} @endisset</span>
                </div>
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <a class="btn trans-btn w-100 text-start delete" data-post-type="user"><span
                            class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</a>
                    <button class="btn solid-btn" type="submit">update </button>
                </div>
            </div>
        </div>
	</form>
	<div class="row d-block clearfix">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">Browser Sessions</h2>
                    <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap"><small>If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.</small></div>
                    <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                        <div class="item-title">
                            <label class="item-title mb-2">Active Sessions:</label>
                        </div>
                        <div class="item-content">
                            @if ( $sessions !== null && is_array($sessions) && count($sessions) > 0)
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
												<div class="browser">{{ $session->agent->platform ? $session->agent->platform : 'Unknown' }} - {{ $session->agent->browser ? $session->agent->browser : 'Unknown' }}</div>
												<div class="status">
													<span class="ip">{{ $session->ip_address }},</span>
													<span class="login @if($session->is_current_device) this @endif">
														@if ($session->is_current_device)
															{{ __('This device') }}
														@else
															{{ __('Last active') }} {{ $session->last_active }}
														@endif
													</span>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							@else
								<p class="mb-0">{{ __('The user has not yet logged into his account') }}</p>
							@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary">
                    <h2 class="box-title item-title">Activities</h2>
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

@section('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
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
								icon: 'error',
								title: 'Oops...',
								html: "<div class='alerts danger'><ul class='list' style='text-align: start'><li class='content'>{{ __('The image size is more than 1 MB! Please choose another picture') }}</li></ul></div>",
								showConfirmButton: true,
								confirmButtonColor: 'var(--main-color)',
							});
							callAjax = false;
						}
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: "<div class='alerts danger'><ul class='list' style='text-align: start'><li class='content'>{{ __('Please select an image in the format: JPEG, JPG, PNG') }}</li></ul></div>",
							showConfirmButton: true,
							confirmButtonColor: 'var(--main-color)',
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
						"X-CSRF-TOKEN": "{{ csrf_token() }}",
					},
					type: 'POST',
					url: "{{ route('users.update', $user->id) }}",
					data: formData,
					processData: false,
					contentType: false,
					cache: false,
					success: function(res) {
						if (res.success) {
							Swal.fire({
								icon: 'success',
								title: res.success,
								showConfirmButton: true,
								confirmButtonColor: 'var(--main-color)',
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
									Object.keys(res.errors).map(k => '<li class="content">' + res.errors[k] + '</li>').join('') + '</ul></div>',
								showConfirmButton: true,
								confirmButtonColor: 'var(--main-color)',
							});
						}
					},
					error: function(res) {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
								Object.keys(res.responseJSON.errors).map(k => '<li class="content">' + res.responseJSON.errors[k] + '</li>').join('') + '</ul></div>',
							showConfirmButton: true,
							confirmButtonColor: 'var(--main-color)',
						});
					}
				});
			}
        });

		// Delete Role
		$('a.trans-btn.delete').on('click', function(e) {
			e.preventDefault();
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: 'var(--main-color)',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'DELETE',
						url: "{{ route('users.destroy', $user->id) }}",
						headers: {
							"X-CSRF-TOKEN": "{{ csrf_token() }}",
						},
						success: function(res) {
							if (res.success) {
								Swal.fire({
									title: 'Deleted!',
									text: 'User has been deleted.',
									icon: 'success',
									willClose: () => {
										window.location.replace(res.redirect);
									}
								});
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									html: '<ul class="errors-list">' + Object.keys(res.errors).map(k =>
											'<li class="content">' + res.errors[k] + '</li>').join('') +
										'</ul>',
									showConfirmButton: true,
									confirmButtonColor: 'var(--main-color)',
								});
							}
						}
					});

				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						title: 'Cancelled',
						text: 'User is safe :)',
						icon: 'error',
						timer: 1500,
						timerProgressBar: true,
						showConfirmButton: false,
					})
				}
			})
		});
    </script>
@endsection
