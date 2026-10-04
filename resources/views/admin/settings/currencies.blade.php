@extends('admin.layout')

@section('title', 'Currencies Settings')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush


@section('content')
    @php
        // breadcrumbs params
        $params = [
            'page_title' => __('admin.menu.currencies_settings.title'),
            'breadcrumbs_items' => ['title' => __('admin.menu.currencies_settings.title')],
        ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="settings-forms" method="POST">
        <div class="col-sm-12 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.currencies_settings') }}</h2>
                </div>

                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="main-currency">{{ __('forms.currency.title') }}
					<span class="icon info ms-2" tooltip="{{ __('forms.currency.tooltip') }}" flow="up"><i class="fi-rr-info"></i></span></label>
                    <select class="form-select" id="main-currency" name="main_currency">
                        @foreach (currencies_list() as $code => $name)
                            <option value="{{ $code }}" @isset($sets['main_currency']) @selected($sets['main_currency'] == $code) @endisset>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="currency-position">{{ __('forms.currency_pos.title') }}</label>
                    <select class="form-select" id="currency-position" name="currency_position">
                        @php
                            $curr_pos = [
                                'left' => __('forms.currency_pos.options.left'),
                                'right' => __('forms.currency_pos.options.right'),
                                'left_space' => __('forms.currency_pos.options.left_space'),
                                'right_space' => __('forms.currency_pos.options.right_space')
                            ];
                        @endphp
                        @foreach ($curr_pos as $pos => $title)
                            <option value="{{ $pos }}" @isset($sets['currency_position']) @selected($sets['currency_position'] == $pos) @endisset>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="thousand-sep">{{ __('forms.thousand_sep') }}</label>
                    <input class="form-control" id="thousand-sep" name="thousand_sep" type="text" placeholder="," value=",">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="decimal-sep">{{ __('forms.decimal_sep') }}</label>
                    <input class="form-control" id="decimal-sep" name="decimal_sep" type="text" placeholder="." value=".">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="num-decimals">{{ __('forms.decimals_num') }}</label>
                    <input class="form-control" id="num-decimals" name="num_decimals" min="0" type="number" placeholder="2" value="2">
                </div>
                <hr>
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.multi_currencies') }}</h2>
                </div>

				<div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="social-share">{{ __('forms.multi_currencies') }}</label>
                    <label class="switch text-start">
                        <input class="switch control-toggle"
						id="enable-mulit-currencies"
						type="checkbox"
						value="1"
						data-toggle="multi-currencies-items"
						name="enable_multi_currencies"
						@isset($sets['enable_multi_currencies']) @checked($sets['enable_multi_currencies'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>

				<div class="form-item d-flex flex-column @if(!isset($sets['enable_multi_currencies']) || $sets['enable_multi_currencies'] == false) d-none @endif" id="multi-currencies-items">
					<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
						<label class="item-title" for="currencies-display">{{ __('forms.currencies_display.title') }}</label>
						<select class="form-select" id="currencies-display" name="currencies_display">
							@php
								$curr_dis = [
									'full' => __('forms.currencies_display.options.full'),
									'code' => __('forms.currencies_display.options.code'),
									'symbol' => __('forms.currencies_display.options.symbol'),
									'code_symbol' => __('forms.currencies_display.options.code_symbol'),
								];
							@endphp
							@foreach ($curr_dis as $dis => $title)
								<option value="{{ $dis }}"
									@isset($sets['currencies_display']) @selected($sets['currencies_display'] == $dis) @endisset>
									{{ $title }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-item second d-flex mt-3">
						<label class="item-title mt-1" for="multi-currencies">{{ __('forms.choose_currencies.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.choose_currencies.tooltip') }}" flow="up"><i class="fi-rr-info"> </i></span></label>
						<div class="input-holder w-100">
							<div class="repeater-holder">
								@if (isset($sets['multi_currencies']) && !empty($sets['multi_currencies']))
									@foreach ( $sets['multi_currencies'] as $current )
										<x-multi-currencies :current="$current"></x-multi-currencies>
									@endforeach
								@endif
							</div>
							<div class="add-repeater-item"><a class="btn">{{ __('buttons.add_currency') }}</a></div>
						</div>
					</div>
				</div>


            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces mb-0 mt-3 mt-lg-0">
                <div class="btns-holder d-flex justify-content-between">
                    <button class="btn solid-btn w-100" type="submit">{{ __('buttons.save_changes') }}</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script>

		// Add New Multi Currencies Item
		$('.add-repeater-item .btn').on('click', function (e) {
			e.preventDefault();

			const multi_currency = [];

			$('select[name="multi_currencies[]"]').each(function() {

				multi_currency.push($(this).val());

			});

			$.ajax({
				type: 'POST',
				url: "{{ route('multi_currencies') }}",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				data: {
					'mainCurrency': $('select[name="main_currency"]').val(),
					'multiCurrency': multi_currency,
				},
				success: function(res) {
					$(".repeater-holder").append(res);
				}
			});

		});

        // form Ajax Request
        $('form#settings-forms').on('submit', function(e) {
            e.preventDefault();

            let SwalOptions = {
                showConfirmButton: true,
                confirmButtonColor: 'var(--main-color)',
                confirmButtonText: "{{ __('alerts.btn_text') }}",
                scrollbarPadding: false,
            };

            var data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('currencies-settings.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: data,
                success: function(res) {
                    if (res.success) {
                        AdminSwalSuccess({
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
    </script>
@endpush
