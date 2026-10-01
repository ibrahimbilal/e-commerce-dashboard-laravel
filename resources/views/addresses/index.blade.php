@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<h1 class="page-title text-capitalize">addresses</h1>
<a class="add-btn btn text-capitalize" href="{{ route('addresses.create') }}"><span class="icon"><i class="fi-rr-plus"> </i></span>add</a>
</div>
</div>
</div>
<div class="row">
<x-index-list-toolbar :counts="$counts ?? []" :filters="$filters ?? []" :tabs="[['label' => 'All', 'key' => 'all', 'params' => []]]" route="addresses.index"/>
<div class="col-12">
<div class="main-box box-spaces">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th class="text-uppercase">customer</th>
<th class="text-uppercase">title</th>
<th class="text-uppercase">city</th>
<th class="text-uppercase">country</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($addresses as $address)
@php
    $cust = $address->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '—';
@endphp
<tr>
<td>{{ $custLabel ?: '—' }}</td>
<td>{{ $address->address_title ?? '—' }}</td>
<td>{{ $address->city ?? '—' }}</td>
<td>{{ $address->country ?? '—' }}</td>
<td>
<a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('addresses.show', $address) }}">view</a>
<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('addresses.edit', $address) }}">edit</a>
<form method="POST" action="{{ route('addresses.destroy', $address) }}" class="d-inline destroy-resource-form">@csrf @method('DELETE')
<button type="button" class="btn btn-danger btn-rounded py-1 js-destroy-submit" data-confirm-label="address">trash</button></form>
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No addresses found.</td></tr>
@endforelse
</tbody>
</table>
</div>
<x-pagination :paginator="$addresses" />
</div>
</div>
</div>
@endsection
