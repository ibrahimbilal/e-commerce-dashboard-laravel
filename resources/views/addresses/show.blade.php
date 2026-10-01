@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
@php
    $cust = $address->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '—';
@endphp
<div class="page-header">
<h1 class="page-title text-capitalize">address details</h1>
<a class="btn regular-btn" href="{{ route('addresses.edit', $address) }}">edit</a>
</div>
<div class="main-box box-spaces col-lg-8">
<table class="table">
<tbody>
<tr><td>Customer</td><td>{{ $custLabel }}</td></tr>
<tr><td>Title</td><td>{{ $address->address_title ?? '—' }}</td></tr>
<tr><td>Mobile</td><td>{{ $address->mobile ?? '—' }}</td></tr>
<tr><td>Country</td><td>{{ $address->country ?? '—' }}</td></tr>
<tr><td>State</td><td>{{ $address->state ?? '—' }}</td></tr>
<tr><td>City</td><td>{{ $address->city ?? '—' }}</td></tr>
<tr><td>Address 1</td><td>{{ $address->address_1 ?? '—' }}</td></tr>
<tr><td>Address 2</td><td>{{ $address->address_2 ?? '—' }}</td></tr>
<tr><td>Postcode</td><td>{{ $address->postcode ?? '—' }}</td></tr>
</tbody>
</table>
</div>
@endsection
