@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/apexcharts.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
<style>
.dashboard-top-selling .list-item .img {
	max-width: 60px;
	flex: 0 0 60px;
}
</style>
@endpush

@section('content')
@php
    $stats = $stats ?? [];
    $salesChartSeries = $salesChartSeries ?? ['labels' => [], 'sales' => [], 'orders' => []];
    $topProducts = collect($topProducts ?? []);
    $recentOrders = collect($recentOrders ?? []);
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
    $kpiCards = [
        ['value' => data_get($stats, 'customers', 0), 'label' => 'Customers', 'icon' => 'fi-rr-users', 'color' => 'mauve', 'format' => 'compact', 'change' => data_get($stats, 'customers_change'), 'icon_suffix' => ' '],
        ['value' => data_get($stats, 'orders', 0), 'label' => 'Orders', 'icon' => 'fi-rr-box', 'color' => 'green', 'format' => 'compact', 'change' => data_get($stats, 'orders_change'), 'icon_suffix' => ' '],
        ['value' => data_get($stats, 'sales', data_get($stats, 'revenue', 0)), 'label' => 'Sales', 'icon' => 'fi-rr-dollar', 'color' => 'red', 'format' => 'compact', 'change' => data_get($stats, 'sales_change'), 'icon_suffix' => ' '],
        ['value' => data_get($stats, 'revenue', 0), 'label' => 'Revenue', 'icon' => 'fi-rr-dollar', 'color' => 'orange', 'format' => 'number', 'change' => null, 'icon_suffix' => ''],
        ['value' => data_get($stats, 'products', 0), 'label' => 'Products', 'icon' => 'fi-rr-shopping-bag', 'color' => 'mauve', 'format' => 'number', 'change' => null, 'label_class' => 'mb-0', 'icon_suffix' => ''],
        ['value' => data_get($stats, 'subscribers', 0), 'label' => 'Subscribers', 'icon' => 'fi-rr-paper-plane', 'color' => 'green', 'format' => 'compact', 'change' => data_get($stats, 'subscribers_change'), 'icon_suffix' => ' '],
    ];
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
    $displayValue = ($card['format'] ?? 'compact') === 'number'
        ? number_format(is_numeric($card['value']) ? (float) $card['value'] : 0)
        : $formatDashboardStat($card['value']);
    $labelClass = trim('text-start m-0 '.($card['label_class'] ?? ''));
    $iconSuffix = $card['icon_suffix'] ?? ' ';
@endphp
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="{{ $card['color'] }}"><i class="{{ $card['icon'] }}">{{ $iconSuffix }}</i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ $displayValue }}</p>
<p class="{{ $labelClass }}">{{ $card['label'] }}</p>
</div>
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
<div class="list-holder dashboard-top-selling">
@foreach ($topProducts->take(4) as $productRow)
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
@endforeach
@if ($topProducts->isEmpty())
<p class="text-muted mb-0 py-3">No sales data yet.</p>
@endif
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-xxl-4">
<div class="main-box box-spaces">
<div class="box-header d-flex align-items-center justify-content-between">
<h2 class="box-title text-capitalize mb-0 text-start">Visitors Referrals</h2>
</div>
<div class="list-holder">
<p class="text-muted text-center py-4 mb-0">No visitor tracking yet.</p>
</div>
</div>
</div>
<div class="col-12 col-xxl-8">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize">Orders Statuses </h2>
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped mb-0" id="dashboard-recent-orders">
<thead>
<tr>
<th class="text-uppercase">Order</th>
<th class="text-uppercase">Status</th>
<th class="text-uppercase">Customer</th>
<th class="text-uppercase text-end">Amount</th>
<th class="text-uppercase">Date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@foreach ($recentOrders as $order)
@php
    $customerName = trim(($order->customer->first_name ?? '').' '.($order->customer->last_name ?? '')) ?: '—';
@endphp
<tr>
<td class="text-uppercase">#{{ $order->id }}</td>
<x-order-status :status="$order->orderStatus" />
<td class="text-capitalize">{{ $customerName }}</td>
<td class="text-end">${{ number_format($order->amount ?? 0) }}</td>
<td>{{ $order->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
@if (Route::has('orders.show') && auth()->user()?->can('view orders'))
<a class="btn btn-primary btn-rounded py-1" href="{{ route('orders.show', $order) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a>
@endif
</td>
</tr>
@endforeach
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
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#dashboard-recent-orders').length && ! $.fn.dataTable.isDataTable('#dashboard-recent-orders')) {
      $('#dashboard-recent-orders').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			bSortable: false,
      			bSearchable: false,
      			aTargets: [5]
      		}
      	],
      	order: [
      		[4, 'desc']
      	],
      	language: {
      		emptyTable: 'No recent orders.',
      		info: 'Show _START_ To _END_ Of _TOTAL_ orders',
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[5, 10, 15, 25], ['5 orders', '10 orders', '15 orders', '25 orders']],
      	buttons: ($(window).width() > 578) ? ['pageLength', 'colvis'] : ['pageLength']
      });
}
</script>
@endpush
