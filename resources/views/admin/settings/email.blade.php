@extends('admin.layout')

@section('title', 'Emails Settings')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- Select 2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endpush


@section('content')
    @php
        // breadcrumbs params
        $params = [
            'page_title' => __('admin.menu.emails_settings.title'),
            'breadcrumbs_items' => ['title' => __('admin.menu.emails_settings.title')],
        ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="settings-form" data-post-type="settings">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.emails_settings') }}</h2>
                </div>

                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="email-from">{{ __('forms.email_from.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.email_from.tooltip') }}" flow="up">
							<i class="fi-rr-info"> </i>
						</span>
					</label>
                    <input class="form-control"
						id="email-from"
						name="email_from_name"
						value="@isset($sets['email_from_name']){{ $sets['email_from_name'] }}@endisset"
						type="text"
						placeholder="Store Name">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="email-address">{{ __('forms.email_address.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.email_address.tooltip') }}" flow="up">
							<i class="fi-rr-info"> </i>
						</span>
					</label>
                    <input class="form-control"
					id="email-address"
					name="email_from_address"
					value="@isset($sets['email_from_address']){{ $sets['email_from_address'] }}@endisset"
					type="text"
					placeholder="example@email.com">
                </div>
                <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                    <label class="item-title mb-2" for="main-color">{{ __('forms.email_main_color.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.email_main_color.tooltip') }}" flow="up">
							<i class="fi-rr-info"> </i>
						</span>
					</label>
                    <input id="main-color"
					class="form-control-color"
					type="color"
					name="email_main_color"
					value="@if(isset($sets['email_main_color'])){{$sets['email_main_color']}}@else{{"#2C2CCC"}}@endif"
					title="Choose your color">
                </div>
                <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                    <label class="item-title mb-2">{{ __('forms.email_bg_color.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.email_bg_color.tooltip') }}" flow="up">
							<i class="fi-rr-info"> </i>
						</span>
					</label>
                    <input class="form-control-color"
					type="color"
					name="email_bg_color"
					value="@if(isset($sets['email_bg_color'])){{$sets['email_bg_color']}}@else{{"#F7F7F7"}}@endif"
					title="Choose your color">
                </div>
                <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                    <label class="item-title mb-2">{{ __('forms.email_body_bg_color.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.email_body_bg_color.tooltip') }}" flow="up">
							<i class="fi-rr-info"></i>
						</span>
					</label>
                    <input class="form-control-color"
					type="color"
					name="email_body_bg_color"
					value="@if(isset($sets['email_body_bg_color'])){{$sets['email_body_bg_color']}}@else{{"#FFFFFF"}}@endif"
					title="Choose your color">
                </div>
                <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                    <label class="item-title mb-2">{{ __('forms.email_text_color.title') }}
						<span class="icon info ms-2" tooltip="{{ __('forms.email_text_color.tooltip') }}" flow="up">
							<i class="fi-rr-info"></i>
						</span>
					</label>
                    <input class="form-control-color"
					type="color"
					name="email_text_color"
					value="@if(isset($sets['email_text_color'])){{$sets['email_text_color']}}@else{{"#333333"}}@endif"
					title="Choose your color">
                </div>
                <hr>
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.emails_notification_settings') }}</h2>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="new-order">{{ __('forms.email_new_order.title') }}
							<span class="icon info ms-2" tooltip="{{ __('forms.email_new_order.tooltip') }}" flow="up">
								<i class="fi-rr-info"></i>
							</span>
						</label>
						<small>{{ __('forms.email_rec.users') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch control-toggle"
							id="email-new-order"
							type="checkbox"
							value="1"
							@isset($sets['email_new_order']) @checked($sets['email_new_order'] == true) @endisset
							data-toggle="new-order"
							name="email_new_order">
							<span class="slider"></span>
                        </label>
                        <div class="form-item flex-column mt-1 @if(!isset($sets['email_new_order']) || $sets['email_new_order'] == false) d-none @else d-flex @endif" id="new-order">
							<x-send-to
								id="new-order-recipients"
								sel-name="new_order_recipients"
								type-name="new_order_recipients_type">
							</x-send-to>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="out-of-stock">{{ __('forms.email_out_stock.title') }}<span class="icon info ms-2"
                                tooltip="{{ __('forms.email_out_stock.tooltip') }}" flow="up"><i class="fi-rr-info">
                                </i></span></label>
						<small>{{ __('forms.email_rec.users') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch control-toggle"
								id="out-of-stock"
								type="checkbox"
								value="1"
								@isset($sets['email_out_of_stock']) @checked($sets['email_out_of_stock'] == true) @endisset
                                data-toggle="email-out-of-stock"
								name="email_out_of_stock">
								<span class="slider"></span>
                        </label>
                        <div class="form-item flex-column mt-1 @if(!isset($sets['email_out_of_stock']) || $sets['email_out_of_stock'] == false) d-none @else d-flex @endif" id="email-out-of-stock">
							<x-send-to
								id="out-of-stock-recipients"
								sel-name="out_of_stock_recipients"
								type-name="out_of_stock_recipients_type">
							</x-send-to>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="order-canceled">{{ __('forms.email_order_canceled.title') }}<span class="icon info ms-2"
                                tooltip="{{ __('forms.email_order_canceled.tooltip') }}" flow="up"><i
                                    class="fi-rr-info"> </i></span></label>
						<small>{{ __('forms.email_rec.users') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch control-toggle"
								id="order-canceled"
								type="checkbox"
								value="1"
								@isset($sets['email_order_canceled']) @checked($sets['email_order_canceled'] == true) @endisset
                                data-toggle="email-order-canceled"
								name="email_order_canceled">
								<span class="slider"></span>
                        </label>
                        <div class="form-item flex-column mt-1 @if(!isset($sets['email_order_canceled']) || $sets['email_order_canceled'] == false) d-none @else d-flex @endif" id="email-order-canceled">
							<x-send-to
								id="order-canceled-recipients"
								sel-name="order_canceled_recipients"
								type-name="order_canceled_recipients_type">
							</x-send-to>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex mt-3">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="order-confirmed">{{ __('forms.email_order_confirmed.title') }}
							<span class="icon info ms-2" tooltip="{{ __('forms.email_order_confirmed.tooltip') }}" flow="up">
								<i class="fi-rr-info"></i>
							</span>
						</label>
						<small>{{ __('forms.email_rec.customer') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch"
									id="order-confirmed"
									type="checkbox"
									value="1"
									@isset($sets['email_order_confirmed']) @checked($sets['email_order_confirmed'] == true) @endisset
									name="email_order_confirmed">
							<span class="slider"></span>
                        </label>
                    </div>
                </div>
                <div class="form-item second d-flex mt-3">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="order-shipped">{{ __('forms.email_order_shipped.title') }}<span class="icon info ms-2"
                                tooltip="{{ __('forms.email_order_shipped.tooltip') }}" flow="up"><i
                                    class="fi-rr-info"> </i></span></label>
						<small>{{ __('forms.email_rec.customer') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch"
							id="order-shipped"
							type="checkbox"
							value="1"
							@isset($sets['email_order_shipped']) @checked($sets['email_order_shipped'] == true) @endisset
							name="email_order_shipped">
						<span class="slider"></span>
                        </label>
                    </div>
                </div>
                <div class="form-item second d-flex mt-3">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="order-completed">{{ __('forms.email_order_completed.title') }}<span class="icon info ms-2"
                                tooltip="{{ __('forms.email_order_completed.tooltip') }}" flow="up"><i
                                    class="fi-rr-info"> </i></span></label>
						<small>{{ __('forms.email_rec.customer') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch"
							id="order-completed"
							type="checkbox"
							value="1"
							@isset($sets['email_order_completed']) @checked($sets['email_order_completed'] == true) @endisset
							name="email_order_completed">
						<span class="slider"></span>
                        </label>
                    </div>
                </div>
                <div class="form-item second d-flex mt-3">
                    <div class="item-title d-block mb-2">
                        <label class="item-title" for="order-refunded">{{ __('forms.email_order_refunded.title') }}<span class="icon info ms-2"
                                tooltip="{{ __('forms.email_order_refunded.tooltip') }}" flow="up"><i
                                    class="fi-rr-info"> </i></span></label>
						<small>{{ __('forms.email_rec.customer') }}</small>
                    </div>
                    <div class="item-content">
                        <label class="switch text-start">
                            <input class="switch"
							id="order-refunded"
							type="checkbox"
							value="1"
							@isset($sets['email_order_refunded']) @checked($sets['email_order_refunded'] == true) @endisset
							name="email_order_refunded">
							<span class="slider"></span>
                        </label>
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
    <!-- Select 2 -->
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
    <script>
		// Select 2 Sizes && Colors
		function set_select2() {
			const productAttributes = $('.multi-select');
			const selectIDArray = []; // empty array
			productAttributes.each(function(k, v) {
				const selectID = $(this).attr('id'); // select element id
				selectIDArray.push('#' + selectID); // add select element id to array with #
				$('#' + selectID).select2({
					width: "100%",
					tags: true,
					placeholder: $(this).attr('placeholder'),
					createTag: function () {
						// Disable tagging
						return undefined;
					},
					templateResult: function (data) {
						if ( data._resultId !== undefined ) {
							return data.text;
						}
					},
					templateSelection: function (data, container) {
						container.html('<span class="tag-name">' + data.text + '</span><span class="select2-selection__choice__remove icon ms-2"><i class="fi-rr-cross-circle"></i></span>');
					},
				});
			});
		}

		// Date Preview
		$('select[name=new_order_recipients_type], select[name=out_of_stock_recipients_type], select[name=order_canceled_recipients_type]').on('change', function() {

				const rec_type =  $(this).val();
				const var_ele = $(this).next('.select2-wrapper').find('select');

				$.ajax({
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},
					url: "{{ route('recipients_type') }}",
					data: {
						rec_type: rec_type
					},
					success: function(data) {
						// make select element empty
						var_ele.html('');
						// append new values
						data.forEach(function(el) {
							var_ele.append(`<option value="${el.id}">${el.name || el.email}</option>`)
						});
					}
				});
				});

        // form Ajax Request
        $('form#settings-form').on('submit', function(e) {
            e.preventDefault();

            let SwalOptions = {
                showConfirmButton: true,
                confirmButtonColor: 'var(--main-color)',
                confirmButtonText: "{{ __('alerts.btn_text') }}",
                scrollbarPadding: false,
            };

            const data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('emails-settings.store') }}",
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

		set_select2();
    </script>
@endpush
