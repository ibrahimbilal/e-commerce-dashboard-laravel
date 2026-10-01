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
<h1 class="page-title">add order</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('orders.index') }}">orders</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('orders.store') }}" class="row clearfix" data-post-type="order" id="add-newitem-form" method="POST">
@csrf
<div class="col-sm-12 float-start post-box order-sm-1">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Order Details</h2>
</div>
@include('components.order-form-fields')
</div>
</div>
<div class="col-sm-12 float-start post-box order-sm-3">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Order Addresses</h2>
</div>
<p class="text-muted px-3 mb-3">Choose a saved customer address above. Inline address fields below are design-only (not saved by OrderController).</p>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3 px-3">
<label class="item-title">Preview:</label>
<span class="ms-2">Use the <strong>Shipping address</strong> dropdown in Order Details.</span>
</div>
</div>
</div>
<div class="col-sm-12 float-start post-box order-sm-4">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Order Items</h2>
</div>
<div class="repeater-holder">
<div class="repeater mb-3">
<div class="repeater-title p-3 mb-3 d-flex justify-content-between align-items-center">
<h3 class="h5 mb-0">Item Title</h3>
<div class="icons d-flex align-items-center"><span class="icon active"><i class="fi-rr-angle-small-down"> </i></span><span class="remove" flow="up" tooltip="Remove"><i class="fi-rr-trash"> </i></span></div>
</div>
<div class="repeater-inputs px-3 active">
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="product">Product:</label>
<select class="form-select" id="product">
<option>Select Product</option>
<option>Product 1</option>
<option>Product 2</option>
<option>Product 3</option>
<option>Product 4</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="product-color">Product Color:</label>
<select class="form-select" id="product-color">
<option>Select Product Color</option>
<option>Red</option>
<option>Green</option>
<option>Blue</option>
<option>Black</option>
<option>White</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="product-size">Product Size:</label>
<select class="form-select" id="product-size">
<option>Select Product Size</option>
<option>XS</option>
<option>S</option>
<option>M</option>
<option>L</option>
<option>XL</option>
<option>XXL</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="quantity">Quantity:</label>
<input class="form-control" id="quantity" type="text"/>
</div>
</div>
</div>
</div>
<div class="add-repeater-item"><a class="btn">Add New Item</a></div>
</div>
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box order-sm-2">
<div class="main-box box-spaces mb-0">
<div class="form-item second justify-content-between d-flex align-items-sm-center">
<label class="item-title meta-title">Created At:</label><span class="text-end ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-3 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="text-end ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-3 d-flex align-items-sm-center">
<label class="item-title meta-title">updated By:</label><span class="text-end ms-2">Jayson Hinrichsen</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn trans-btn w-100 text-start delete" data-post-type="order"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush

