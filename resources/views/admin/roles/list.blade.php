@extends('admin.layout')

@section('title', 'Roles List')

@push('stylesheet')
	<!-- Data Tables -->
	<link href="{{ asset('css/datatables'.$rtl_ext.'.min.css') }}" rel="stylesheet">
	<!-- Sweet Alert 2 -->
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.roles.title'),
        'add_route_name' => 'roles.create',
        'breadcrumbs_items' => ['title' => __('admin.menu.roles.title')],
		'permissions' => 'add roles'
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
                                    <th class="text-uppercase">{{ __('tables.columns.role_name') }}</th>
									<th class="text-uppercase">{{ __('tables.columns.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach ($roles as $role)
									<tr data-id="{{$role->id}}">
										<td class="user-title">{{ $role->name }}</td>
										<td>
											<div class="btn-group">
												@can('edit roles')
													<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('roles.edit', $role->id ) }}">
														<span class="icon"><i class="fi-rr-edit"> </i></span>{{ __('buttons.edit') }}
													</a>
												@endcan

												@can('permanently_delete roles')
													<a class="btn btn-danger btn-rounded me-2 py-1" id="delete" data-id="{{$role->id}}" href="{{ route('roles.destroy', $role->id ) }}"
														data-confirm-delete="soft"
														data-confirm-ajax
														data-http-method="DELETE"
														data-remove="closest-tr">
														<span class="icon"><i class="fi-rr-trash"> </i></span>{{ __('buttons.trash') }}
													</a>
												@endcan
											</div>
										</td>
									</tr>
								@endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-uppercase">{{ __('tables.columns.role_name') }}</th>
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
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
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
                info: "{{ __('tables.words.show') }} _START_ {{ __('tables.words.to') }} _END_ {{ __('tables.words.of') }} _TOTAL_ {{ __('tables.words.roles') }}",
				search: "{{ __('tables.words.search') }}",
				zeroRecords: "{{ __('tables.zeroRecords') }}",
                buttons: {
                    pageLength: "{{ __('tables.words.show') }} %d {{ __('tables.words.roles') }}",
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
			lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ["10 {{ __('tables.words.roles') }}", "15 {{ __('tables.words.roles') }}", "25 {{ __('tables.words.roles') }}", "50 {{ __('tables.words.roles') }}", "75 {{ __('tables.words.roles') }}", "100 {{ __('tables.words.roles') }}"]],
			buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
				extend: 'collection',
				text: "{{ __('tables.words.export') }}",
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
				text: "{{ __('tables.words.export') }}",
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
				title: "{{ session('errors') }}"
			});
		@endif
	</script>
@endpush
