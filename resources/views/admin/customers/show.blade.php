@extends('admin.layout')

@section('title', 'View customer')

@section('content')
<x-flash-messages />
@php
    $customerName = trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')) ?: '—';
@endphp
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view customer</h1>
@if (Route::has('customers.edit'))
@can('edit customers')
<a class="add-btn btn text-capitalize" href="{{ route('admin.customers.edit', $customer) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit <span class="page">customer<span></span></span></a>
@endcan
@endif
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.customers.index') }}">customers</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<div class="row">
<div class="col-sm-12 col-lg-3 d-flex justify-content-center user-holder">
<div class="profile-image text-center"><img src="{{ $customer->profile_picture ? asset($customer->profile_picture) : asset('assets/images/avatar-placeholder.svg') }}" alt="{{ $customerName }}"/></div>
</div>
<div class="col-sm-12 col-lg-9">
<div class="profile-details row mt-3 mt-lg-0">
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>First Name:</b></div><span class="ms-2">{{ $customer->first_name ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Last Name:</b></div><span class="ms-2">{{ $customer->last_name ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Email Address:</b></div><span class="ms-2">{{ $customer->email ?? '—' }}</span>
</div>
<x-account-activity-meta :subject="$customer" />
</div>
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Birth Of Date:</b></div><span class="ms-2">{{ $customer->birth_date?->format('d/m/Y') ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Mobile:</b></div><span class="ms-2">{{ $customer->mobile ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Gender:</b></div><span class="ms-2 text-capitalize">{{ $customer->gender ?? '—' }}</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-12 col-lg-5">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">Addresses </h2>
<div class="repeater-holder">
@forelse ($customer->addresses as $address)
<div class="repeater mb-3">
<div class="repeater-title p-3 d-flex justify-content-between align-items-center">
<h3 class="h6 mb-0">{{ $address->address_title ?: 'Address #'.$address->id }}</h3>
<div class="icons d-flex align-items-center"><span class="icon active"><i class="fi-rr-angle-small-down"> </i></span></div>
</div>
<div class="repeater-inputs active">
<table class="table mb-0">
<tbody>
<tr><td class="text-capitalize">Country:</td><td class="text-capitalize">{{ $address->country ?? '—' }}</td></tr>
<tr><td class="text-capitalize">State:</td><td class="text-capitalize">{{ $address->state ?? '—' }}</td></tr>
<tr><td class="text-capitalize">City:</td><td class="text-capitalize">{{ $address->city ?? '—' }}</td></tr>
<tr><td class="text-capitalize">Address 1:</td><td class="text-capitalize">{{ $address->address_1 ?? '—' }}</td></tr>
<tr><td class="text-capitalize">Address 2:</td><td class="text-capitalize">{{ $address->address_2 ?? '—' }}</td></tr>
<tr><td class="text-capitalize">Postal Code:</td><td class="text-capitalize">{{ $address->postcode ?? '—' }}</td></tr>
<tr><td class="text-capitalize">Mobile:</td><td class="text-capitalize">{{ $address->mobile ?? '—' }}</td></tr>
</tbody>
</table>
</div>
</div>
@empty
<p class="text-muted mb-0">No addresses on file.</p>
@endforelse
</div>
</div>
</div>
<div class="col-12 col-lg-7">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize mb-3">Orders </h2>
<div class="table-holder">
<div class="table-responsive">
<table class="table table-striped mb-0">
<thead>
<tr>
<th class="text-uppercase">Order</th>
<th class="text-uppercase">status</th>
<th class="text-uppercase">Amount</th>
<th class="text-uppercase">Date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($customer->orders as $order)
<tr>
<td>#{{ $order->id }}</td>
<td class="status text-capitalize">{{ $order->orderStatus->title ?? '—' }}</td>
<td class="text-capitalize text-center">${{ number_format($order->amount ?? 0) }}</td>
<td>{{ $order->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
@if (Route::has('orders.show'))
@can('view orders')
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('admin.orders.show', $order) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
@endcan
@endif
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-4">No orders yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection
