@extends('admin.layout')

@section('title', 'Add Role')

@section('stylesheet')

@endsection

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Add Role',
        'breadcrumbs_items' => [['title' => 'roles', 'route_name' => 'roles.list'], ['title' => 'add']],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <form class="item-form row" id="add-role" method="POST">
        <div class="col-sm-12">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">role title</h2>
                    <input class="form-control" id="role-name" name="role_title" type="text">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-8 mb-3">
            <div class="main-box box-spaces mb-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-item primary">
                        <h2 class="box-title item-title mb-0">Permissions</h2>
                    </div>
                    <div class="select-all"><a class="btn btn-primary btn-rounded me-2 py-1 text-capitalize">select all</a>
                    </div>
                </div>
                <div class="tabs-holder">
                    <div class="tabs-boxs border-none">
                        <div class="tab-box active">
                            <div class="table-responsive">
                                <table class="table mb-0 border-0">
                                    <tbody>
                                        @php
                                            $list = ['Products', 'Attributes', 'Reviews', 'Categories', 'Tags', 'Discounts', 'Customers', 'Orders', 'Invoices', 'Analytics', 'Marketing', 'Users', 'Roles', 'Gallary', 'Languages', 'Settings'];
                                        @endphp
                                        @foreach ($list as $item)
                                            <tr class="bg-active">
                                                <td class="border-0 p-4">
                                                    <h3 class="h6 text-capitalize text-nowrap mb-0">
                                                        <strong>{{ $item }}</strong></h3>
                                                </td>
                                                <td class="border-0 p-4">
                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">view</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][view]"><span
                                                                    class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">edit</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][edit]"><span
                                                                    class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">create</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][create]"><span
                                                                    class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">delete</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][delete]"><span
                                                                    class="slider"></span>
                                                            </label>
                                                        </div>
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
                <button class="btn solid-btn w-100" type="submit">publish </button>
            </div>
        </div>
        </div>
    </form>

@endsection

@section('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script>
        $('.select-all > a').on('click', function() {
            $('input[type=checkbox]').attr('checked', 'checked');
        });

        // Ajax Call
        $('form#add-role').on('submit', function(e) {
            e.preventDefault();

            var data = $(this).serialize();
            console.log(data);
            $.ajax({
                type: 'POST',
                url: "{{ route('roles.create') }}",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                data: data,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: res.success,
                            showConfirmButton: true,
                            confirmButtonColor: 'var(--main-color)',
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
        });
    </script>
    @if (session('error'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
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

@endsection
