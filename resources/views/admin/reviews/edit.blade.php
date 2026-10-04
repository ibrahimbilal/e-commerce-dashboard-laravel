@extends('admin.layout')

@section('title', 'E-Commerce Project')

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">edit review</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.reviews.index') }}">reviews</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.reviews.update', $review) }}" class="row clearfix" method="POST" data-ajax-form>
@csrf
@method('PUT')
<div class="col-sm-12 col-lg-8 post-box">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Review</h2>
</div>
@include('components.review-form-fields', ['review' => $review])
<div class="btns-holder d-flex justify-content-end mt-4">
<button class="btn solid-btn" type="submit">update</button>
</div>
</div>
</div>
</form>
@include('components.ajax-form-assets')
@endsection