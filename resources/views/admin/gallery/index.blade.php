@extends('admin.layout')

@section('title', 'Gallery')

@push('stylesheet')
    <!-- Icons-->
    <link rel="stylesheet" href="{{ asset('css/uicons-regular-rounded.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uicons-solid-rounded.css') }}">
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- File Uploder-->
    <link href="{{ asset('css/filepond/filepond.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/filepond/filepond-plugin-image-preview.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        // breadcrumbs params
        $params = [
            'page_title' => __('admin.menu.gallery.title'),
            'breadcrumbs_items' => ['title' => __('admin.menu.gallery.title')],
        ];
    @endphp
    @include('admin.inc.page_title', $params)

    <div class="gallery-page">
        <div class="upload-holder mb-3">
            <form id="upload-form" method="post" enctype="multipart/form-data"></form>
        </div>
        <div class="page-content row">
            <div class="col-sm-12 col-lg-9 float-start post-box order-1 open">
                <div class="g-holder main-box box-spaces d-flex flex-column mb-0">
                    <div class="d-flex justify-content-between align-items-sm-center flex-column-reverse flex-sm-row mb-2">
                        {{-- Bulk Action Form Params --}}
                        <div class="bulk-action mt-2 mt-sm-0">
                            @include('admin.inc.bulk_action_form', [
                                'type' => 'gallery',
                                'edit_perms' => 'edit gallery',
                                'delete_perms' => 'delete gallery',
                            ])
                        </div>
                        <div class="search-holder">
                            <form class="search-form">
                                <div class="form-item second d-flex align-items-center">
                                    <label class="item-title meta-title me-2"
                                        for="gal-search">{{ __('forms.search') }}</label>
                                    <input class="form-control d-inline-block" id="gal-search" type="text"
                                        name="s">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="images mt-3">
                        <ul class="list-unstyled images-list">
							@forelse ( $photos as $photo )
								<li class="img-item" data-id="{{ $photo->id }}">
									<label class="d-flex justify-content-center align-items-center">
										<input type="checkbox" name="images[]" value="{{ $photo->id }}">
										<img src="{{ URL::asset('storage/' . $photo->url) }}">
									</label>
								</li>
							@empty
								<li class="w-100 text-center">{{ __('admin.pages.gallery.no_images') }}</li>
							@endforelse
                        </ul>
                    </div>
                </div>
            </div>
			<div class="col-sm-12 col-lg-3 float-end meta-box order-lg-1 hide"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>

	<!-- Upload Files Library-->
	<script src="{{ asset('js/filepond/filepond.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/filepond/filepond-plugin-image-preview.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/filepond/filepond-plugin-file-validate-size.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/filepond/filepond-plugin-file-validate-type.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/filepond/filepond.jquery.js') }}" type="text/javascript"></script>

    <script>
        $.fn.filepond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType
        );

		let SwalOptions = {
            showConfirmButton: true,
            confirmButtonColor: 'var(--main-color)',
            confirmButtonText: "{{ __('alerts.btn_text') }}",
            scrollbarPadding: false,
        };

		// upload files
        $('#upload-form').filepond({
            allowFileSizeValidation: true,
            allowFileTypeValidation: true,
            allowMultiple: true,
            allowReorder: true,
            maxFileSize: '2MB',
            acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            labelFileTypeNotAllowed: 'File is invalid type',
            fileValidateTypeLabelExpectedTypes: '{allButLastType}',
            server: {
				remove: null,
				revert: null,
				url: "{{ route('admin.gallery.store')}}",
				process: {
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},
				}
			},
        });

        // form Ajax Request
        $(document).on('submit', 'form#edit-image-gallery', function(e) {
            e.preventDefault();

            const data = $(this).serialize();
            const formID = $(this).data('id');
			const formURL = "{{ route('admin.gallery.update', ':id') }}";
			url = formURL.replace(':id', formID);

			console.log(formID)
			console.log(url)

            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                data: data,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            ...SwalOptions,
                            icon: 'success',
                            title: res.title,
                        });
                    } else {
                        Swal.fire({
                            ...SwalOptions,
                            icon: 'error',
                            titleText: "{{ __('alerts.ops') }}",
                            html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
                                Object.keys(res.errors).map(k => '<li class="content">' + res
                                    .errors[k] + '</li>').join('') + '</ul></div>',
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
                                '<li class="content">' + res.responseJSON.errors[k] + '</li>')
                            .join('') + '</ul></div>',
                    });
                }
            });
        });

		// Show image details
		$('.gallery-page .img-item').on('click', function (e) {
			e.preventDefault();

			const thisItem = $(this);
			const imgId = thisItem.data('id');

			$.ajax({
				type: 'POST',
				url: "{{ route('get_metas') }}",
				headers: {
					"X-CSRF-TOKEN": "{{ csrf_token() }}",
				},
				data: {
					'id': imgId
				},
				success: function(res) {
					if ( res.success ) {
						if (!thisItem.hasClass('selected')) {
							thisItem.addClass('selected').siblings().removeClass('selected');
							$('.gallery-page .meta-box').removeClass('hide').html(res.output);
							$('.gallery-page .post-box').removeClass('open');
						} else {
							thisItem.removeClass('selected');
							$('.gallery-page .meta-box').addClass('hide').html('');
							$('.gallery-page .post-box').addClass('open');
						}

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

		});

		// delete image
		@can('delete gallery')
			$(document).on('click', 'a#delete', function(e) {
				e.preventDefault();
				const url = $(this).attr('href');
				const thisId = $(this).data('id');
				const itemParent = $(`.gallery-page .img-item[data-id=${thisId}]`);
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
											itemParent.removeClass('selected');
											itemParent.remove();
											$('.gallery-page .meta-box').addClass('hide').html('');
											$('.gallery-page .post-box').addClass('open');
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
		@endcan

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
