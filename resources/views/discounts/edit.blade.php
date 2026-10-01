@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">edit discount</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('discounts.index') }}">discounts</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('discounts.update', $discount) }}" class="row clearfix" data-post-type="discount" id="add-newitem-form" method="POST">
@csrf
@method('PUT')
<div class="col-sm-12">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">discount title</h2>
<input class="form-control" id="discount-name" name="discount_name" type="text" value="{{ old('discount_name', $discount->discount_name ?? '') }}" />
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">discount details</h2>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap">
<label class="item-title" for="the-discount">the discount:<span class="icon info ms-2" flow="up" tooltip="write the number of the discount only."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="the-discount" name="the_discount" type="text" value="{{ old('the_discount', $discount->the_discount ?? '') }}" />
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-type">discount type:<span class="icon info ms-2" flow="up" tooltip="write the number of the discount only."><i class="fi-rr-info"> </i></span></label>
<select class="form-select" id="discount-type" name="discount_type">
<option>percentage</option>
<option>Static</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-start-date">Discount Start Date:<span class="icon info ms-2" flow="up" tooltip="the date which sale will be end."><i class="fi-rr-info"> </i></span></label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="discount-start-date" name="discount_start_date" type="text" value="{{ old('discount_start_date', $discount->discount_start_date ?? '') }}" />
</div>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-end-date">Discount End Date:<span class="icon info ms-2" flow="up" tooltip="the date which sale will be end."><i class="fi-rr-info"> </i></span></label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="discount-end-date" name="discount_end_date" type="text" value="{{ old('discount_end_date', $discount->discount_end_date ?? '') }}" />
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-type">Apply Discount To:<span class="icon info ms-2" flow="up" tooltip="write the number of the discount only."><i class="fi-rr-info"> </i></span></label>
<select class="form-select" id="discount-type" name="discount_type">
<option>all products</option>
<option>specific category</option>
</select>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-new">Active This discount?<span class="icon info ms-2" flow="up" tooltip="check this if you want active this discount."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="product-new" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 meta-box">
<div class="row d-block clearfix">
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">created at: </label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<form method="POST" action="{{ route('discounts.destroy', $discount) }}" class="w-100 d-inline destroy-resource-form">
@csrf
@method('DELETE')
<button type="button" class="btn trans-btn w-100 text-start js-destroy-submit" data-confirm-label="discount" data-post-type="discount"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
</div>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.date.js') }}" type="text/javascript"></script>
@endpush

