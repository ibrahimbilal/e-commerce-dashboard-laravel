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
        'breadcrumbs_items' => [['title' => 'users', 'route_name' => 'users.list'], ['title' => 'edit']],
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
                    <label class="item-title" for="mobile">mobile:</label>
                    <input class="form-control" id="mobile" name="mobile" type="tel">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="birth-date">Birth Of Date:</label>
                    <div class="position-relative w-100">
                        <input class="form-control" id="birth-date" name="birth_date" type="text"
                            data-toggle="datepicker">
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
                        <option>administrator</option>
                        <option>store manager</option>
                        <option>accountant</option>
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
                            <input class="form-control" id="password" name="password" type="password">
                            <span class="show-pass"><i class="fi-rr-eye"> </i></span>
                        </div>
                        <button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password"
                            type="button">generate</button>
                    </div>
                    <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                        <label class="item-title" for="confirm-password">confirm password:</label>
                        <div class="with-icon">
                            <input class="form-control" id="confirm-password" name="confirm_password" type="password">
                            <span class="show-pass"><i class="fi-rr-eye"> </i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces">
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Registered At:</label><span class="ms-2">26/03/2021
                        14:58</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Last Logged In:</label><span class="ms-2">26/03/2021
                        14:58</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">Device:</label><span class="ms-2">Samsung Galaxy S20</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP Address:</label><span class="ms-2">216.58.217.164</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP Country:</label><span class="ms-2">United State</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">iP City:</label><span class="ms-2">New York</span>
                </div>
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <button class="btn trans-btn w-100 text-start delete" data-post-type="user"><span
                            class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
                    <button class="btn solid-btn" type="submit">update </button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">Two Factor Authentication</h2>
                    <div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
                        <div class="item-title">
                            <label class="item-title mb-2">status:</label>
                        </div>
                        <div class="item-content">
                            <p class="mb-0">2FA Is Disabled</p><small>When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.</small><br>
                            <button class="btn regular-btn mt-2 text-nowrap" type="button">Enable</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="sessions-list">
                                <div class="session-item">
                                    <div class="icon"> <i class="fi-rr-computer"> </i>
                                    </div>
                                    <div class="details">
                                        <div class="browser">Windows - Chrome</div>
                                        <div class="status"><span class="ip">127.0.0.1,</span><span
                                                class="login this">This device</span></div>
                                    </div>
                                </div>
                                <div class="session-item">
                                    <div class="icon"> <i class="fi-rr-smartphone"> </i>
                                    </div>
                                    <div class="details">
                                        <div class="browser">AndroidOS - Chrome</div>
                                        <div class="status"><span class="ip">127.0.0.1,</span><span
                                                class="login">Last active 15 seconds ago</span></div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn solid-btn mt-3" type="button">Log Out Other Browser Sessions </button>
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
    </form>
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

        // form Ajax Request
        $('form#edit-user').on('submit', function(e) {
            e.preventDefault();
            // var data = $(this).serialize();
            var data = $('#user-language').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('users.update', $user->id) }}",
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
