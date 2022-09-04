@extends('admin.layout')

@section('title', 'Edit User')

@push('stylesheet')
    <!-- Date Picker-->
    <link href="{{ asset('css/pickadate.css') }}" rel="stylesheet">
	<!-- Sweet Alert 2 -->
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.users.add'),
        'breadcrumbs_items' => [['title' => __('admin.menu.users.title'), 'route_name' => 'users.index'], ['title' => __('admin.menu.users.add')]],
    ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="add-user" method="POST" enctype="multipart/form-data">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.user_details') }}</h2>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="first-name">{{ __('forms.first_name') }}</label>
                    <input class="form-control" id="first-name" name="first_name" type="text">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="last-name">{{ __('forms.last_name') }}</label>
                    <input class="form-control" id="last-name" name="last_name" type="text">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="email">{{ __('forms.email') }}</label>
                    <input class="form-control" id="email" name="email" type="email">
                </div>
				<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
					<label class="item-title" for="password">{{ __('forms.password') }}</label>
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
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="mobile">{{ __('forms.mobile') }}</label>
                    <input class="form-control" id="mobile" name="mobile" type="tel">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="birth-date">{{ __('forms.birth_date') }}</label>
                    <div class="position-relative w-100">
                        <input class="form-control" id="birth-date" name="birth_date" type="text" placeholder="mm/dd/yyyy" data-toggle="datepicker">
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">{{ __('forms.gender.title') }}</label>
                    <label class="radio-label" for="male">
                        <input class="input-radio" id="male" name="gender" type="radio" value="male" checked>{{ __('forms.gender.male') }}
                    </label>
                    <label class="radio-label" for="female">
                        <input class="input-radio" id="female" name="gender" type="radio" value="female">{{ __('forms.gender.female') }}
                    </label>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-role">{{ __('forms.role.title') }}</label>
                    <select class="form-select" id="user-role" name="role_name">
						@forelse ( $roles as $role )
							<option value="{{ $role->name }}">{{ $role->name }}</option>
						@empty
							<option value="">{{ __('forms.role.no_roles')  }}</option>
						@endforelse
                    </select>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-language">{{ __('forms.lang') }}</label>
                    <select class="form-select" id="user-language" name="language">
                        <option value="en">English</option>
                        <option value="ar">Arabic</option>
                        <option value="fr">French</option>
                    </select>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
					<div class="item-title d-block mb-2">
                        <label class="item-title mb-2" for="profile-picture">{{ __('forms.profile_picture.title') }}</label>
						<small>{{ __("forms.profile_picture.sub") }}</small>
                    </div>
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
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces">
                <div class="btns-holder d-flex justify-content-between">
                    <button class="btn solid-btn w-100" type="submit">{{ __('buttons.create') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <!-- Date Picker-->
    <script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script>

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
        $('form#add-user').on('submit', function(e) {
            e.preventDefault();

			let SwalOptions = {
				showConfirmButton: true,
				confirmButtonColor: 'var(--main-color)',
				confirmButtonText: "{{ __('alerts.btn_text') }}",
				scrollbarPadding: false,
			};

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
										"<li class='content'>{{ __('alerts.request.image_size') }}</li>",
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
										"<li class='content'>{{ __('alerts.request.image_type') }}</li>",
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
					url: "{{ route('users.store') }}",
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
							Swal.fire({
								...SwalOptions,
								icon: 'success',
								titleText: res.text,
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
			}
        });
    </script>
@endpush
