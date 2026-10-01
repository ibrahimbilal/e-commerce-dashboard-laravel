@extends('layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0">
<h1 class="page-title">Analytics</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"></i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"></i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">analytics</span>
</div>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<p class="text-muted mb-2">Analytics charts and tables will render here when the backend provides:</p>
<ul class="text-muted mb-0">
<li><code>$dateRange</code> and comparison filters</li>
<li><code>$salesChartSeries</code>, <code>$ordersChartSeries</code>, <code>$itemsSoldChartSeries</code></li>
<li><code>$topCategories</code> and <code>$topProducts</code> collections</li>
</ul>
</div>
</div>
</div>
@endsection
