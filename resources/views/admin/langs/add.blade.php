@extends('admin.layout')

@section('title', 'Add Language')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.languages.add'),
        'breadcrumbs_items' => [['title' => __('admin.menu.languages.title'), 'route_name' => 'langs.index'], ['title' => __('admin.menu.languages.add')]],
    ];
    @endphp
    @include('admin.inc.page_title', $params)
    <form class="item-form row" id="add-lang" method="POST">
        <div class="col-sm-12">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <div class="input-group">
						<select class="form-select" name="lang" aria-label="Select Language">
							<option selected disabled>Choose...</option>
							@foreach ( $all_langs as $lang_code => $lang_name )
								@if (array_search($lang_code, array_column(available_languages(), 'code')) === false)
									<option value="{{ $lang_code }}">{{ $lang_name }}</option>
								@endif
							@endforeach
						</select>
						<button class="btn solid-btn" type="submit">{{ __('buttons.create') }}</button>
					</div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>

    <script>
		let SwalOptions = {
			showConfirmButton: true,
			confirmButtonColor: 'var(--main-color)',
			confirmButtonText: "{{ __('alerts.btn_text') }}",
			scrollbarPadding: false,
		};

        // Ajax Call
        $('form#add-lang').on('submit', function(e) {
            e.preventDefault();

            var data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('langs.store') }}",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                data: data,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
							...SwalOptions,
                            icon: 'success',
                            title: res.text,
                            willClose: () => {
                                window.location.replace(res.redirect);
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
    </script>
@endpush
