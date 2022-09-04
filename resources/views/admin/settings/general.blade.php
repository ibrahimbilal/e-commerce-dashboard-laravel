@extends('admin.layout')

@section('title', 'General Settings')

@push('stylesheet')
	<!-- Sweet Alert 2 -->
	<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endpush


@section('content')
    @php
    // breadcrumbs params
    $params = [
        'page_title' => __('admin.menu.general_settings.title'),
        'breadcrumbs_items' => ['title' => __('admin.menu.general_settings.title')],
    ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="settings-forms" method="POST">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">{{ __('admin.sections.general_settings') }}</h2>
                </div>

                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="site-title">{{ __('forms.site_title') }}</label>
                    <input class="form-control" id="site-title" name="site_title" type="text"
                        value="@isset($datas['site_title']) {{ $datas['site_title'] }} @endisset"
                        value="{{ old('site_title') }}">
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title mt-1" for="tagline">{{ __('forms.tagline.title') }}</label>
                    <div class="input-holder w-100">
                        <input class="form-control" id="tagline" name="tagline" type="text"
							value="@isset($datas['tagline']) {{ $datas['tagline'] }} @endisset"
							value="{{ old('tagline') }}">
                        <small>{{ __('forms.tagline.sub') }}</small>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title mt-1" for="site-desc">{{ __('forms.site_description') }}</label>
                    <textarea class="form-control" id="site-desc" name="site_description" rows="4" style="resize:none">@isset($datas['site_description']) {{ $datas['site_description'] }} @endisset {{ old('site_description') }}</textarea>
                </div>
                <hr>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="site-url">{{ __('forms.site_url') }}</label>
                    <input class="form-control" id="site-url" name="site_url" type="url"
                        placeholder="https://example.com/"
						value="@isset($datas['site_url']) {{ $datas['site_url'] }} @endisset"
                        value="{{ old('site_url') }}">
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title d-block">{{ __('forms.favicon.title') }}</label>
						<small>{{ __('forms.favicon.sub') }}</small>
                    </div>
                    <div class="item-content">
                        <a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">{{ __('buttons.change_image') }}</a>
                        <div class="selected-img">
                            <div class="img-holder mt-3">
                                <img class="preview p-1" src="{{ asset('images/logo.png') }}" width="70">
                                <span class="overlay">
                                    <i class="fi-rr-trash"></i>
                                    <span>{{ __('buttons.remove') }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title mt-2" for="timezone">{{ __('forms.timezone') }}</label>
                    <div class="input-holder w-100">
                        <select class="form-select" id="timezone" name="timezone">
                            @foreach (list_of_timezons() as $key => $val)
                                <option value="{{ $key }}" @isset($datas['timezone']) @selected($datas['timezone'] == $key) @endisset>{{ $val }}</option>
                            @endforeach
                        </select>
                        <small>{{ __('forms.utc_time') }} {{ now() }}</small><br>
						@isset( $datas['timezone'] )
							<small>{{ __('forms.server_time') }} {{ now($datas['timezone']) }}</small>
						@endisset
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">{{ __('forms.date_format') }}</label>
                    <div class="input-holder w-100">
						@foreach (['F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y'] as $k => $date_formate )
							<label class="radio-label w-100 mb-3">
								<input class="input-radio" type="radio" name="date_formate" value="{{ $date_formate }}"
									@isset($datas['date_formate']) @checked($datas['date_formate'] == $date_formate) @endisset
									{{ !isset($datas['date_formate']) && $k == 0 ? 'checked' : '' }}
									{{ old('date_formate') == $date_formate ? 'checked' : '' }}>{{ date($date_formate) }}
							</label>
						@endforeach
                        <label class="radio-label w-100 mb-3">
                            <input class="input-radio" type="radio" name="date_formate" value="custom"
								@isset($datas['date_formate']) @checked($datas['date_formate'] == 'custom') @endisset
                                {{ old('date_formate') == 'custom' ? 'checked' : '' }}>{{ __('forms.custom') }}
                            <input class="text-center me-2" type="text" name="date_formate_custom"
                                placeholder="d-M-Y" style="width: 70px"
                                value="{{ isset($datas['date_formate_custom']) ? $datas['date_formate_custom'] : '' }}"
                                value="{{ old('date_formate_custom') }}"
                                {{ isset($datas['date_formate']) && $datas['date_formate'] !== 'custom' ? 'disabled' : '' }}><span
                                id="preview">10-Dec-2022</span>
                        </label>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">{{ __('forms.time_format') }}</label>
                    <div class="input-holder w-100">
						@foreach (['g:i a', 'g:i A', 'H:i'] as $k => $time_formate )
							<label class="radio-label w-100 mb-3">
								<input class="input-radio" type="radio" name="time_formate" value="{{ $time_formate }}"
									@isset($datas['time_formate']) @checked($datas['time_formate'] == $time_formate) @endisset
									{{ !isset($datas['time_formate']) && $k == 0 ? 'checked' : '' }}
									{{ old('time_formate') == $time_formate ? 'checked' : '' }}>{{ date($time_formate) }}
							</label>
						@endforeach
                        </label>
                        <label class="radio-label w-100">
                            <input class="input-radio" type="radio" name="time_formate" value="custom"
								@if (isset($datas['time_formate'])) @checked($datas['time_formate'] == 'custom') @endif
                                {{ old('time_formate') == 'custom' ? 'checked' : '' }}>{{ __('forms.custom') }}
                            <input class="text-center me-2" type="text" name="time_formate_custom"
                                placeholder="g:i a" style="width: 70px"
                                value="{{ isset($datas['time_formate_custom']) ? $datas['time_formate_custom'] : '' }}"
                                value="{{ old('time_formate_custom') }}"
                                {{ isset($datas['time_formate']) && $datas['time_formate'] !== 'custom' ? 'disabled' : '' }}><span
                                id="preview">9:23 pm</span>
                        </label>
						<a class="mt-3 d-inline-block" href="https://www.php.net/manual/en/datetime.format.php"
                            target="_blank">{{ __('forms.date_time_doc') }}</a>
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
        // Date Preview
        $('input[name=time_formate_custom], input[name=date_formate_custom]').on('change', function() {

            var previewEl = $(this).next('#preview'),
                format = $(this).val();

            $.ajax({
                type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
                url: "{{ route('date_preview') }}",
                data: {
                    format: format
                },
                success: function(data) {
                    previewEl.text(data.preview);
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
                url: "{{ route('general-settings.store') }}",
                headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
                data: data,
                success: function(res) {
					if ( res.success ) {
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
