@extends('admin.layout')

@section('title', 'Analytics')

@push('stylesheet')
<link href="{{ asset('css/apexcharts.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
@php
    $range = $range ?? ['from' => now()->subDays(29)->toDateString(), 'to' => now()->toDateString(), 'compare' => 'previous_period'];
    $analytics = $analytics ?? [];
    $analyticsSeries = $analyticsSeries ?? ['labels' => [], 'sales' => [], 'orders' => [], 'items_sold' => [], 'tax' => []];
    $topCategories = collect($topCategories ?? []);
    $topProducts = collect($topProducts ?? []);
    $comparison = $analytics['comparison'] ?? null;
    $compareMode = $range['compare'] ?? 'previous_period';
    $compareHint = match ($compareMode) {
        'previous_year' => 'Previous year',
        'previous_period' => 'Previous period',
        default => null,
    };
    $formatMoney = static fn ($value): string => is_numeric($value) ? '$'.number_format((int) $value) : '—';
    $formatCount = static fn ($value): string => is_numeric($value) ? number_format((int) $value) : '—';
    $deltaPercent = static function ($current, $previous): ?string {
        if (! is_numeric($current) || ! is_numeric($previous) || (float) $previous === 0.0) {
            return null;
        }
        $change = round(((float) $current - (float) $previous) / (float) $previous * 100, 1);

        return ($change >= 0 ? '+' : '').number_format($change, 1).'%';
    };
    $metricCards = [
        ['key' => 'sales', 'label' => 'Total sales', 'format' => $formatMoney],
        ['key' => 'orders', 'label' => 'Orders', 'format' => $formatCount],
        ['key' => 'items_sold', 'label' => 'Items sold', 'format' => $formatCount],
        ['key' => 'tax', 'label' => 'Tax', 'format' => null],
    ];
@endphp
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">Analytics</h1>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">analytics</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center flex-column flex-sm-row mb-2">

<div class="filter-wrapper"><span class="filter-title">Date Rang:</span>
<div class="inputs-wrapper">
<form id="filter-analytics-data" method="GET" action="{{ route('admin.analytics.overview') }}">
<div class="filter-item">
<label for="analytics-from">From</label>
<input class="form-control" id="analytics-from" name="from" type="date" value="{{ $range['from'] ?? '' }}"/>
</div>
<div class="filter-item">
<label for="analytics-to">To</label>
<input class="form-control" id="analytics-to" name="to" type="date" value="{{ $range['to'] ?? '' }}"/>
</div>
<div class="filter-item">
<label for="analytics-compare">Compare To</label>
<select id="analytics-compare" name="compare">
<option value="previous_period" @selected(($range['compare'] ?? '') === 'previous_period')>Previous Period</option>
<option value="previous_year" @selected(($range['compare'] ?? '') === 'previous_year')>Previous Year</option>
<option value="none" @selected(($range['compare'] ?? '') === 'none')>None</option>
</select>
</div>
<button class="btn solid-btn generate-password" type="submit">Filter</button>
</form>
</div>
</div>
</div>

<div class="col-12 mb-3">
<div class="row g-3">
@foreach ($metricCards as $card)
@php
    $metricKey = $card['key'];
    $currentValue = data_get($analytics, $metricKey);
    $previousValue = is_array($comparison) ? data_get($comparison, $metricKey) : null;
    $delta = ($compareHint && is_array($comparison)) ? $deltaPercent($currentValue, $previousValue) : null;
@endphp
<div class="col-12 col-sm-6 col-xl-3">
<div class="main-box box-spaces h-100 mb-0">
<p class="text-capitalize mb-1 text-muted">{{ $card['label'] }}</p>
<p class="h4 mb-1">
@if ($metricKey === 'tax' && $currentValue === null)
Not tracked
@elseif ($card['format'])
{{ $card['format']($currentValue ?? 0) }}
@else
—
@endif
</p>
@if ($delta !== null)
<p class="mb-0 small text-muted">{{ $compareHint }}: {{ $delta }}</p>
@elseif ($compareHint && is_array($comparison) && $metricKey !== 'tax')
<p class="mb-0 small text-muted">{{ $compareHint }}: {{ $card['format']($previousValue ?? 0) }}</p>
@endif
</div>
</div>
@endforeach
</div>
</div>

<div class="col-12">
<section class="row">
<div class="col-12">
<div class="sec-title-wrapper">
<h2 class="h5">Charts</h2>
<hr/>
</div>
</div>
<div class="col-md-6">
<div class="main-box box-spaces">
<div id="total-sales-chart"></div>
</div>
</div>
<div class="col-md-6">
<div class="main-box box-spaces">
<div id="orders-overview-chart"></div>
</div>
</div>
<div class="col-md-6">
<div class="main-box box-spaces mb-lg-0">
<div id="items-sold-chart"></div>
</div>
</div>
<div class="col-md-6">
<div class="main-box box-spaces mb-lg-0">
<div id="total-tax-chart"></div>
</div>
</div>
</section>
</div>
<div class="col-12">
<section class="row">
<div class="col-12">
<div class="sec-title-wrapper">
<h2 class="h5">Leaderboards</h2>
<hr/>
</div>
</div>
<div class="col-md-6">
<div class="main-box box-spaces mb-lg-0">
<h2 class="box-title text-capitalize">Top Categories - Items Sold</h2>
<div class="table-holder analytics-table">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th class="text-uppercase">title</th>
<th class="text-uppercase text-end">items sold</th>
<th class="text-uppercase text-end">net sales</th>
</tr>
</thead>
<tbody>
@forelse ($topCategories as $row)
<tr>
<td class="item-title">{{ data_get($row, 'name', '—') }}</td>
<td class="text-end">{{ is_numeric(data_get($row, 'quantity_sold')) ? number_format((int) data_get($row, 'quantity_sold')) : '—' }}</td>
<td class="text-end">{{ is_numeric(data_get($row, 'revenue')) ? '$'.number_format((int) data_get($row, 'revenue')) : '—' }}</td>
</tr>
@empty
<tr><td colspan="3" class="text-center text-muted py-4">No category sales in this range.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="main-box box-spaces mb-lg-0">
<h2 class="box-title text-capitalize">Top Products - Items Sold</h2>
<div class="table-holder analytics-table">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th class="text-uppercase">title</th>
<th class="text-uppercase text-end">items sold</th>
<th class="text-uppercase text-end">net sales</th>
</tr>
</thead>
<tbody>
@forelse ($topProducts as $row)
<tr>
<td class="item-title">{{ data_get($row, 'name', '—') }}</td>
<td class="text-end">{{ is_numeric(data_get($row, 'quantity_sold')) ? number_format((int) data_get($row, 'quantity_sold')) : '—' }}</td>
<td class="text-end">{{ is_numeric(data_get($row, 'revenue')) ? '$'.number_format((int) data_get($row, 'revenue')) : '—' }}</td>
</tr>
@empty
<tr><td colspan="3" class="text-center text-muted py-4">No product sales in this range.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</section>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/apexcharts.min.js') }}" type="text/javascript"></script>
@php
    $analyticsChartPayload = [
        'labels' => $analyticsSeries['labels'] ?? [],
        'sales' => $analyticsSeries['sales'] ?? [],
        'orders' => $analyticsSeries['orders'] ?? [],
        'items_sold' => $analyticsSeries['items_sold'] ?? [],
        'tax' => $analyticsSeries['tax'] ?? [],
    ];
@endphp
<script>
window.__analyticsOverview = @json($analyticsChartPayload);
</script>
<script src="{{ asset('js/charts.js') }}" type="text/javascript"></script>
@endpush
