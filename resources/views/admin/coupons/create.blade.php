@extends('admin.layout')

@section('title', 'E-Commerce Project')

@push('stylesheet')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">add coupon</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.coupons.index') }}">coupons</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.coupons.store') }}" class="row clearfix" data-post-type="coupon" id="add-newitem-form" method="POST">
@csrf
<div class="col-sm-12 col-lg-9 post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">coupon details</h2>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap">
<label class="item-title" for="coupon-title">title</label>
<input class="form-control" id="coupon-title" name="title" type="text" value="{{ old('title') }}" maxlength="100" required/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="coupon-code">code</label>
<input class="form-control text-uppercase" id="coupon-code" name="code" type="text" value="{{ old('code') }}" maxlength="10" required/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="coupon-discount">discount amount</label>
<input class="form-control" id="coupon-discount" name="discount" type="number" step="0.01" min="0" value="{{ old('discount') }}" required/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="coupon-type">discount type</label>
<select class="form-select" id="coupon-type" name="type">
<option value="percent" @selected(old('type', 'percent') === 'percent')>percentage</option>
<option value="fixed" @selected(old('type') === 'fixed')>fixed amount</option>
</select>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="usage-limit">usage limit</label>
<input class="form-control" id="usage-limit" name="usage_limit" type="number" min="0" step="1" value="{{ old('usage_limit', 0) }}" required/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="usage-per-customer">usage per customer</label>
<input class="form-control" id="usage-per-customer" name="usage_per_customer" type="number" min="0" step="1" value="{{ old('usage_per_customer', 0) }}" required/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="coupon-expired-at">expires at</label>
<input class="form-control" data-toggle="datepicker" id="coupon-expired-at" name="expired_at" type="text" value="{{ old('expired_at') }}"/>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="coupon-active">active?</label>
<label class="switch text-start ms-sm-3">
<input type="hidden" name="active" value="0"/>
<input class="switch" id="coupon-active" name="active" type="checkbox" value="1" @checked(old('active', true))/><span class="slider"></span>
</label>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 meta-box">
<div class="main-box box-spaces">
<div class="btns-holder d-flex justify-content-end mt-4">
<button class="btn solid-btn" type="submit">publish </button>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
@endpush
