@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
@php
    $stats = $stats ?? [];
    $recentOrders = collect($recentOrders ?? []);
    $topProducts = collect($topProducts ?? []);
    $productPlaceholder = asset('assets/images/product-placeholder.svg');
    $formatDashboardStat = static function ($value): string {
        if (! is_numeric($value)) {
            return '0';
        }
        $number = (float) $value;
        if ($number < 10000) {
            return (string) (int) round($number);
        }
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1, '.', '').'M';
        }

        return number_format($number / 1000, 1, '.', '').'K';
    };
    $customersStat = data_get($stats, 'customers', 0);
    $ordersStat = data_get($stats, 'orders', 0);
    $salesStat = data_get($stats, 'revenue', 0);
    $subscribersStat = data_get($stats, 'subscribers', 0);
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

<div class="slider-holder">

<div class="swiper-container">
<div class="swiper-wrapper">
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="mauve"><i class="fi-rr-users"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ $formatDashboardStat($customersStat) }}</p>
<p class="text-start m-0">Customers</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="green"><i class="fi-rr-box"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ $formatDashboardStat($ordersStat) }}</p>
<p class="text-start m-0">Orders</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="red"><i class="fi-rr-dollar"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ $formatDashboardStat($salesStat) }}</p>
<p class="text-start m-0">Sales</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="orange"><i class="fi-rr-dollar"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['revenue'] ?? 0) }}</p>
<p class="text-start m-0">Revenue</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="mauve"><i class="fi-rr-shopping-bag"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['products'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Products</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="green"><i class="fi-rr-paper-plane"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ $formatDashboardStat($subscribersStat) }}</p>
<p class="text-start m-0">Subscribers</p>
</div>
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
    $productId = data_get($productRow, 'product_id') ?? data_get($productRow, 'id');
    $productName = (string) data_get($productRow, 'name', '—');
    $imageUrl = data_get($productRow, 'image_url');
    $imageSrc = filled($imageUrl) ? $imageUrl : $productPlaceholder;
    $price = data_get($productRow, 'price');
@endphp
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="{{ $productName }}" src="{{ $imageSrc }}"/></div>
@if ($productId && Route::has('products.edit'))
@can('edit products')
<a class="title text-start w-100 ps-4 text-capitalize text-decoration-none" href="{{ route('products.edit', $productId) }}">{{ $productName }}</a>
@else
<div class="title text-start w-100 ps-4 text-capitalize">{{ $productName }}</div>
@endcan
@else
<div class="title text-start w-100 ps-4 text-capitalize">{{ $productName }}</div>
@endif
<div class="price">
@if (is_numeric($price))
${{ number_format((float) $price) }}
@else
—
@endif
</div>
</div>
@empty
<p class="text-muted mb-0 py-3">No sales data yet.</p>
@endforelse
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}" type="text/javascript"></script>
<script>
if (document.querySelectorAll('.swiper-container').length > 0 && typeof Swiper !== 'undefined') {
	var swiper = new Swiper('.swiper-container', {
		freeMode: true,
		slidesPerView: 'auto',
		pagination: false,
		speed: 500,
		grabCursor: true,
		touchStartTime: 5000,
	});
}
</script>
@endpush
