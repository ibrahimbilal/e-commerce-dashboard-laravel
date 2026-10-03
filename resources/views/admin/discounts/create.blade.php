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
<h1 class="page-title">add discount</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.discounts.index') }}">discounts</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.discounts.store') }}" class="row clearfix" data-post-type="discount" id="add-newitem-form" method="POST">
@csrf
<div class="col-sm-12">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">discount title</h2>
<input class="form-control" id="discount-name" name="title" type="text" value="{{ old('title') }}"/>
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
<input class="form-control" id="the-discount" name="discount" type="text" value="{{ old('discount') }}"/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-type">discount type:<span class="icon info ms-2" flow="up" tooltip="write the number of the discount only."><i class="fi-rr-info"> </i></span></label>
<select class="form-select" id="discount-type" name="type">
<option value="percent" @selected(old('type') === 'percent')>percentage</option>
<option value="fixed" @selected(old('type') === 'fixed')>Static</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-start-date">Discount Start Date:<span class="icon info ms-2" flow="up" tooltip="the date which sale will be end."><i class="fi-rr-info"> </i></span></label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="discount-start-date" name="start_date" type="text" value="{{ old('start_date') }}"/>
</div>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="discount-end-date">Discount End Date:<span class="icon info ms-2" flow="up" tooltip="the date which sale will be end."><i class="fi-rr-info"> </i></span></label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="discount-end-date" name="end_date" type="text" value="{{ old('end_date') }}"/>
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="apply-to">Apply Discount To:<span class="icon info ms-2" flow="up" tooltip="write the number of the discount only."><i class="fi-rr-info"> </i></span></label>
<select class="form-select" id="apply-to" name="apply_to">
<option value="all" @selected(old('apply_to') === 'all')>all products</option>
<option value="category" @selected(old('apply_to') === 'category')>specific category</option>
</select>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-new">Active This discount?<span class="icon info ms-2" flow="up" tooltip="check this if you want active this discount."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input type="hidden" name="active" value="0"/>
<input class="switch" id="product-new" name="active" type="checkbox" value="1" @checked(old('active', true))/><span class="slider"></span>
</label>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 meta-box">
<div class="row d-block clearfix">
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces">
<x-resource-timestamps />
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn trans-btn w-100 text-start delete" data-post-type="discount"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
</div>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
@endpush

