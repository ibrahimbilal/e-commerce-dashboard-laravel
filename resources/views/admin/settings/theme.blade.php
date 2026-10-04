@extends('admin.layout')

@section('title', 'Theme Settings')

@push('stylesheet')
    <!-- Sweet Alert 2 -->
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush


@section('content')
    @php
        // breadcrumbs params
        $params = [
            'page_title' => __('admin.menu.theme_settings.title'),
            'breadcrumbs_items' => ['title' => __('admin.menu.theme_settings.title')],
        ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="settings-forms" method="POST">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.theme_settings') }}</h2>
                </div>

                <div class="form-item second d-flex flex-wrap">
                    <div class="item-title mb-2">
                        <label class="item-title">{{ __('forms.logo') }}</label>
                    </div>
                    <div class="item-content">
						<a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">
							@if(isset( $sets['logo'] ))
								{{ __('buttons.change_image') }}
							@else
								{{ __('buttons.select_image') }}
							@endif
						</a>
						<input type="hidden" name="logo" value="">
                        <div class="selected-img @if(!isset( $sets['logo'] )) d-none @endif">
                            <div class="img-holder mt-3">
								<img class="preview p-1" src="{{ asset('images/full-logo.png') }}" width="70">
									<span class="overlay"><i class="fi-rr-trash">
                                    </i><span>{{ __('buttons.remove') }}</span></span></div>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <div class="item-title mb-2">
                        <label class="item-title">{{ __('forms.dark_logo') }}</label>
                    </div>
                    <div class="item-content">
						<a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">
							@if(isset( $sets['dark_logo'] ))
								{{ __('buttons.change_image') }}
							@else
								{{ __('buttons.select_image') }}
							@endif
						</a>
						<input type="hidden" name="dark_logo" value="">
                        <div class="selected-img @if(!isset( $sets['dark_logo'] )) d-none @endif">
                            <div class="img-holder mt-3">
								<img class="preview p-1" src="{{ asset('images/full-logo.png') }}" width="70">
								<span class="overlay"><i class="fi-rr-trash"></i><span>{{ __('buttons.remove') }}</span></span>
							</div>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <label class="item-title">{{ __('forms.logo_width') }}</label>
                    <div class="rang-wrapper d-flex align-items-center">
                        <input class="form-range"
								name="logo_width"
								type="range"
								min="0"
								max="300"
								step="10"
								value="@isset($sets['logo_width']){{ $sets['logo_width'] }}@endisset"
								oninput="rangevalue.value=value">
						<output class="text-center ms-2" id="rangevalue">{{ $sets['logo_width'] }}</output>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <label class="item-title">{{ __('forms.logo_height') }}</label>
                    <div class="rang-wrapper d-flex align-items-center">
                        <input class="form-range"
								name="logo_height"
								type="range"
								min="0"
								max="300"
								step="10"
								value="@isset($sets['logo_height']){{ $sets['logo_height'] }}@endisset"
								oninput="rangevalue_2.value=value">
						<output class="text-center ms-2" id="rangevalue_2">{{ $sets['logo_height'] }}</output>
                    </div>
                </div>
                <hr>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <div class="item-title mb-2">
                        <label class="item-title">{{ __('forms.mobile_logo') }}</label>
                    </div>
                    <div class="item-content">
						<a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">
							@if(isset( $sets['mobile_logo'] ))
								{{ __('buttons.change_image') }}
							@else
								{{ __('buttons.select_image') }}
							@endif
						</a>
						<input type="hidden" name="mobile_logo" value="">
                        <div class="selected-img @if(!isset( $sets['mobile_logo'] )) d-none @endif">
                            <div class="img-holder mt-3">
								<img class="preview p-1" src="{{ asset('images/full-logo.png') }}" width="70">
								<span class="overlay"><i class="fi-rr-trash"></i><span>{{ __('buttons.remove') }}</span></span>
							</div>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <div class="item-title mb-2">
                        <label class="item-title">{{ __('forms.dark_mobile_logo') }}</label>
                    </div>
                    <div class="item-content">
						<a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">
							@if(isset( $sets['dark_mobile_logo'] ))
								{{ __('buttons.change_image') }}
							@else
								{{ __('buttons.select_image') }}
							@endif
						</a>
						<input type="hidden" name="dark_mobile_logo" value="">
                        <div class="selected-img @if(!isset( $sets['dark_mobile_logo'] )) d-none @endif">
                            <div class="img-holder mt-3">
								<img class="preview p-1" src="{{ asset('images/full-logo.png') }}" width="70">
								<span class="overlay"><i class="fi-rr-trash"></i><span>{{ __('buttons.remove') }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <label class="item-title">{{ __('forms.mobile_logo_width') }}</label>
                    <div class="rang-wrapper d-flex align-items-center">
                        <input class="form-range"
								name="mobile_logo_width"
								type="range"
								min="0"
								max="300"
								step="10"
								value="@isset($sets['mobile_logo_width']){{ $sets['mobile_logo_width'] }}@endisset"
								oninput="rangevalue_1.value=value"
						>
						<output class="text-center ms-2" id="rangevalue_1">{{ $sets['mobile_logo_width'] }}</output>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap mt-3">
                    <label class="item-title">{{ __('forms.mobile_logo_height') }}</label>
                    <div class="rang-wrapper d-flex align-items-center">
                        <input class="form-range"
								name="mobile_logo_height"
								type="range"
								min="0"
								max="300"
								step="10"
								value="{{ $sets['mobile_logo_height'] ?? '' }}"
								oninput="rangevalue_3.value=value">
						<output class="text-center ms-2" id="rangevalue_3">{{ $sets['mobile_logo_height'] ?? '' }}</output>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center">
                            <label class="item-title mb-2">{{ __('forms.main_color') }}</label>
                            <input class="form-control-color"
								type="color"
								name="main_color"
								value="@isset($sets['main_color']){{ $sets['main_color'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center">
                            <label class="item-title mb-2">{{ __('forms.main_color_hover') }}</label>
                            <input class="form-control-color"
								type="color"
								name="main_color_hover"
								value="@isset($sets['main_color_hover']){{ $sets['main_color_hover'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
					<div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.bg_color') }}</label>
                            <input class="form-control-color"
								type="color"
								name="body_background"
								value="@isset($sets['body_background']){{ $sets['body_background'] }}@endisset"
								title="Choose your color">
                        </div>
                    </div>
					<div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.active_bg_color') }}</label>
                            <input class="form-control-color"
								type="color"
								name="menu_active_bg"
								value="@isset($sets['menu_active_bg']){{ $sets['menu_active_bg'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.boxes_color') }}</label>
                            <input class="form-control-color"
								type="color"
								name="box_bg_color"
								value="@isset($sets['box_bg_color']){{ $sets['box_bg_color'] }}@endisset"
								title="Choose your color">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.text_color') }}</label>
                            <input class="form-control-color"
								type="color"
								name="text_color"
								value="@isset($sets['text_color']){{ $sets['text_color'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
					<div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.badge_color') }}</label>
                            <input class="form-control-color"
								type="color"
								name="menu_badge_bg"
								value="@isset($sets['menu_badge_bg']){{ $sets['menu_badge_bg'] }}@endisset"
								title="Choose your color">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center">
                            <label class="item-title mb-2">{{ __('forms.dark_main_color') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_main_color"
								value="@isset($sets['dark_main_color']){{ $sets['dark_main_color'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center">
                            <label class="item-title mb-2">{{ __('forms.dark_main_color_hover') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_main_color_hover"
								value="@isset($sets['dark_main_color_hover']){{ $sets['dark_main_color_hover'] }}@endisset"
								title="Choose your color">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.dark_bg_color') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_body_background"
								value="@isset($sets['dark_body_background']){{ $sets['dark_body_background'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>

					<div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.dark_active_bg_color') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_menu_active_bg"
								value="@isset($sets['dark_menu_active_bg']){{ $sets['dark_menu_active_bg'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
					<div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.dark_boxes_color') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_box_bg_color"
								value="@isset($sets['dark_box_bg_color']){{ $sets['dark_box_bg_color'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.dark_text_color') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_text_color"
								value="@isset($sets['dark_text_color']){{ $sets['dark_text_color'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
					<div class="col-sm-6">
                        <div class="form-item second d-flex flex-wrap align-items-center mt-3">
                            <label class="item-title mb-2">{{ __('forms.dark_badge_color') }}</label>
                            <input class="form-control-color dark"
								type="color"
								name="dark_menu_badge_bg"
								value="@isset($sets['dark_menu_badge_bg']){{ $sets['dark_menu_badge_bg'] }}@endisset"
                                title="Choose your color">
                        </div>
                    </div>
                </div>
                <div class="form-item second mt-3">
                    <button type="button" class="btn trans-btn" id="reset-theme-colors">{{ __('forms.reset_default_colors') }}</button>
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
    <script type="application/json" id="theme-color-preview-config">{!! json_encode([
        'variables' => $themeColorVariables ?? [],
        'defaults' => $themeColorDefaults ?? [],
        'messages' => [
            'ok' => __('alerts.btn_text'),
            'confirmTitle' => __('forms.reset_default_colors_confirm.title'),
            'confirmText' => __('forms.reset_default_colors_confirm.text'),
            'confirmYes' => __('forms.reset_default_colors_confirm.yes'),
            'confirmNo' => __('forms.reset_default_colors_confirm.no'),
        ],
    ], JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>
    <script src="{{ asset('assets/js/theme-color-preview.js') }}" type="text/javascript"></script>
    <script>
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
                url: "{{ route('theme-settings.store') }}",
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
