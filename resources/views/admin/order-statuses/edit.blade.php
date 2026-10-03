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
<h1 class="page-title">edit order status</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.order-statuses.index') }}">order statuses</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.order-statuses.update', $orderStatus) }}" class="row clearfix" id="add-newitem-form" method="POST">
@csrf
@method('PUT')
<div class="col-sm-12 col-lg-8 post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">status title</h2>
<input class="form-control" id="order-status-title" name="title" type="text" value="{{ old('title', $orderStatus->title) }}" maxlength="100" required/>
</div>
<div class="btns-holder d-flex justify-content-between mt-4 gap-2 flex-wrap">
<button type="button" class="btn trans-btn" data-confirm-delete="soft" form="order-status-destroy-form" data-confirm-label="order status"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>delete</button>
<button class="btn solid-btn" type="submit">update </button>
</div>
</div>
</div>
</form>
<form method="POST" action="{{ route('admin.order-statuses.destroy', $orderStatus) }}" id="order-status-destroy-form" class="destroy-resource-form d-none" data-confirm-delete="soft">@csrf @method('DELETE')</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
@endpush
