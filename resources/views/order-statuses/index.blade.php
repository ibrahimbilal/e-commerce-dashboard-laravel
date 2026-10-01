@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">order statuses</h1>@can('add orders')
<a class="add-btn btn text-capitalize" href="{{ route('order-statuses.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('orders.index') }}">orders</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">statuses</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :counts="$counts ?? []" :filters="$filters ?? []" route="order-statuses.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="order-statuses">
<thead>
<tr>
<th class="text-uppercase">title</th>
<th class="text-uppercase">orders</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($orderStatuses as $orderStatus)
<tr>
<td class="prod-title">{{ $orderStatus->title }}</td>
<td class="text-center">{{ $orderStatus->orders_count ?? 0 }}</td>
<td>
<x-resource-actions :model="$orderStatus" resource="order-statuses" destroy-label="order status" :show="false" />
</td>
</tr>
@empty
<tr><td colspan="3" class="text-center text-muted py-4">No order statuses found.</td></tr>
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
