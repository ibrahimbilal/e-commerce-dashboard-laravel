@extends('admin.layout')

@section('title', 'Users List')

@push('stylesheet')
	<!-- Icons -->
	<link href="{{ asset('css/uicons-solid-rounded.css') }}" rel="stylesheet">
	<!-- Data Tables -->
	<link href="{{ asset('css/datatables'.$rtl_ext.'.min.css') }}" rel="stylesheet">
	<!-- Sweet Alert 2 -->
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.pages.users.title'),
        'add_route_name' => 'users.create',
        'breadcrumbs_items' => ['title' => __('admin.pages.users.title')],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <div class="row">
        <div class="col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2">
            <div class="dash-filters">
				<a class="item text-capitalize @if(!request()->trashed && !request()->role) text-bold @endif"
					href="{{ route('users.index') }}">
					{{ __('admin.filters.all') }} ({{ $users->count() }})
				</a>
				@isset($roles)
					@foreach ( $roles as $role )
						@if ($role->users->count() > 0)
							<a class="item text-capitalize @if($role->id == request()->role) text-bold @endif" href="{{ route('users.index', ['role' => $role->id]) }}">
								{{ Str::ucfirst($role->title) }} ({{ $role->users_count }})
							</a>
						@endif
					@endforeach
				@endisset

				@if ($trashed->count() > 0)
					<a class="item text-capitalize @if(request()->trashed) text-bold @endif"
						href="{{ route('users.index', ['trashed' => 1]) }}">
						{{ __('admin.filters.trashed') }} ({{ $trashed->count() }})
					</a>
				@endif
            </div>
            <div class="bulk-action align-self-end">
				@include('admin.inc.bulk-action.bulk_action_form', ['type' => 'users'])
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
                                    <th class="text-uppercase">image</th>
                                    <th class="text-uppercase">name</th>
                                    <th class="text-uppercase">email</th>
                                    <th class="text-uppercase">role</th>
                                    <th class="text-uppercase">registered date</th>
                                    <th class="text-uppercase">status</th>
                                    <th class="text-uppercase">action</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach ($results as $user)
									<tr data-id="{{$user->id}}">
										<td></td>
										<td class="customer-img">
											<div class="img-holder">
												@if ($user->profile_picture)
													<img class="avatar me-2" src="{{ URL::asset($user->profile_picture) }}">
												@else
													<img src="{{ asset('images/avatars/' . $user->gender . '-avatar.png') }}" width="70">
												@endif
											</div>
										</td>
										<td class="user-title">{{ $user->first_name }} {{ $user->last_name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->roles->title }}</td>
										<td>{{ $user->created_at }}</td>
										<td class="status-title">{{ $user->status }}</td>
										<td>
											<div class="btn-group">
												@if (!$user->deleted_at)
													<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('users.edit', $user->id ) }}">
														<span class="icon"><i class="fi-rr-edit"> </i></span>{{ __('buttons.edit') }}
													</a>
													<a class="btn btn-danger btn-rounded me-2 py-1" id="delete" data-id="{{$user->id}}" href="{{ route('users.destroy', $user->id ) }}">
														<span class="icon"><i class="fi-rr-trash"> </i></span>{{ __('buttons.trash') }}
													</a>
												@else
													<a class="btn btn-primary btn-rounded me-2 py-1" id="restore" data-id="{{$user->id}}" href="{{ route('users.restore', $user->id ) }}">
														<span class="icon"><i class="fi-rr-time-past"> </i></span>{{ __('buttons.restore') }}
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
                                    <th class="text-uppercase">image</th>
                                    <th class="text-uppercase">name</th>
                                    <th class="text-uppercase">email</th>
                                    <th class="text-uppercase">role</th>
                                    <th class="text-uppercase">registered date</th>
                                    <th class="text-uppercase">status</th>
                                    <th class="text-uppercase">action</th>
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
                info: "Show _START_ To _END_ Of _TOTAL_ users",
                buttons: {
                    pageLength: 'Show %d',
                    colvis: 'Columns'
                }
            },
            stateSave: false,
            paging: true,
            searching: true,
            lengthMenu: [
                [10, 25, 50, 75, 100],
                ['10 users', '25 users', '50 users', '75 users', '100 users']
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
		if ( $("th.select-checkbox").length > 0 ) {
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
				title: "{{ __('alerts.users.confirm.title') }}",
                text: "{{ __('alerts.users.confirm.delete.text') }}",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('alerts.users.confirm.delete.yes') }}",
                cancelButtonText: "{{ __('alerts.users.confirm.no') }}",
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
										Object.keys(res.errors).map(k => '<li class="content">' + res.errors[k] + '</li>').join('') + '</ul></div>',
								});
							}
						}
					});

				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						...SwalOptions,
						title: "{{ __('alerts.users.cancel.title') }}",
                        text: "{{ __('alerts.users.cancel.delete.text') }}",
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
				title: "{{ __('alerts.users.confirm.title') }}",
                text: "{{ __('alerts.users.confirm.restore.text') }}",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('alerts.users.confirm.restore.yes') }}",
                cancelButtonText: "{{ __('alerts.users.confirm.no') }}",
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
										Object.keys(res.errors).map(k => '<li class="content">' + res.errors[k] + '</li>').join('') + '</ul></div>',
								});
							}
						}
					});

				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						...SwalOptions,
						title: "{{ __('alerts.users.cancel.title') }}",
                        text: "{{ __('alerts.users.cancel.restore.text') }}",
						icon: 'error',
						timer: 1500,
						timerProgressBar: true,
						showConfirmButton: false,
					})
				}
			})
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

		@if (session('error'))
			Toast.fire({
				icon: 'error',
				titleText: "{{ session('error') }}",
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
