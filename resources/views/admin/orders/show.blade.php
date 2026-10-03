@extends('admin.layout')

@section('title', 'E-Commerce Project')

@section('content')
<x-flash-messages />
@php
    $customer = $order->customer;
    $customerName = $customer ? trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')) : '—';
    $address = $order->address;
    $statusTitle = $order->orderStatus?->title ?? '—';
    $couponTitle = $order->coupon?->title;
@endphp
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view order</h1><a class="add-btn btn text-capitalize" href="{{ route('admin.orders.edit', $order) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit <span class="page">order<span></span></span></a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.orders.index') }}">orders</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">order Details:</h2>
<div class="row">
<div class="col-sm-6">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table">
<tbody>
<tr>
<td>Order ID:</td>
<td>#{{ $order->id }}</td>
</tr>
<tr>
<td>Order Date:</td>
<td>{{ $order->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
</tr>
<tr>
<td>Order Status:</td>
<td class="status success">{{ $statusTitle }}</td>
</tr>
<tr>
<td>Amount:</td>
<td>${{ number_format($order->amount ?? 0) }}</td>
</tr>
<tr>
<td>Coupon:</td>
<td>{{ $couponTitle ?? '—' }}</td>
</tr>
<tr>
<td>Payment Method:</td>
<td class="text-muted">— (not on Order model)</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table">
<tbody>
<tr>
<td>Customer Name:</td>
<td>{{ $customerName }}</td>
</tr>
<tr>
<td>Email Address:</td>
<td>{{ $customer->email ?? '—' }}</td>
</tr>
<tr>
<td>Mobile:</td>
<td>{{ $customer->mobile ?? '—' }}</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">order Addresses:</h2>
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table w-100">
<thead>
<th></th>
<th>Billing to:</th>
<th>Shipping to:</th>
</thead>
<tbody>
<tr>
<td>
<p class="title title-2 mb-0">Full Name:</p>
</td>
<td>{{ $customerName }}</td>
<td>{{ $customerName }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Address:</p>
</td>
<td>{{ $address->address_1 ?? '—' }}</td>
<td>{{ $address->address_1 ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">City:</p>
</td>
<td>{{ $address->city ?? '—' }}</td>
<td>{{ $address->city ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Country:</p>
</td>
<td>{{ $address->country ?? '—' }}</td>
<td>{{ $address->country ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Postal:</p>
</td>
<td>{{ $address->postcode ?? '—' }}</td>
<td>{{ $address->postcode ?? '—' }}</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Mobile:</p>
</td>
<td>{{ $address->mobile ?? '—' }}</td>
<td>{{ $address->mobile ?? '—' }}</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize mb-3">order Items:</h2>
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th class="text-uppercase">image</th>
<th class="text-uppercase">product name</th>
<th class="text-uppercase">price</th>
<th class="text-uppercase">quantity</th>
<th class="text-uppercase">total</th>
</tr>
</thead>
<tbody>
@forelse ($order->items as $item)
@php
    $prod = $item->productAttribute?->product;
    $prodName = $prod?->locales?->first()?->name ?? ('Item #'.$item->id);
@endphp
<tr>
<td class="prod-img">
<div class="img-holder"><img src="{{ $prod?->product_img ? asset($prod->product_img) : asset('assets/images/product-placeholder.svg') }}" width="40" alt=""/></div>
</td>
<td class="text-capitalize">{{ $prodName }}</td>
<td class="text-capitalize">{{ $item->price ?? '—' }}</td>
<td class="text-capitalize">{{ $item->quantity ?? '—' }}</td>
<td class="text-capitalize">{{ isset($item->price, $item->quantity) ? ($item->price * $item->quantity) : '—' }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No line items on this order.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
<div class="order-footer d-flex flex-column flex-sm-row justify-content-between mt-3">
<div class="total-holder">
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">subtotal:</div><span class="ms-2">799$</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">tax:</div><span class="ms-2">100$</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">Shipping Costs:</div><span class="ms-2">159.8$</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">Order Total Costs:</div><span class="ms-2">${{ number_format($order->amount ?? 0) }}</span>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
@endpush

