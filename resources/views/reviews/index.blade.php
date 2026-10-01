@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">Reviews</h1>
@can('add reviews')
<a class="add-btn btn text-capitalize" href="{{ route('reviews.create') }}"><span class="icon"><i class="fi-rr-plus"> </i></span>add review</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">reviews</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :counts="$counts ?? []" :filters="$filters ?? []" route="reviews.index"/>
<div class="col-12">
<div class="main-box box-spaces">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="reviews">
<thead>
<tr>
<th></th>
<th class="text-uppercase">customer name</th>
<th class="text-uppercase">rate stars</th>
<th class="text-uppercase">comment</th>
<th class="text-uppercase">product</th>
<th class="text-uppercase">created date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($reviews as $review)
@php
    $customerName = trim(($review->customer->first_name ?? '') . ' ' . ($review->customer->last_name ?? '')) ?: '—';
    $productName = $review->product?->locales->first()?->name ?? '—';
@endphp
<tr>
<td></td>
<td class="text-capitalize">{{ $customerName }}</td>
<td class="stars-wrapper">
<div class="main-stars">@for ($i = 1; $i <= 5; $i++)<span class="star"><i class="fi-rr-star"> </i></span>@endfor</div>
<div class="cust-stars">@for ($i = 1; $i <= ($review->rate ?? 0); $i++)<span class="star"><i class="fi-sr-star"> </i></span>@endfor</div>
</td>
<td class="text-capitalize comment">{{ \Illuminate\Support\Str::limit($review->comment ?? '—', 80) }}</td>
<td class="text-capitalize">{{ $productName }}</td>
<td class="text-uppercase">{{ $review->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<div class="btn-group">
<a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('reviews.show', $review) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a>
<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('reviews.edit', $review) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a>
<form method="POST" action="{{ route('reviews.destroy', $review) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="review"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form>
</div>
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No reviews found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection


