@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/apexcharts.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">Analytics</h1>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">analytics</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center flex-column flex-sm-row mb-2">

<div class="filter-wrapper"><span class="filter-title">Date Rang:</span>
<div class="inputs-wrapper">
<form id="filter-analytics-data">
<div class="filter-item">
<label>From</label>
<select name="filter-date">
<option value="today">Today </option>
<option value="week">Week to Day </option>
<option value="month">Monthe To Day </option>
<option value="quarter">Quarter To Day</option>
<option value="year">Year To Day</option>
<option value="yesterday">Yesterday</option>
<option value="last-week">Last Week</option>
<option value="last-month">Last Monthe</option>
<option value="last-quarter">Last Quarter</option>
<option value="last-year">Last Year</option>
</select>
</div>
<div class="filter-item">
<label>Compare To</label>
<select name="filter-compare">
<option value="pre-year">Previous Year</option>
<option value="pre-period">Previous Period</option>
</select>
</div>
<button class="btn solid-btn generate-password" type="submit">Filter</button>
</form>
</div>
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
<table class="table table-striped" id="invoices">
<thead>
<tr>
<th class="text-uppercase">image</th>
<th class="text-uppercase">title</th>
<th class="text-uppercase">items sold</th>
<th class="text-uppercase">net sales</th>
</tr>
</thead>
<tbody>
<tr>
<td><img alt="Category 1" src="{{ asset('assets/images/categories/image-1.png') }}"/></td>
<td class="item-title">Clothes</td>
<td>400</td>
<td>$159,600</td>
</tr>
<tr>
<td><img alt="Category 2" src="{{ asset('assets/images/categories/image-2.png') }}"/></td>
<td class="item-title">Home furniture</td>
<td>50</td>
<td>$19,950</td>
</tr>
<tr>
<td><img alt="Category 3" src="{{ asset('assets/images/categories/image-3.png') }}"/></td>
<td class="item-title">Cakes</td>
<td>10</td>
<td>$3,990</td>
</tr>
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
<table class="table table-striped" id="invoices">
<thead>
<tr>
<th class="text-uppercase">image</th>
<th class="text-uppercase">title</th>
<th class="text-uppercase">items sold</th>
<th class="text-uppercase">net sales</th>
</tr>
</thead>
<tbody>
<tr>
<td><img alt="product 1" src="{{ asset('assets/images/products/image-1.png') }}"/></td>
<td class="item-title">Apple Watch Series 4 GPS</td>
<td>400</td>
<td>$159,600</td>
</tr>
<tr>
<td><img alt="product 1" src="{{ asset('assets/images/products/image-2.png') }}"/></td>
<td class="item-title">Beats Headphones</td>
<td>50</td>
<td>$19,950</td>
</tr>
<tr>
<td><img alt="product 1" src="{{ asset('assets/images/products/image-3.png') }}"/></td>
<td class="item-title">Apple iPad Pro 64GB</td>
<td>10</td>
<td>$3,990</td>
</tr>
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
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/apexcharts.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/charts.js') }}" type="text/javascript"></script>
@endpush

