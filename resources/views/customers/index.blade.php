@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">customers</h1>@can('add customers')
<a class="add-btn btn text-capitalize" href="{{ route('customers.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">customers</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :counts="$counts ?? []" :filters="$filters ?? []" route="customers.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="customers">
<thead>
<tr>
<th></th>
<th class="text-uppercase">image</th>
<th class="text-uppercase">customer name</th>
<th class="text-uppercase">email</th>
<th class="text-uppercase">mobile</th>
<th class="text-uppercase">registered date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($customers as $customer)
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ $customer->profile_picture ? asset($customer->profile_picture) : asset('assets/images/avatar-placeholder.svg') }}" width="70" alt=""/></div>
</td>
<td class="prod-title">{{ trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: '—' }}</td>
<td>{{ $customer->email }}</td>
<td>{{ $customer->mobile ?? '—' }}</td>
<td>{{ $customer->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<x-resource-actions :model="$customer" resource="customers" destroy-label="customer" />
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No customers found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection


