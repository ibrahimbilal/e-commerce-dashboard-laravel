@extends('admin.layout')

@section('title', 'E-Commerce Project')

@section('content')
<x-flash-messages />
@php
    $customerName = trim(($review->customer->first_name ?? '').' '.($review->customer->last_name ?? '')) ?: '—';
    $productName = $review->product?->locales->first()?->name ?? '—';
@endphp
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view review</h1>
<a class="add-btn btn text-capitalize" href="{{ route('admin.reviews.edit', $review) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.reviews.index') }}">reviews</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 col-lg-8">
<div class="main-box box-spaces">
<table class="table">
<tbody>
<tr><td>Customer</td><td>{{ $customerName }}</td></tr>
<tr><td>Product</td><td>{{ $productName }}</td></tr>
<tr><td>Rating</td><td>{{ $review->rate }}/5</td></tr>
<tr><td>Comment</td><td>{{ $review->comment }}</td></tr>
<tr><td>Created</td><td>{{ $review->created_at?->format('d/m/Y H:i') ?? '—' }}</td></tr>
</tbody>
</table>
</div>
</div>
</div>
@endsection
