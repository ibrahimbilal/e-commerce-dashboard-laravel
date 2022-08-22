@extends('admin.layout')

@section('title', 'Users List')

@section('stylesheet')
<!-- Icons -->
<link href="{{ asset('css/uicons-solid-rounded.css') }}" rel="stylesheet">
<!-- Data Tables -->
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Users',
        'add_route_name' => 'users.create',
        'breadcrumbs_items' => ['title' => 'users'],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <div class="row">
        <div class="col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2">
            <div class="dash-filters">
				<a class="item text-capitalize" href="#">All (10)</a>
				<a class="item text-capitalize" href="#">Administrator (1)</a>
				<a class="item text-capitalize" href="#">Store Managers (4)</a>
				<a class="item text-capitalize" href="#">Accountant (1)</a>
            </div>
            <div class="bulk-action align-self-end">
                <form class="bulk-form">
                    <select name="bulk_action" class="bulk-select text-capitalize">
                        <option value="">bulk action</option>
                        <option value="edit">edit</option>
                        <option value="delete">delete</option>
                    </select>
                    <button class="btn bulk-submit text-capitalize" type="submit">apply</button>
                </form>
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
								@foreach ($users as $user)
									<tr>
										<td></td>
										<td class="customer-img">
											<div class="img-holder">
												<img src="{{ asset('images/customers/image-1.png') }}" width="70">
											</div>
										</td>
										<td class="user-title">{{ $user->first_name }} {{ $user->last_name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->roles->title }}</td>
										<td>{{ $user->created_at }}</td>
										<td class="status-title">{{ $user->getStatus() }}</td>
										<td>
											<div class="btn-group">
												<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('users.edit', $user->id ) }}">
													<span class="icon"><i class="fi-rr-edit"> </i></span>edit
												</a>
												<a class="btn btn-danger btn-rounded me-2 py-1" id="delete" data-id="{{$user->id}}" href="{{ route('users.destroy', $user->id ) }}">
													<span class="icon"><i class="fi-rr-trash"> </i></span>trash
												</a>
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

@section('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
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
                [5, 'desc']
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
				("Some selection or deselection going on")
				if (tabel.rows({
						selected: true
					}).count() !== tabel.rows().count()) {
					$("th.select-checkbox").removeClass("selected");
				} else {
					$("th.select-checkbox").addClass("selected");
				}
			});
		}

		// Delete User
		$('a#delete').on('click', function(e) {
			e.preventDefault();
			const itemId = $(this).data('id'),
				url = $(this).attr('href'),
				parentRow = $(this).parents('tr');
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
						url: url,
						headers: {
							"X-CSRF-TOKEN": "{{ csrf_token() }}",
						},
						success: function(res) {
							if (res.success) {
								Swal.fire({
									title: 'Deleted!',
									text: 'Your user has been deleted.',
									icon: 'success',
									willClose: () => {
										parentRow.hide(500);
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
						text: 'Your user is safe :)',
						icon: 'error',
						timer: 1500,
						timerProgressBar: true,
						showConfirmButton: false,
					})
				}
			})
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
