@extends('admin.layout')

@section('title', 'Profile')

@section('stylesheet')
    <!-- Data Tables -->
    {{-- <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"> --}}
    <!-- Date Picker-->
    <link href="{{ asset('css/pickadate.css') }}" rel="stylesheet">
@endsection

@section('content')
    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Profile',
        'breadcrumbs_items' => [['title' => 'users', 'route_name' => 'users.index'], ['title' => 'profile']],
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
                    <input class="form-control" id="first-name" name="first_name" type="text"
                        value="{{ $user->first_name }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="last-name">last name:</label>
                    <input class="form-control" id="last-name" name="last_name" type="text"
                        value="{{ $user->last_name }}">
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
                        <input class="input-radio" id="male" name="gender" type="radio" value="male"
						@checked($user->gender == 'male')>Male
                    </label>
                    <label class="radio-label" for="female">
                        <input class="input-radio" id="female" name="gender" type="radio" value="female"
						@checked($user->gender == 'female')>Female
                    </label>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-role">role:</label>
                    <select class="form-select" id="user-role" name="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                                {{ $role->title }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-status">status:</label>
                    <select class="form-select" id="user-status" name="status">
                        <option value="not_verified" @selected($user->status == 'not_verified')>not verified
                        </option>
                        <option value="verified" @selected($user->status == 'verified')>verified</option>
                        <option value="blocked" @selected($user->status == 'blocked')>blocked</option>
                    </select>
                </div> --}}
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
									<img class="preview" src="{{ URL::asset($user->profile_picture) }}" width="70">
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
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">Change Password</h2>
                    <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                        <label class="item-title" for="current-password">current password:</label>
                        <div class="with-icon">
                            <input class="form-control" id="current-password" name="current_password" type="password"
                                autocomplete="off">
                            <span class="show-pass"><i class="fi-rr-eye"> </i></span>
                        </div>
                    </div>
                    <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                        <label class="item-title" for="new-password">new password:</label>
                        <div class="with-icon">
                            <input class="form-control" id="password" name="password" type="password" autocomplete="off">
                            <span class="show-pass"><i class="fi-rr-eye"> </i></span>
                        </div>
                        <button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password"
                            type="button">generate</button>
                    </div>
                    <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                        <label class="item-title" for="confirm-password">confirm password:</label>
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
                    <label class="item-title meta-title">Registered At:</label><span
                        class="ms-2">{{ format_date($user->created_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">updated at:</label><span
                        class="ms-2">{{ format_date($user->updated_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Last Logged In:</label><span class="ms-2">{{ end($sessions)->last_active_formated }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Device:</label><span class="ms-2">{{ ucfirst($sessions[0]->agent->device) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP Address:</label><span class="ms-2">{{ $sessions[0]->ip_address }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP Country:</label><span class="ms-2">{{ $sessions[0]->country }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP City:</label><span class="ms-2">{{ $sessions[0]->city }}</span>
                </div>
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <button class="btn solid-btn w-100" type="submit">update</button>
                </div>
            </div>
        </div>
    </form>
    <div class="row d-block clearfix">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">Two Factor Authentication</h2>
                    <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                        <div class="item-title">
                            <label class="item-title mb-2">status:</label>
                        </div>
                        <div class="item-content">
                            @if (!$user->two_factor_secret)
                                <p class="mb-0">2FA Is Disabled</p>
								<small>{{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}</small><br>
                                <form method="POST" action="{{ route('two-factor.enable') }}">
                                    @csrf
									<button class="btn regular-btn mt-2 text-nowrap" type="submit">{{ __('Enable') }}</button>
                                </form>
                            @else
                                <p class="mb-0">You have enabled 2FA.</p>
                                <small>{{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}</small><br>

                                @if (session('status') == 'two-factor-authentication-enabled' || !$user->two_factor_confirmed_at)
									<br>
									<small>{{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code') }}</small><br>
									<br>
									{!! $user->twoFactorQrCodeSvg() !!}
									<br>
									<br>
									<p class="mb-0">
										{{ __('Setup Key') }}: {{ decrypt($user->two_factor_secret) }}
									</p>
									<form id="create-two-factor-authentication" method="POST" action="{{ route('two-factor.confirm') }}">
										@csrf
										<div class="form-item second mt-3">
											<input class="form-control" name="code" type="text" required>
										</div>
									</form>
									<button class="btn solid-btn mt-3 me-2 text-nowrap" form="create-two-factor-authentication" type="submit">Confirm</button>
									<button class="btn trans-btn mt-3 text-nowrap" form="delete-two-factor-authentication" type="submit">Cancle</button>
                                @endif

                                <div class="recovery-codes-wrapper"></div>

                                <div class="d-flex justify-content-between">
									@if ( $user->two_factor_confirmed_at )
										<button
											id="show-recovery-codes"
											class="btn regular-btn me-3 text-nowrap w-100"
											type="button">Show Recovery Codes</button>

											<button class="btn solid-btn solid-danger-btn text-nowrap" form="delete-two-factor-authentication" type="submit">Disable</button>
									@endif
                                </div>
								<form id="delete-two-factor-authentication" method="POST" action="{{ route('two-factor.disable') }}" style="display: none">
									@csrf
									@method('DELETE')
								</form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary">
                    <h2 class="box-title item-title">Browser Sessions</h2>
                    <div class="form-item second mt-3">
						<small>Manage and log out your active sessions on other browsers and devices.</small>
						<small class="mt-2 d-block">If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.</small>
					</div>
                    <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                        <div class="item-title">
                            <label class="item-title mb-2">Active Sessions:</label>
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
							@endif
                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirm-password-modal" class="btn solid-btn mt-3">Log Out Other Browser Sessions </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- Logout Modal -->
	<div class="modal fade" id="confirm-password-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Confirm Password</h5>
				</div>
				<div class="modal-body">
					<p>For securty reasons please confirm your password.</p>
					<form id="conf-pass" method="POST" action="{{ route('users.logout_sessions') }}">
						@csrf
						<div class="form-item second">
							<div class="with-icon">
								<input class="form-control" id="2fa-conf-password" name="password" type="password">
								<span class="show-pass"><i class="fi-rr-eye"> </i></span>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn regular-btn" data-bs-dismiss="modal">Close</button>
					<button type="submit" form="conf-pass" class="btn solid-btn">Confirm</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <!-- Data Table-->
    {{-- <script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script> --}}
    <!-- Date Picker-->
    <script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script>
        // Data Tables
        // let product_table = $('#activities').DataTable({
        //     dom: 'Bfrtip',
        //     columnDefs: [{
        //             bSortable: false,
        //             aTargets: [4]
        //         },
        //         {
        //             bSearchable: false,
        //             aTargets: [0, 1, 2, 3]
        //         }
        //     ],
        //     order: [
        //         [3, 'desc']
        //     ],
        //     language: {
        //         info: "Show _START_ To _END_ Of _TOTAL_ Activity",
        //         buttons: {
        //             pageLength: 'Show %d',
        //             colvis: 'Columns'
        //         }
        //     },
        //     stateSave: true,
        //     paging: true,
        //     searching: true,
        //     lengthMenu: [
        //         [10, 15, 25, 50, 75, 100],
        //         ['10 Activities', '15 Activities', '25 Activities', '50 Activities', '75 Activities',
        //             '100 Activities'
        //         ]
        //     ],
        //     buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
        //         extend: 'collection',
        //         text: 'Export',
        //         className: 'btn btn-group',
        //         buttons: [{
        //                 extend: 'excelHtml5',
        //                 className: 'dropdown-item'
        //             },
        //             {
        //                 extend: 'csvHtml5',
        //                 className: 'dropdown-item'
        //             },
        //             {
        //                 extend: 'pdfHtml5',
        //                 className: 'dropdown-item'
        //             }
        //         ]
        //     }, 'colvis'] : ['pageLength', {
        //         extend: 'collection',
        //         text: 'Export',
        //         className: 'btn btn-group',
        //         buttons: [{
        //                 extend: 'excelHtml5',
        //                 className: 'dropdown-item'
        //             },
        //             {
        //                 extend: 'csvHtml5',
        //                 className: 'dropdown-item'
        //             },
        //             {
        //                 extend: 'pdfHtml5',
        //                 className: 'dropdown-item'
        //             }
        //         ]
        //     }, 'colvis']
        // });

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

        // Show Recovery codes
        $('#show-recovery-codes').on('click', function() {
			var $this = $(this);
			if ( $this.hasClass('hide') ) {
				$('.recovery-codes-wrapper').html('');
				$this.text('Show Recovery Codes');
				$this.removeClass('hide').addClass('show');
			} else {
				$.ajax({
					type: 'POST',
					url: "{{ route('users.show_recovery_code', $user->id) }}",
					headers: {
						"X-CSRF-TOKEN": "{{ csrf_token() }}",
					},
					success: function(res) {
						$('.recovery-codes-wrapper').append('<small>' + res.notify +
							'</small><div class="codes-list">' + Object.keys(res.codes).map(k =>
								'<div class="code">' + res.codes[k] + '</div>').join('') + '</div>');
						$this.text('Hide Recovery Codes');
						$this.removeClass('show').addClass('hide');
					}
				});
			}
        });

		// Open BS Modal

    </script>

	@if (session('error'))
		<script>
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-start',
				showConfirmButton: false,
				timer: 2500,
				timerProgressBar: false,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			});

			Toast.fire({
				icon: 'error',
				title: "{{ session('error') }}"
			});

		</script>
	@endif
	@if (session('success'))
		<script>
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-start',
				showConfirmButton: false,
				timer: 2500,
				timerProgressBar: false,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			});

			Toast.fire({
				icon: 'success',
				title: "{{ session('success') }}"
			});

		</script>
	@endif
@endsection
