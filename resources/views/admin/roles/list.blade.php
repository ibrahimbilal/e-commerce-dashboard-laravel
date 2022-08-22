@extends('admin.layout')

@section('title', 'Roles List')

@section('stylesheet')
<!-- Data Tables -->
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Roles',
        'add_route_name' => 'roles.create',
        'breadcrumbs_items' => ['title' => 'roles'],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <div class="row">
        <div class="col-12">
            <div class="main-box box-spaces mb-0">
                <div class="table-holder mt-0">
                    <div class="table-responsive">
                        <table class="table table-striped" id="roles">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">Role title</th>
									<th class="text-uppercase">action</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach ($roles as $role)
									<tr data-id="{{$role->id}}">
										<td class="user-title">{{ $role->title }}</td>
										<td>
											<div class="btn-group">
												<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('roles.edit', $role->id ) }}">
													<span class="icon"><i class="fi-rr-edit"> </i></span>edit
												</a>
												<a class="btn btn-danger btn-rounded me-2 py-1" id="delete" data-id="{{$role->id}}" href="{{ route('roles.destroy', $role->id ) }}">
													<span class="icon"><i class="fi-rr-trash"> </i></span>trash
												</a>
											</div>
										</td>
									</tr>
								@endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-uppercase">Role title</th>
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
		$('#roles').DataTable({
			dom: 'Bfrtip',
			columnDefs: [
				{
					bSortable: false,
					aTargets: [1]
				},
				{
					bSearchable: false,
					aTargets: [1]
				}
			],
			order: [
				[0, 'asc']
			],
			language: {
				info: "Show _START_ To _END_ Of _TOTAL_ Roles",
				buttons: {
					pageLength: 'Show %d',
					colvis: 'Columns'
				}
			},
			stateSave: false,
			paging: true,
			searching: true,
			lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 Roles', '15 Roles', '25 Roles', '50 Roles', '75 Roles', '100 Roles']],
			buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
				extend: 'collection',
				text: 'Export',
				className: 'btn btn-group',
				buttons: [
					{
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
				buttons: [
					{
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

		// Delete Role
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
									text: 'Your role has been deleted.',
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
						text: 'Your role is safe :)',
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
