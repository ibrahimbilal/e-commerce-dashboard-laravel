@extends('admin.layout')

@section('title', 'Store Settings')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
	<!-- icons-->
    <link href="{{ asset('css/uicons-brands.css') }}" rel="stylesheet">
@endpush


@section('content')
    @php
        // breadcrumbs params
        $params = [
            'page_title' => __('admin.menu.store_settings.title'),
            'breadcrumbs_items' => ['title' => __('admin.menu.store_settings.title')],
        ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="settings-form" data-post-type="settings">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.store_address') }}</h2>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="country">{{ __('forms.country') }}</label>
                    <select class="form-select" id="country" name="country">
                        <option value="">{{ __('forms.select_country') }}</option>
                        @foreach (list_of_countries() as $code => $country )
							<option value="{{ $code }}" @isset($datas['country']) @selected($datas['country'] == $code) @endisset>{{ $country }}</option>
						@endforeach
                    </select>
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="state">{{ __('forms.state') }}</label>
                    <input class="form-control"
							id="state"
							name="state"
							value="@isset($datas['state']){{ $datas['state'] }}@endisset"
							type="text"
							autocomplete="on">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="city">{{ __('forms.city') }}</label>
                    <input class="form-control"
							id="city"
							name="city"
							value="@isset($datas['city']){{ $datas['city'] }}@endisset"
							type="text"
							autocomplete="on">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="address-1">{{ __('forms.address.1.title') }}</label>
                    <input class="form-control"
							id="address-1"
							name="address_1"
							value="@isset($datas['address_1']){{ $datas['address_1'] }}@endisset"
							type="text"
							autocomplete="on"
							placeholder="{{ __('forms.address.1.placeholder') }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="address-2">{{ __('forms.address.2.title') }}</label>
                    <input class="form-control"
							id="address-2"
							name="address_2"
							value="@isset($datas['address_2']){{ $datas['address_2'] }}@endisset"
							type="text"
							autocomplete="on"
							placeholder="{{ __('forms.address.2.placeholder') }}">
                </div>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title" for="postcode">{{ __('forms.postcode') }}</label>
                    <input class="form-control"
							id="postcode"
							name="postcode"
							value="@isset($datas['postcode']){{ $datas['postcode'] }}@endisset"
							type="text"
							autocomplete="on">
                </div>
            </div>
            <div class="main-box box-spaces">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.store_settings') }}</h2>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="allow-reviews">{{ __('forms.allow_reviews.title') }}<span class="icon info ms-2"
                            tooltip="{{ __('forms.allow_reviews.tooltip') }}" flow="up"><i
                                class="fi-rr-info"> </i></span></label>
                    <label class="switch text-start">
                        <input class="switch"
								id="allow-reviews"
								type="checkbox"
								name="reviews"
								value="1"
								@isset($datas['reviews']) @checked($datas['reviews'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="allow-guest-reviews">{{ __('forms.allow_geust_reviews') }}</label>
                    <label class="switch text-start">
                        <input class="switch"
						id="allow-guest-reviews"
						type="checkbox"
						name="guest_reviews"
						value="1"
						@isset($datas['guest_reviews']) @checked($datas['guest_reviews'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="allow-checkout">{{ __('forms.allow_geust_checkout.title') }}<span class="icon info ms-2"
                            tooltip="{{ __('forms.allow_geust_checkout.tooltip') }}"
                            flow="up"><i class="fi-rr-info"> </i></span></label>
                    <label class="switch text-start">
                        <input class="switch"
						id="allow-checkout"
						type="checkbox"
						name="guest_checkout"
						value="1"
						@isset($datas['guest_checkout']) @checked($datas['guest_checkout'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="active-wishlist">{{ __('forms.active_wishlist') }}</label>
                    <label class="switch text-start">
                        <input class="switch"
						id="active-wishlist"
						type="checkbox"
						name="wishlist"
						value="1"
						@isset($datas['wishlist']) @checked($datas['wishlist'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="active-compare">{{ __('forms.active_compare') }}</label>
                    <label class="switch text-start">
                        <input class="switch"
						id="active-compare"
						type="checkbox"
						name="compare"
						value="1"
						@isset($datas['compare']) @checked($datas['compare'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="out-of-stock-products">{{ __('forms.allow_out_of_stock.title') }}<span
                            class="icon info ms-2" tooltip="{{ __('forms.allow_out_of_stock.tooltip') }}"
                            flow="up"><i class="fi-rr-info"> </i></span></label>
                    <label class="switch text-start">
                        <input class="switch"
						id="out-of-stock-products"
						type="checkbox"
						name="out_of_stock_products"
						value="1"
                        @isset($datas['out_of_stock_products']) @checked($datas['out_of_stock_products'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="social-share">{{ __('forms.enable_social_share') }}</label>
                    <label class="switch text-start">
                        <input class="switch control-toggle"
						id="social-share"
						type="checkbox"
						value="1"
						data-toggle="social-share-items"
						name="social_share"
						@isset($datas['social_share']) @checked($datas['social_share'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>

                <div class="form-item second d-flex align-items-center mt-3 @if(!isset($datas['social_share']) || $datas['social_share'] == false) d-none @endif" id="social-share-items">
                    <label class="item-title">{{ __('forms.enable_share_on') }}</label>
                    <label class="icon-checkbox">
                        <input type="checkbox"
						name="share_on[]"
						value="facebook"
						@isset($datas['share_on']) @checked(in_array('facebook', json_decode($datas['share_on']))) @endisset>
						<span class="icon facebook"><i class="fi-brands-facebook"> </i></span>
                    </label>
                    <label class="icon-checkbox">
                        <input type="checkbox"
						name="share_on[]"
						value="twitter"
						@isset($datas['share_on']) @checked(in_array('twitter', json_decode($datas['share_on']))) @endisset>
						<span class="icon twitter"><i class="fi-brands-twitter"> </i></span>
                    </label>
                    <label class="icon-checkbox">
                        <input type="checkbox"
						name="share_on[]"
						value="instagram"
						@isset($datas['share_on']) @checked(in_array('instagram', json_decode($datas['share_on']))) @endisset>
						<span class="icon instagram"><i class="fi-brands-instagram"> </i></span>
                    </label>
                    <label class="icon-checkbox">
                        <input type="checkbox"
						name="share_on[]"
						value="whatsapp"
						@isset($datas['share_on']) @checked(in_array('whatsapp', json_decode($datas['share_on']))) @endisset>
						<span class="icon whatsapp"><i class="fi-brands-whatsapp"> </i></span>
                    </label>
                    <label class="icon-checkbox">
                        <input type="checkbox"
						name="share_on[]"
						value="mail"
						@isset($datas['share_on']) @checked(in_array('mail', json_decode($datas['share_on']))) @endisset>
						<span class="icon envelope"><i class="fi-rr-envelope"> </i></span>
                    </label>
                </div>
            </div>
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.store_sections_settings') }}</h2>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="recently-viewed">{{ __('forms.active_recently_viewed.title') }}<span class="icon info ms-2"
                            tooltip="{{ __('forms.active_recently_viewed.tooltip') }}" flow="up"><i
                                class="fi-rr-info"> </i></span></label>
                    <label class="switch text-start">
                        <input class="switch"
						id="recently-viewed"
						type="checkbox"
						name="recently_viewed"
						value="1"
						@isset($datas['recently_viewed']) @checked($datas['recently_viewed'] == true) @endisset>
						<span class="slider"></span>
                    </label>
                </div>
                <div class="form-item second d-flex align-items-center mt-3">
                    <label class="item-title" for="recommend">{{ __('forms.active_recommendations.title') }}<span class="icon info ms-2"
                            tooltip="{{ __('forms.active_recommendations.tooltip') }}"
                            flow="up"><i class="fi-rr-info"> </i></span></label>
                    <label class="switch text-start">
                        <input class="switch"
						id="recommend"
						type="checkbox"
						name="recommend"
						value="1"
						@isset($datas['recommend']) @checked($datas['recommend'] == true) @endisset>
						<span class="slider"></span>
                    </label>
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
        // form Ajax Request
        $('form#settings-form').on('submit', function(e) {
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
                url: "{{ route('store-settings.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
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
    </script>
@endpush
