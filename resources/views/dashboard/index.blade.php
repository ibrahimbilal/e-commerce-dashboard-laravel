@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
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
<div class="col-12 col-md-4">
<div class="main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="mauve"><i class="fi-rr-shopping-bag"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['products'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Products</p>
</div>
</div>
</div>
<div class="col-12 col-md-4">
<div class="main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="green"><i class="fi-rr-box"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['orders'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Orders</p>
</div>
</div>
</div>
<div class="col-12 col-md-4">
<div class="main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="red"><i class="fi-rr-users"></i></span></div>
<div class="detail-holder">
<p class="text-start m-0">{{ number_format($stats['customers'] ?? 0) }}</p>
<p class="text-start m-0 mb-0">Customers</p>
</div>
</div>
</div>
</div>

<div class="row mt-3">
<div class="col-12">
<div class="main-box box-spaces">
<p class="text-muted mb-0">Sales charts, top products, referral stats, and recent orders will appear here once the dashboard API provides <code>$salesSummary</code>, <code>$topProducts</code>, <code>$referralStats</code>, and <code>$recentOrders</code>.</p>
</div>
</div>
</div>
@endsection
