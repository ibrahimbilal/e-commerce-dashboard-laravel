@extends('admin.layout')

@section('title', 'General Settings')

@section('content')
    @php
    // breadcrumbs params
    $params = [
        'page_title' => 'Settings',
        'breadcrumbs_items' => ['title' => 'settings'],
    ];
    @endphp
    @include('admin.inc.page_title', $params)

    <form class="row d-block clearfix" id="settings-forms" method="POST">
        <div class="col-sm-12 col-lg-9 float-start post-box">
            <div class="main-box box-spaces mb-0">
                <div class="form-item primary mb-3">
                    <h2 class="box-title item-title">General Settings </h2>
                </div>

                {{-- Alerts --}}
                @if ($errors->any())
                    <div class="alerts danger">
                        <ul class="list">
                            @foreach ($errors->all() as $error)
                                <li class="content">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alerts success">
                        <ul class="list">
                            <li class="content">{{ session('status') }}</li>
                        </ul>
                    </div>
                @endif

                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="site-title">site title:</label>
                    <input class="form-control" id="site-title" name="site_title" type="text"
                        value="{{ isset($datas['site_title']) ? $datas['site_title'] : '' }}"
                        value="{{ old('site_title') }}">
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title mt-1" for="tagline">tagline:</label>
                    <div class="input-holder w-100">
                        <input class="form-control" id="tagline" name="tagline" type="text"
                            value="{{ isset($datas['tagline']) ? $datas['tagline'] : '' }}" value="{{ old('tagline') }}">
                        <small>In A Few Words, Explain What This Site Is About.</small>
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title mt-1" for="site-desc">Site Description:</label>
                    <textarea class="form-control" id="site-desc" name="site_description" rows="4" style="resize:none">{{ isset($datas['site_description']) ? $datas['site_description'] : '' }} {{ old('site_description') }}</textarea>
                </div>
                <hr>
                <div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
                    <label class="item-title" for="site-url">site URL:</label>
                    <input class="form-control" id="site-url" name="site_url" type="url"
                        placeholder="https://example.com/" value="{{ isset($datas['site_url']) ? $datas['site_url'] : '' }}"
                        value="{{ old('site_url') }}">
                </div>
                <div class="form-item second d-flex mt-3 flex-wrap">
                    <div class="item-title d-block mb-2">
                        <label class="item-title d-block">Favicon:</label><small>Site Icons Should Be Square And At Least 512 × 512 Pixels.</small>
                    </div>
                    <div class="item-content">
                        <a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
                        <div class="selected-img">
                            <div class="img-holder mt-3">
                                <img class="preview p-1" src="{{ asset('images/logo.png') }}" width="70">
                                <span class="overlay">
                                    <i class="fi-rr-trash"></i>
                                    <span>remove</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title mt-2" for="timezone">Timezone:</label>
                    <div class="input-holder w-100">
                        <select class="form-select" id="timezone" name="timezone">
                            @foreach (list_of_timezons() as $key => $val)
                                <option value="{{ $key }}" {{ isset($datas['timezone']) ? selected($datas['timezone'], $key, 'select') : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                        <small>UTC Time Is: {{ now() }}</small><br>
						@if ( isset($datas['timezone']) )
							<small>Server Time Is: {{ now($datas['timezone']) }}</small>
						@endif
                    </div>
                </div>
                <div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
                    <label class="item-title">Date Formate:</label>
                    <div class="input-holder w-100">
						@foreach (['F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y'] as $k => $date_formate )
							<label class="radio-label w-100 mb-3">
								<input class="input-radio" type="radio" name="date_formate" value="{{ $date_formate }}"
									{{ isset($datas['date_formate']) ? selected($datas['date_formate'], $date_formate, 'radio') : '' }}
									{{ !isset($datas['date_formate']) && $k == 0 ? 'checked' : '' }}
									{{ old('date_formate') == $date_formate ? 'checked' : '' }}>{{ date($date_formate) }}
							</label>
						@endforeach
                        <label class="radio-label w-100 mb-3">
                            <input class="input-radio" type="radio" name="date_formate" value="custom"
								{{ isset($datas['date_formate']) ? selected($datas['date_formate'], 'custom', 'radio') : '' }}
                                {{ old('date_formate') == 'custom' ? 'checked' : '' }}>Custom:
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
                    <label class="item-title">Time Formate:</label>
                    <div class="input-holder w-100">
						@foreach (['g:i a', 'g:i A', 'H:i'] as $k => $time_formate )
							<label class="radio-label w-100 mb-3">
								<input class="input-radio" type="radio" name="time_formate" value="{{ $time_formate }}"
									{{ isset($datas['time_formate']) ? selected($datas['time_formate'], $time_formate, 'radio') : '' }}
									{{ !isset($datas['time_formate']) && $k == 0 ? 'checked' : '' }}
									{{ old('time_formate') == $time_formate ? 'checked' : '' }}>{{ date($time_formate) }}
							</label>
						@endforeach
                        </label>
                        <label class="radio-label w-100">
                            <input class="input-radio" type="radio" name="time_formate" value="custom"
								{{ isset($datas['time_formate']) ? selected($datas['time_formate'], 'custom', 'radio') : '' }}
                                {{ old('time_formate') == 'custom' ? 'checked' : '' }}>Custom:
                            <input class="text-center me-2" type="text" name="time_formate_custom"
                                placeholder="g:i a" style="width: 70px"
                                value="{{ isset($datas['time_formate_custom']) ? $datas['time_formate_custom'] : '' }}"
                                value="{{ old('time_formate_custom') }}"
                                {{ isset($datas['time_formate']) && $datas['time_formate'] !== 'custom' ? 'disabled' : '' }}><span
                                id="preview">9:23 pm</span>
                        </label>
						<a class="mt-3 d-inline-block" href="https://www.php.net/manual/en/datetime.format.php"
                            target="_blank">Documentation on date and time formatting.</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 float-end meta-box">
            <div class="main-box box-spaces mb-0 mt-3 mt-lg-0">
                <div class="btns-holder d-flex justify-content-between">
                    <button class="btn solid-btn w-100" type="submit">Save Changes </button>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script>
        // Date Preview
        $('input[name=time_formate_custom], input[name=date_formate_custom]').on('change', function() {

            var previewEl = $(this).next('#preview'),
                format = $(this).val();

            $.ajax({
                type: 'POST',
                url: "{{ route('date_preview') }}",
                data: {
					"_token": "{{ csrf_token() }}",
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
            var data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('general-settings.store') }}",
                headers: {
					"X-CSRF-TOKEN": "{{ csrf_token() }}",
				},
                data: data,
                success: function(res) {
					if ( res.success ) {
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
							html: '<ul class="errors-list">' + Object.keys(res.errors).map(k => '<li class="content">' + res.errors[k] + '</li>').join('') + '</ul>',
							showConfirmButton: true,
							confirmButtonColor: 'var(--main-color)',
						});
					}
                }
            });
        });
    </script>
@endsection
