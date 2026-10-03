@extends('admin.layout')

@section('title', 'E-Commerce Project')

@push('stylesheet')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">add order</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.orders.index') }}">orders</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.orders.store') }}" class="row clearfix" data-post-type="order" id="add-newitem-form" method="POST">
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
@include('components.order-items-table')
</div>
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box order-sm-2">
<div class="main-box box-spaces mb-0">
@php
    $authUser = auth()->user();
    $authLabel = $authUser ? (trim(($authUser->first_name ?? '').' '.($authUser->last_name ?? '')) ?: $authUser->email) : '—';
@endphp
<div class="form-item second justify-content-between d-flex align-items-sm-center">
<label class="item-title meta-title">Created At:</label><span class="text-end ms-2">—</span>
</div>
<div class="form-item second justify-content-between mt-3 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="text-end ms-2">—</span>
</div>
<div class="form-item second justify-content-between mt-3 d-flex align-items-sm-center">
<label class="item-title meta-title">updated By:</label><span class="text-end ms-2">{{ $authLabel }}</span>
</div>
<div class="btns-holder d-flex justify-content-end mt-4">
<button class="btn solid-btn" type="submit">publish </button>
</div>
</div>
</div>
@include('components.order-customer-address-script')
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush

