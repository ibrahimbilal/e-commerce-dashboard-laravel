@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/apexcharts.css') }}" rel="stylesheet"/>
@endpush

@section('content')
@php
    $stats = $stats ?? [];
    $salesChartSeries = $salesChartSeries ?? ['labels' => [], 'sales' => [], 'orders' => []];
    $orderStatusStats = collect($orderStatusStats ?? []);
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
    $formatChangePercent = static function ($change): ?string {
        if ($change === null || ! is_numeric($change)) {
            return null;
        }

        return number_format(abs((float) $change), 1, '.', '').'%';
    };
    $kpiCards = [
        [
            'value' => data_get($stats, 'customers', 0),
            'label' => 'Customers',
            'icon' => 'fi-rr-users',
            'color' => 'mauve',
            'change' => data_get($stats, 'customers_change'),
        ],
        [
            'value' => data_get($stats, 'orders', 0),
            'label' => 'Orders',
            'icon' => 'fi-rr-box',
            'color' => 'green',
            'change' => data_get($stats, 'orders_change'),
        ],
        [
            'value' => data_get($stats, 'sales', data_get($stats, 'revenue', 0)),
            'label' => 'Sales',
            'icon' => 'fi-rr-dollar',
            'color' => 'red',
            'change' => data_get($stats, 'sales_change'),
        ],
        [
            'value' => data_get($stats, 'subscribers', 0),
            'label' => 'Subscribers',
            'icon' => 'fi-rr-paper-plane',
            'color' => 'orange',
            'change' => data_get($stats, 'subscribers_change'),
        ],
    ];
    $statusClass = static function (?string $slug): string {
        return match ($slug) {
            'pending' => 'warning',
            'canceled', 'cancelled' => 'danger',
            'completed', 'delivered', 'moving' => 'success',
            default => '',
        };
    };
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
@foreach ($kpiCards as $card)
@php
    $changeValue = $card['change'] ?? null;
    $changeLabel = $formatChangePercent($changeValue);
    $changePositive = $changeValue !== null && is_numeric($changeValue) && (float) $changeValue >= 0;
@endphp
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="{{ $card['color'] }}"><i class="{{ $card['icon'] }}"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ $formatDashboardStat($card['value']) }}</p>
<p class="text-start m-0">{{ $card['label'] }}</p>
</div>
@if ($changeLabel !== null)
<div class="percent {{ $changePositive ? 'good' : 'bad' }}">{{ ($changePositive ? '' : '-').$changeLabel }}<i class="fi-sr-arrow-small-{{ $changePositive ? 'up' : 'down' }}"> </i>
</div>
@endif
</div>
@endforeach
</div>
</div>
</div>
<div class="row">
<div class="col-12 col-xxl-8">
<div class="main-box box-spaces">
<div id="chart"></div>
</div>
</div>
<div class="col-12 col-sm-6 col-xxl-4">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize">Top Selling Products</h2>
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
<div class="col-12 col-sm-6 col-xxl-4">
<div class="main-box box-spaces">
<div class="box-header d-flex align-items-center justify-content-between flex-row-reverse">
<h2 class="box-title text-capitalize mb-0">Visitors Referrals</h2>
</div>
<div class="list-holder">
<p class="text-muted text-center py-4 mb-0">No visitor tracking yet.</p>
</div>
</div>
</div>
<div class="col-12 col-xxl-8">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize">Orders Statuses </h2>
<div class="table-holder">
<div class="table-responsive">
<table class="table table-striped mb-0">
<thead>
<tr>
<th class="text-uppercase">status</th>
<th class="text-uppercase text-end">orders</th>
<th class="text-uppercase text-end">share</th>
</tr>
</thead>
<tbody>
@forelse ($orderStatusStats as $statusRow)
@php
    $slug = data_get($statusRow, 'slug');
    $title = data_get($statusRow, 'title', '—');
    $count = data_get($statusRow, 'count', 0);
    $percent = data_get($statusRow, 'percent');
@endphp
<tr>
<td class="status text-capitalize {{ $statusClass(is_string($slug) ? $slug : null) }}">{{ $title }}</td>
<td class="text-end">{{ is_numeric($count) ? number_format((int) $count) : '0' }}</td>
<td class="text-end">@if (is_numeric($percent)){{ number_format((float) $percent, 1) }}%@else—@endif</td>
</tr>
@empty
<tr><td colspan="3" class="text-center text-muted py-4">No order statuses yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/apexcharts.min.js') }}" type="text/javascript"></script>
<script>
window.__dashboardChartSeries = @json($salesChartSeries);
</script>
<script src="{{ asset('assets/js/charts.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}" type="text/javascript"></script>
@endpush
