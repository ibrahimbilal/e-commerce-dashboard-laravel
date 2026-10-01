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
<h2 class="box-title item-title">Theme Settings</h2>
</div>
<div class="form-item second d-flex flex-wrap">
<div class="item-title mb-2">
<label class="item-title">Logo:</label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview p-1" src="{{ asset('assets/images/full-logo.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<div class="form-item second d-flex flex-wrap mt-3">
<div class="item-title mb-2">
<label class="item-title">Logo (Dark):</label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview p-1" src="{{ asset('assets/images/full-logo.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<div class="form-item second d-flex flex-wrap mt-3">
<label class="item-title">Logo Width:</label>
<div class="rang-wrapper d-flex align-items-center">
<output class="text-center me-2" id="rangevalue">150</output>
<input class="form-range" max="300" min="0" oninput="rangevalue.value=value" step="10" type="range" value="150"/>
</div>
</div>
<hr/>
<div class="form-item second d-flex flex-wrap mt-3">
<div class="item-title mb-2">
<label class="item-title">Mobile Logo:</label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview p-1" src="{{ asset('assets/images/full-logo.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<div class="form-item second d-flex flex-wrap mt-3">
<div class="item-title mb-2">
<label class="item-title">Mobile Logo (Dark):</label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview p-1" src="{{ asset('assets/images/full-logo.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<div class="form-item second d-flex flex-wrap mt-3">
<label class="item-title">Mobile Logo Width:</label>
<div class="rang-wrapper d-flex align-items-center">
<output class="text-center me-2" id="rangevalue_1">150</output>
<input class="form-range" max="300" min="0" oninput="rangevalue_1.value=value" step="10" type="range" value="150"/>
</div>
</div>
<hr/>
<div class="row">
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center">
<label class="item-title mb-2">Main Color:</label>
<input class="form-control-color" name="main-color" title="Choose your color" type="color" value="#2C2CCC"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center">
<label class="item-title mb-2">Main Color Hover:</label>
<input class="form-control-color" name="main-color-hover" title="Choose your color" type="color" value="#2323a2"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Boxs Color:</label>
<input class="form-control-color" name="box-bg-color" title="Choose your color" type="color" value="#FFFFFF"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Background Color:</label>
<input class="form-control-color" name="body-background" title="Choose your color" type="color" value="#F5F5F5"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Badge Color:</label>
<input class="form-control-color" name="menu-badge-bg" title="Choose your color" type="color" value="#FFA620"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Active BG Color:</label>
<input class="form-control-color" name="menu-active-bg" title="Choose your color" type="color" value="#F3F3FF"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Text Color:</label>
<input class="form-control-color" name="text-color" title="Choose your color" type="color" value="#333333"/>
</div>
</div>
</div>
<hr/>
<div class="row">
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center">
<label class="item-title mb-2">Main Color (Dark):</label>
<input class="form-control-color dark" name="main-color" title="Choose your color" type="color" value="#675ad0"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center">
<label class="item-title mb-2">Main Color Hover (Dark):</label>
<input class="form-control-color dark" name="main-color-hover" title="Choose your color" type="color" value="#877be6"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Boxs Color (Dark):</label>
<input class="form-control-color dark" name="box-bg-color" title="Choose your color" type="color" value="#1D1D1D"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Background Color (Dark):</label>
<input class="form-control-color dark" name="body-background" title="Choose your color" type="color" value="#121212"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Badge Color (Dark):</label>
<input class="form-control-color dark" name="menu-badge-bg" title="Choose your color" type="color" value="#FFA620"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Active BG Color (Dark):</label>
<input class="form-control-color dark" name="menu-active-bg" title="Choose your color" type="color" value="#3c3c3c"/>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Text Color (Dark):</label>
<input class="form-control-color dark" name="text-color" title="Choose your color" type="color" value="#E1E1E1"/>
</div>
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

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush

