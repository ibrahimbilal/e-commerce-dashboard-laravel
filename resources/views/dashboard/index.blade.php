@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $stats = $stats ?? [];
    $recentOrders = $recentOrders ?? collect();
    $topProducts = $topProducts ?? collect();
@endphp
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0">
<h1 class="page-title">dashboard</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center">
<a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"></i></span>dashboard</a>
</div>
</div>
</div>
</div>
</div>

<div class="row g-3">
<div class="col-6 col-lg">
<div class="main-box box-spaces d-flex justify-content-between align-items-center h-100">
<div class="icon-holder"><span class="green"><i class="fi-rr-box"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['orders'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Orders</p>
</div>
</div>
</div>
<div class="col-6 col-lg">
<div class="main-box box-spaces d-flex justify-content-between align-items-center h-100">
<div class="icon-holder"><span class="red"><i class="fi-rr-dollar"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">${{ number_format($stats['revenue'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Revenue</p>
</div>
</div>
</div>
<div class="col-6 col-lg">
<div class="main-box box-spaces d-flex justify-content-between align-items-center h-100">
<div class="icon-holder"><span class="mauve"><i class="fi-rr-users"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['customers'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Customers</p>
</div>
</div>
</div>
<div class="col-6 col-lg">
<div class="main-box box-spaces d-flex justify-content-between align-items-center h-100">
<div class="icon-holder"><span class="orange"><i class="fi-rr-shopping-bag"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['products'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Products</p>
</div>
</div>
</div>
<div class="col-6 col-lg">
<div class="main-box box-spaces d-flex justify-content-between align-items-center h-100">
<div class="icon-holder"><span class="green"><i class="fi-rr-calendar"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['orders_today'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Orders today</p>
</div>
</div>
</div>
</div>

<div class="row g-3 mt-1">
<div class="col-12 col-xxl-8">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize">Recent orders</h2>
<div class="table-responsive">
<table class="table table-striped mb-0">
<thead>
<tr>
<th class="text-uppercase">Order</th>
<th class="text-uppercase">Status</th>
<th class="text-uppercase">Customer</th>
<th class="text-uppercase text-end">Amount</th>
<th class="text-uppercase">Date</th>
</tr>
</thead>
<tbody>
@forelse ($recentOrders as $order)
@php
    $customerName = trim(($order->customer->first_name ?? '').' '.($order->customer->last_name ?? '')) ?: '—';
@endphp
<tr>
<td class="text-uppercase">
@if (Route::has('orders.show'))
<a href="{{ route('orders.show', $order) }}">#{{ $order->id }}</a>
@else
#{{ $order->id }}
@endif
</td>
<td class="text-capitalize">{{ $order->orderStatus->title ?? '—' }}</td>
<td class="text-capitalize">{{ $customerName }}</td>
<td class="text-end">${{ number_format($order->amount ?? 0) }}</td>
<td>{{ $order->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-4">No recent orders.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<div class="col-12 col-xxl-4">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize">Top selling products</h2>
<div class="list-holder">
@forelse ($topProducts as $productRow)
@php
    $productId = data_get($productRow, 'id') ?? data_get($productRow, 'product_id');
    $productName = data_get($productRow, 'name', '—');
    $quantitySold = data_get($productRow, 'quantity_sold')
        ?? data_get($productRow, 'units_sold')
        ?? data_get($productRow, 'sold')
        ?? 0;
@endphp
<div class="list-item d-flex align-items-center justify-content-between">
@if ($productId && Route::has('products.edit'))
<a class="title text-start w-100 text-capitalize text-decoration-none" href="{{ route('products.edit', $productId) }}">{{ $productName }}</a>
@else
<div class="title text-start w-100 text-capitalize">{{ $productName }}</div>
@endif
<div class="text-muted text-nowrap ms-2">{{ number_format($quantitySold) }} sold</div>
</div>
@empty
<p class="text-muted mb-0 py-3">No sales data yet.</p>
@endforelse
</div>
</div>
</div>
</div>
@endsection
