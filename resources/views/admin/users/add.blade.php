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
        'page_title' => 'Add User',
        'breadcrumbs_items' => [['title' => 'users', 'route_name' => 'users.list'], ['title' => 'add']],
    ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="edit-user" method="POST">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">user details</h2>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="first-name">first name:</label>
                    <input class="form-control" id="first-name" name="first_name" type="text">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="last-name">last name:</label>
                    <input class="form-control" id="last-name" name="last_name" type="text">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="email">email address:</label>
                    <input class="form-control" id="email" name="email" type="email">
                </div>
				<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
					<label class="item-title" for="new-password">password:</label>
					<div class="with-icon">
						<input class="form-control" id="password" name="password" type="password">
						<span class="show-pass"><i class="fi-rr-eye"> </i></span>
					</div>
					<button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password"
						type="button">generate</button>
				</div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="mobile">mobile:</label>
                    <input class="form-control" id="mobile" name="mobile" type="tel">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="birth-date">Birth Of Date:</label>
                    <div class="position-relative w-100">
                        <input class="form-control" id="birth-date" name="birth_date" type="text" placeholder="mm/dd/yyyy" data-toggle="datepicker">
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">gender:</label>
                    <label class="radio-label" for="male">
                        <input class="input-radio" id="male" name="customer_type" type="radio" value="Male"
                            checked>Male
                    </label>
                    <label class="radio-label" for="female">
                        <input class="input-radio" id="female" name="customer_type" type="radio" value="Female">Female
                    </label>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-role">role:</label>
                    <select class="form-select" id="user-role" name="user_role">
						@foreach ( $roles as $role )
							<option value="{{ $role->id }}">{{ $role->title }}</option>
						@endforeach
                    </select>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-status">status:</label>
                    <select class="form-select" id="user-status" name="user_status">
                        <option>not verified</option>
                        <option>verified</option>
                        <option>blocked</option>
                    </select>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="user-language">language:</label>
                    <select class="form-select" id="user-language" name="user_language">
                        <option value="en">English</option>
                        <option value="ar">Arabic</option>
                        <option value="fr">French</option>
                    </select>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                    <div class="item-title">
                        <label class="item-title mb-2" for="profile-picture">Profile Picture:</label>
                    </div>
                    <div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)"
                            style="width: 150px">Change Image</a>
                        <div class="selected-img">
                            <div class="img-holder mt-3"><img class="preview"
                                    src="{{ asset('images/customers/image-1.png') }}" width="70"><span
                                    class="overlay"><i class="fi-rr-trash">
                                    </i><span>remove</span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces">
                <div class="btns-holder d-flex justify-content-between">
                    <button class="btn solid-btn w-100" type="submit">create</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <!-- Date Picker-->
    <script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
    <script>

        // form Ajax Request
        $('form#edit-user').on('submit', function(e) {
            e.preventDefault();
            // var data = $(this).serialize();
            var data = $('#user-language').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('users.create') }}",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                data: {
                    user_language: data
                },
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
                                Object.keys(res.errors).map(k => '<li class="content">' + res
                                    .errors[k] + '</li>').join('') + '</ul></div>',
                            showConfirmButton: true,
                            confirmButtonColor: 'var(--main-color)',
                        });
                    }
                }
            });
        });
    </script>
@endsection
