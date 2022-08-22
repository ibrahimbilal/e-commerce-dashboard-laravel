@extends('admin.layout')

@section('title', 'Add Role')

@section('stylesheet')

@endsection

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Edit Role',
        'breadcrumbs_items' => [['title' => 'roles', 'route_name' => 'roles.index'], ['title' => 'edit']],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <form class="item-form row" id="edit-role" data-post-type="role">
        <div class="col-sm-12">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">role title</h2>
                    <input class="form-control" id="role-title" name="role_title" type="text" value="{{ $role->title }}">
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
                                            $list = ['products', 'attributes', 'reviews', 'categories', 'tags', 'discounts', 'customers', 'orders', 'invoices', 'analytics', 'marketing', 'users', 'roles', 'gallary', 'languages', 'settings'];
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
                                                                    name="permissions[{{ $item }}][view]"
																	@isset(json_decode($role->permissions)->$item->view)
																		{{ selected(json_decode($role->permissions)->$item->view, 'on', 'checkbox') }}
																	@endisset>
																	<span class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">edit</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][edit]"
																	@isset(json_decode($role->permissions)->$item->edit)
																		{{ selected(json_decode($role->permissions)->$item->edit, 'on', 'checkbox') }}
																	@endisset>
																	<span class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">create</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][create]"
																	@isset(json_decode($role->permissions)->$item->create)
																		{{ selected(json_decode($role->permissions)->$item->create, 'on', 'checkbox') }}
																	@endisset>
																	<span class="slider"></span>
                                                            </label>
                                                        </div>
                                                        <div class="d-flex ms-2"><span
                                                                class="text-capitalize me-2">delete</span>
                                                            <label class="switch text-start">
                                                                <input class="switch" type="checkbox"
                                                                    name="permissions[{{ $item }}][delete]"
																	@isset(json_decode($role->permissions)->$item->delete)
																		{{ selected(json_decode($role->permissions)->$item->delete, 'on', 'checkbox') }}
																	@endisset>
																	<span class="slider"></span>
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
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">created at: </label><span class="ms-2">{{ format_date($role->created_at) }}</span>
                </div>
                <div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
                    <label class="item-title meta-title">updated at:</label><span class="ms-2">{{ format_date($role->updated_at) }}</span>
                </div>
                <div class="btns-holder d-flex justify-content-between mt-4">
                    <a class="btn trans-btn w-100 text-start delete" href="{{ route('roles.destroy', $role->id) }}">
						<span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash
					</a>
                    <button class="btn solid-btn" type="submit">update</button>
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
        $('form#edit-role').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type: 'PUT',
                url: "{{ route('roles.update', $role->id) }}",
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

		// Delete Role
		$('a.trans-btn.delete').on('click', function(e) {
			e.preventDefault();
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
						url: "{{ route('roles.destroy', $role->id) }}",
						headers: {
							"X-CSRF-TOKEN": "{{ csrf_token() }}",
						},
						success: function(res) {
							if (res.success) {
								Swal.fire({
									title: 'Deleted!',
									text: 'Role has been deleted.',
									icon: 'success',
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

				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						title: 'Cancelled',
						text: 'Role is safe :)',
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
