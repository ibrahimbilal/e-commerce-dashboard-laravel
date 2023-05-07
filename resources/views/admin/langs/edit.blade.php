@extends('admin.layout')

@section('title', 'Edit Language')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush

@section('content')

    @php
        // breadcrumbs params
        $params = [
            'page_title' => __('admin.menu.languages.edit'),
            'breadcrumbs_items' => [['title' => __('admin.menu.languages.title'), 'route_name' => 'langs.index'], ['title' => __('admin.menu.languages.edit')]],
        ];
    @endphp
    @include('admin.inc.page_title', $params)
    <form class="item-form row" id="edit-lang">
        <div class="col-sm-12">
            <div class="main-box box-spaces">
                <div class="form-item primary">
                    <h2 class="box-title item-title">{{ langs_list(Request::route('slug')) }}</h2>
                </div>

                <div class="repeater-holder">
					@foreach ( $contents as $i => $content )
						<div class="repeater mb-3">
							<div class="repeater-title p-3 mb-3 d-flex justify-content-between align-items-center">
								<h3 class="h5 mb-0">{{ $content['file_name'] }}</h3>
								<div class="icons d-flex align-items-center">
									<span class="icon {{ $i == 0 ? 'active' : '' }}"><i class="fi-rr-angle-small-down"> </i></span>
								</div>
							</div>
							<div class="repeater-inputs px-3 {{ $i == 0 ? 'active' : ''}}">
								<pre>
									@php
										var_dump( require_once($content['file_content']) );
									@endphp
								</pre>
							</div>
						</div>
					@endforeach
                </div>

                <button class="btn solid-btn" type="submit">{{ __('buttons.update') }}</button>
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
        // $('form#edit-role').on('submit', function(e) {
        //     e.preventDefault();
        //     var data = $(this).serialize();
        //     $.ajax({
        //         type: 'PUT',
        //         headers: {
        //             "X-CSRF-TOKEN": "{{ csrf_token() }}",
        //         },
        //         data: data,
        //         success: function(res) {
        //             if (res.success) {
        //                 Swal.fire({
        //                     ...SwalOptions,
        // 					icon: 'success',
        // 					titleText: res.text,
        //                 });
        //             } else {
        //                 Swal.fire({
        // 					...SwalOptions,
        // 					icon: 'error',
        // 					titleText: "{{ __('alerts.ops') }}",
        // 					html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
        // 						Object.keys(res.errors).map(k => '<li class="content">' + res.errors[k] + '</li>').join('') + '</ul></div>',
        // 				});
        //             }
        // 		},
        // 		error: function(res) {
        // 			Swal.fire({
        // 				...SwalOptions,
        // 				icon: 'error',
        // 				titleText: "{{ __('alerts.ops') }}",
        // 				html: '<div class="alerts danger"><ul class="list" style="text-align: start">' +
        // 					Object.keys(res.responseJSON.errors).map(k => '<li class="content">' + res.responseJSON.errors[k] + '</li>').join('') + '</ul></div>',
        // 			});
        // 		}
        //     });
        // });
    </script>
@endpush
