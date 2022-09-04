@extends('admin.layout')

@section('title', 'Users List')

@push('stylesheet')
    <!-- Icons -->
    <link href="{{ asset('css/uicons-solid-rounded.css') }}" rel="stylesheet">
    <!-- Data Tables -->
    <link href="{{ asset('css/datatables' . $rtl_ext . '.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.users.title'),
        'add_route_name' => 'users.create',
        'breadcrumbs_items' => ['title' => __('admin.menu.users.title')],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <div class="row">
        <div class="col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2">
            <div class="dash-filters">
                <a class="item text-capitalize @if (!request()->trashed && !request()->role) text-bold @endif"
                    href="{{ route('users.index') }}">
                    {{ __('admin.filters.all') }} ({{ $users->count() }})
                </a>
                @isset($roles)
                    @foreach ($roles as $role)
                        @if ($role->users->count() > 0)
                            <a class="item text-capitalize @if ($role->name == request()->role) text-bold @endif"
                                href="{{ route('users.index', ['role' => $role->name]) }}">
                                {{ Str::ucfirst($role->name) }} ({{ $role->users->count() }})
                            </a>
                        @endif
                    @endforeach
                @endisset

                @if ($trashed->count() > 0)
                    <a class="item text-capitalize @if (request()->trashed) text-bold @endif"
                        href="{{ route('users.index', ['trashed' => 1]) }}">
                        {{ __('admin.filters.trashed') }} ({{ $trashed->count() }})
                    </a>
                @endif
            </div>
            <div class="bulk-action align-self-end">
                @include('admin.inc.bulk_action_form', ['type' => 'users'])
            </div>
        </div>
        <div class="col-12">
            <div class="main-box box-spaces mb-0">
                <div class="table-holder mt-0">
                    <div class="table-responsive">
                        <table class="table table-striped" id="users-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-uppercase">{{ __('tables.columns.image') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.name') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.email') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.role') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.register_date') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.status') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $user)
                                    <tr data-id="{{ $user->id }}">
                                        <td></td>
                                        <td class="customer-img">
                                            <div class="img-holder">
                                                @if ($user->profile_picture)
                                                    <img class="avatar me-2"
                                                        src="{{ URL::asset($user->profile_picture) }}">
                                                @else
                                                    <img src="{{ asset('images/avatars/' . $user->gender . '-avatar.png') }}"
                                                        width="70">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="user-title">{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role_name }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td class="status-title">{{ __('forms.status.' . $user->status) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                @if (!$user->deleted_at)
                                                    <a class="btn btn-warning btn-rounded me-2 py-1"
                                                        href="{{ route('users.edit', $user->id) }}">
                                                        <span class="icon"><i class="fi-rr-edit">
                                                            </i></span>{{ __('buttons.edit') }}
                                                    </a>
                                                    <a class="btn btn-danger btn-rounded me-2 py-1" id="delete"
                                                        data-id="{{ $user->id }}"
                                                        href="{{ route('users.destroy', $user->id) }}">
                                                        <span class="icon"><i class="fi-rr-trash">
                                                            </i></span>{{ __('buttons.trash') }}
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary btn-rounded me-2 py-1" id="restore"
                                                        data-id="{{ $user->id }}"
                                                        href="{{ route('users.restore', $user->id) }}">
                                                        <span class="icon"><i class="fi-rr-time-past">
                                                            </i></span>{{ __('buttons.restore') }}
                                                    </a>
                                                    <a class="btn btn-danger btn-rounded me-2 py-1" id="force-delete"
                                                        data-id="{{ $user->id }}"
                                                        href="{{ route('users.force_delete', $user->id) }}">
                                                        <span class="icon"><i class="fi-rr-trash">
                                                            </i></span>{{ __('bulk_action.option.force_delete') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="text-uppercase">{{ __('tables.columns.image') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.name') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.email') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.role') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.register_date') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.status') }}</th>
                                    <th class="text-uppercase">{{ __('tables.columns.action') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Sweet Alert 2 -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <!-- Data Tables -->
    <script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
    <script>
        // Data Tables
        let tabel = $('#users-table').DataTable({
            dom: 'Bfrtip',
            columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                },
                {
                    bSortable: false,
                    aTargets: [0, 1, 3, 7]
                },
                {
                    bSearchable: false,
                    aTargets: [0, 1, 7]
                }
            ],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [
                [5, 'asc']
            ],
            language: {
                info: "{{ __('tables.words.show') }} _START_ {{ __('tables.words.to') }} _END_ {{ __('tables.words.of') }} _TOTAL_ {{ __('tables.words.users') }}",
                search: "{{ __('tables.words.search') }}",
                zeroRecords: "{{ __('tables.zeroRecords') }}",
                buttons: {
                    pageLength: "{{ __('tables.words.show') }} %d {{ __('tables.words.users') }}",
                    colvis: "{{ __('tables.words.colvis') }}",
                    print: "{{ __('tables.words.print') }}",
                },
                paginate: {
                    first: "{{ __('tables.buttons.first') }}",
                    previous: "{{ __('tables.buttons.prev') }}",
                    next: "{{ __('tables.buttons.next') }}",
                    last: "{{ __('tables.buttons.last') }}"
                },
                select: {
                    rows: {
                        _: "%d {{ __('tables.words.row_selected') }}"
                    },
                }
            },
            stateSave: false,
            paging: true,
            searching: true,
            lengthMenu: [
                [10, 25, 50, 75, 100],
                ["10 {{ __('tables.words.users') }}", "25 {{ __('tables.words.users') }}",
                    "50 {{ __('tables.words.users') }}", "75 {{ __('tables.words.users') }}",
                    "100 {{ __('tables.words.users') }}"
                ]
            ],
            buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
                extend: 'collection',
                text: "{{ __('tables.words.export') }}",
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
                text: "{{ __('tables.words.export') }}",
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
        if ($("th.select-checkbox").length > 0) {
            tabel.on("click", "th.select-checkbox", function() {
                if ($("th.select-checkbox").hasClass("selected")) {
                    tabel.rows().deselect();
                    $("th.select-checkbox").removeClass("selected");
                } else {
                    tabel.rows().select();
                    $("th.select-checkbox").addClass("selected");
                }
            }).on("select deselect", function() {
                if (tabel.rows({
                        selected: true
                    }).count() !== tabel.rows().count()) {
                    $("th.select-checkbox").removeClass("selected");
                } else {
                    $("th.select-checkbox").addClass("selected");
                }
            });
        }

        let SwalOptions = {
            showConfirmButton: true,
            confirmButtonColor: 'var(--main-color)',
            confirmButtonText: "{{ __('alerts.btn_text') }}",
            scrollbarPadding: false,
        };

        // Delete User
        $('a#delete').on('click', function(e) {
            e.preventDefault();
            const itemId = $(this).data('id'),
                url = $(this).attr('href'),
                parentRow = $(this).parents('tr');
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
                        url: url,
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
                                        parentRow.hide(500);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    ...SwalOptions,
                                    icon: 'error',
                                    titleText: "{{ __('alerts.ops') }}",
                                    html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                        Object.keys(res.errors).map(k =>
                                            '<li class="content">' + res.errors[k] +
                                            '</li>').join('') + '</ul></div>',
                                });
                            }
                        },
                        error: function(res) {
                            Swal.fire({
                                ...SwalOptions,
                                icon: 'error',
                                titleText: "{{ __('alerts.ops') }}",
                                html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                    Object.keys(res.responseJSON.errors).map(k =>
                                        '<li class="content">' + res.responseJSON
                                        .errors[k] + '</li>').join('') +
                                    '</ul></div>',
                            });
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

        // Restore User
        $('a#restore').on('click', function(e) {
            e.preventDefault();
            const itemId = $(this).data('id'),
                url = $(this).attr('href'),
                parentRow = $(this).parents('tr');
            Swal.fire({
                ...SwalOptions,
                title: "{{ __('alerts.confirm.title') }}",
                text: "{{ __('alerts.confirm.restore.text') }}",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('alerts.confirm.restore.yes') }}",
                cancelButtonText: "{{ __('alerts.confirm.no') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: url,
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
                                        parentRow.hide(500);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    ...SwalOptions,
                                    icon: 'error',
                                    titleText: "{{ __('alerts.ops') }}",
                                    html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                        Object.keys(res.errors).map(k =>
                                            '<li class="content">' + res.errors[k] +
                                            '</li>').join('') + '</ul></div>',
                                });
                            }
                        },
                        error: function(res) {
                            Swal.fire({
                                ...SwalOptions,
                                icon: 'error',
                                titleText: "{{ __('alerts.ops') }}",
                                html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                    Object.keys(res.responseJSON.errors).map(k =>
                                        '<li class="content">' + res.responseJSON
                                        .errors[k] + '</li>').join('') +
                                    '</ul></div>',
                            });
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        ...SwalOptions,
                        title: "{{ __('alerts.cancel.title') }}",
                        text: "{{ __('alerts.cancel.restore.text') }}",
                        icon: 'error',
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    })
                }
            })
        });

        // Force Delete User
        $('a#force-delete').on('click', function(e) {
            e.preventDefault();
            const itemId = $(this).data('id'),
                url = $(this).attr('href'),
                parentRow = $(this).parents('tr');
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
                        type: 'POST',
                        url: url,
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
                                        parentRow.hide(500);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    ...SwalOptions,
                                    icon: 'error',
                                    titleText: "{{ __('alerts.ops') }}",
                                    html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                        Object.keys(res.errors).map(k =>
                                            '<li class="content">' + res.errors[k] +
                                            '</li>').join('') + '</ul></div>',
                                });
                            }
                        },
                        error: function(res) {
                            Swal.fire({
                                ...SwalOptions,
                                icon: 'error',
                                titleText: "{{ __('alerts.ops') }}",
                                html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                    Object.keys(res.responseJSON.errors).map(k =>
                                        '<li class="content">' + res.responseJSON
                                        .errors[k] + '</li>').join('') +
                                    '</ul></div>',
                            });
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

        $('.bulk-form').on('submit', function(e) {
            e.preventDefault();
            let rows = $('.table tr.selected');
            let action = $(this).find('.bulk-select').val();
			let type = $(this).find('.bulk-type').val();
            let ids = [];
            let confirmTitle = confirmText = confirmYesBtn = deleteText = '';

            rows.each(function(i, el) {
                ids.push($(this).data('id'));
            });

            // return error if no action selected
            if (action == '') {
                Swal.fire({
                    ...SwalOptions,
                    icon: 'error',
                    title: "{{ __('alerts.ops') }}",
                    text: "{{ __('bulk_action.no_action') }}",
                });
                return;
            }
            // return error if no items selected
            if (ids.length == 0) {
                Swal.fire({
                    ...SwalOptions,
                    icon: 'error',
                    title: "{{ __('alerts.ops') }}",
                    text: "{{ __('bulk_action.no_items') }}",
                });
                return;
            }

            if (action == 'restore') {
                confirmText = "{{ __('bulk_action.confirm.restore.text') }}";
                confirmYesBtn = "{{ __('bulk_action.confirm.restore.yes') }}";
                cancelText = "{{ __('bulk_action.cancel.restore.text') }}";
            }

            if (action == 'delete' || action == 'force_delete') {
                confirmText = "{{ __('bulk_action.confirm.delete.text') }}";
                confirmYesBtn = "{{ __('bulk_action.confirm.delete.yes') }}";
                cancelText = "{{ __('bulk_action.cancel.delete.text') }}";
            }

            Swal.fire({
                ...SwalOptions,
                title: "{{ __('bulk_action.confirm.title') }}",
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: confirmYesBtn,
                cancelButtonText: "{{ __('bulk_action.confirm.no') }}",
            }).then((result) => {
                if (result.isConfirmed) {
                    doBulkAction(ids, action, type);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        ...SwalOptions,
                        title: "{{ __('bulk_action.cancel.title') }}",
                        text: cancelText,
                        icon: 'error',
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    })
                }
            })

            function doBulkAction(ids = [], action = 'delete') {

				switch(action) {
					case 'delete':
						routeName = "{{ route('users.bulk_delete') }}";
						break;
					case 'restore':
						routeName = "{{ route('users.bulk_restore') }}";
						break;
					case 'force_delete':
						routeName = "{{ route('users.bulk_force_delete') }}";
						break;
					default:
						routeName = '';
				}

                $.ajax({
                    type: 'POST',
                    url: routeName,
                    data: {
                        items: ids,
						type: type
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                ...SwalOptions,
                                title: res.title,
                                text: res.text,
                                icon: 'success',
                                willClose: () => {
                                    rows.each(function(i, el) {
                                        if (jQuery.inArray($(this).data('id'), ids) >= 0) {
                                            $(this).hide(500);
                                        }
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                ...SwalOptions,
                                icon: 'warning',
                                title: res.title,
								html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                Object.keys(res.errors).map(k =>
                                    '<li class="content">' + res.errors[k] +
                                    '</li>').join('') + '</ul></div>',
                            });
                        }
                    },
                    error: function(res) {
                        Swal.fire({
                            ...SwalOptions,
                            icon: 'error',
                            title: "{{ __('alerts.ops') }}",
                            html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                Object.keys(res.responseJSON.errors).map(k =>
                                    '<li class="content">' + res.responseJSON.errors[k] +
                                    '</li>').join('') + '</ul></div>',
                        });
                    }
                });
            }

        });

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

        @if (session('errors'))
            Toast.fire({
                icon: 'error',
                titleText: "{{ session('errors') }}",
            });
        @endif

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                titleText: "{{ session('success') }}",
            });
        @endif
    </script>
@endpush
