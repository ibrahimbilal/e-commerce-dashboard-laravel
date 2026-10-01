@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">coupons</h1>@can('add discounts')
<a class="add-btn btn text-capitalize" href="{{ route('coupons.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('discounts.index') }}">discounts</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">coupons</span>
</div>
</div>
</div>
</div>
</div>
@php
    $couponFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Active', 'key' => 'active', 'params' => ['active' => '1']],
        ['label' => 'Expired', 'key' => 'expired', 'params' => ['expired' => '1']],
        ['label' => 'Trashed', 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
@endphp
<div class="row">
<x-index-list-toolbar :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$couponFilterTabs" route="coupons.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="coupons">
<thead>
<tr>
<th class="text-uppercase">title</th>
<th class="text-uppercase">code</th>
<th class="text-uppercase">discount</th>
<th class="text-uppercase">usage limit</th>
<th class="text-uppercase">orders</th>
<th class="text-uppercase text-center">active</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($coupons as $coupon)
<tr>
<td class="prod-title">{{ $coupon->title }}</td>
<td><code>{{ $coupon->code }}</code></td>
<td class="text-capitalize">{{ $coupon->discount }}{{ ($coupon->type ?? 'percent') === 'percent' ? '%' : '' }}</td>
<td>{{ $coupon->usage_limit }} / customer {{ $coupon->usage_per_customer }}</td>
<td class="text-center">{{ $coupon->orders_count ?? 0 }}</td>
<td class="text-center">
<label class="switch">
<input class="switch" type="checkbox" disabled @checked($coupon->active)/><span class="slider"></span>
</label>
</td>
<td>
<x-resource-actions :model="$coupon" resource="coupons" destroy-label="coupon" :show="false" />
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No coupons found.</td></tr>
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
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
@endpush
