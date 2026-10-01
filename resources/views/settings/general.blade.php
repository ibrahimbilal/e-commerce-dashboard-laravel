@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">settings</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">settings</span>
</div>
</div>
</div>
</div>
</div>
@csrf
@method('PUT')
<form action="{{ route('settings.update') }}" class="row d-block clearfix" data-post-type="settings" id="settings-form" method="POST">
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces mb-0">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">General Settings </h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="site-title">site title:</label>
<input class="form-control" id="site-title" name="site_title" type="text"/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title mt-1" for="tagline">tagline:</label>
<div class="input-holder w-100">
<input class="form-control" id="tagline" name="tagline" type="text"/><small>In A Few Words, Explain What This Site Is About.</small>
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title mt-1" for="site-desc">Site Description:</label>
<textarea class="form-control" id="site-desc" name="site_desc" rows="4" style="resize:none"></textarea>
</div>
<hr/>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="site-url">site URL:</label>
<input class="form-control" id="site-url" name="site_url" placeholder="https://example.com/" type="url"/>
</div>
<div class="form-item second d-flex mt-3 flex-wrap">
<div class="item-title d-block mb-2">
<label class="item-title d-block">Favicon:</label><small>Site Icons Should Be Square And At Least 512 × 512 Pixels.</small>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview p-1" src="{{ asset('assets/images/logo.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<hr/>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title mt-2" for="timezone">Timezone:</label>
<div class="input-holder w-100">
<select class="form-select" id="timezone" name="timezone">
<option>UTC +0</option>
<option>UTC +1</option>
<option>UTC +2</option>
<option>UTC +3</option>
<option>UTC +4</option>
<option>UTC +5</option>
<option>UTC +6</option>
<option>UTC +7</option>
<option>UTC +8</option>
<option>UTC +9</option>
<option>UTC +10</option>
<option>UTC +11</option>
<option>UTC +12</option>
</select><small>UTC Time Is: 2025-5-4 16:1:15</small>
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title">Date Formate:</label>
<div class="input-holder w-100">
<label class="radio-label w-100 mb-3">
<input checked="" class="input-radio" name="date_formate" type="radio" value="F j, Y"/>December 10, 2022
                </label>
<label class="radio-label w-100 mb-3">
<input class="input-radio" name="date_formate" type="radio" value="Y-m-d"/>2022/12/10
                </label>
<label class="radio-label w-100 mb-3">
<input class="input-radio" name="date_formate" type="radio" value="m/d/Y"/>12/10/2022
                </label>
<label class="radio-label w-100 mb-3">
<input class="input-radio" name="date_formate" type="radio" value="d/m/Y"/>10/12/2022
                </label>
<label class="radio-label w-100 mb-3">
<input class="input-radio" name="date_formate" type="radio" value="custom"/>Custom:
                  <input class="text-center me-2" disabled="" name="date_formate_custom" placeholder="d-M-Y" style="width: 70px" type="text"/>10-Dec-2022
                </label>
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title">Time Formate:</label>
<div class="input-holder w-100">
<label class="radio-label w-100 mb-3">
<input checked="" class="input-radio" name="time_formate" type="radio" value="g:i a"/>9:23 pm
                </label>
<label class="radio-label w-100 mb-3">
<input class="input-radio" name="time_formate" type="radio" value="g:i A"/>9:23 PM
                </label>
<label class="radio-label w-100 mb-3">
<input class="input-radio" name="time_formate" type="radio" value="H:i"/>21:23
                </label>
<label class="radio-label w-100">
<input class="input-radio" name="time_formate" type="radio" value="custom"/>Custom:
                  <input class="text-center me-2" disabled="" name="time_formate_custom" placeholder="g:i a" style="width: 70px" type="text"/>9:23 pm
                </label>
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title"></label>
<div class="input-holder w-100"><a href="javascript:void(0)">Documentation on date and time formatting.</a></div>
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

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush

