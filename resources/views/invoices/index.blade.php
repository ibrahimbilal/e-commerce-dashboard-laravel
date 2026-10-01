@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex align-items-sm-center justify-content-between w-100">
<h1 class="page-title">invoices</h1>
@if (Route::has('invoices.create'))
@can('add invoices')
<a class="add-btn btn text-capitalize" href="{{ route('invoices.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
@endif
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">invoices</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :counts="$counts ?? []" :filters="$filters ?? []" route="invoices.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="invoices">
<thead>
<tr>
<th></th>
<th class="text-uppercase">invoice no</th>
<th class="text-uppercase">customer</th>
<th class="text-uppercase">total Cost</th>
<th class="text-uppercase">created date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($invoices as $invoice)
@php
    $cust = $invoice->order?->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '—';
    $total = $invoice->order?->amount;
@endphp
<tr>
<td></td>
<td>#{{ $invoice->invoice_no }}</td>
<td class="prod-title">{{ $custLabel ?: '—' }}</td>
<td class="text-center">@if($total !== null)${{ number_format($total) }}@else—@endif</td>
<td>{{ $invoice->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('invoices.show', $invoice) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('invoices.edit', $invoice) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('invoices.destroy', $invoice) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="invoice"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-muted">No invoices found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection


