@extends('layouts.app')

@section('title', 'Marketing')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">marketing</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"></i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"></i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">marketing</span>
</div>
</div>
</div>
</div>
</div>

@php
    $marketingFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Subscribers', 'key' => 'subscribers', 'params' => ['subscribers' => '1']],
        ['label' => 'Not subscribers', 'key' => 'not_subscribers', 'params' => ['subscribers' => '0']],
    ];
@endphp
<div class="row">
<x-index-list-toolbar :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$marketingFilterTabs" route="marketing.index"/>
<div class="col-12">
<div class="main-box box-spaces">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th class="text-uppercase">name</th>
<th class="text-uppercase">email</th>
<th class="text-uppercase">country</th>
<th class="text-uppercase">created date</th>
</tr>
</thead>
<tbody>
@forelse ($subscribers ?? [] as $subscriber)
<tr>
<td class="text-capitalize">{{ trim(($subscriber->first_name ?? '').' '.($subscriber->last_name ?? '')) ?: '—' }}</td>
<td class="text-uppercase">{{ $subscriber->email ?? '—' }}</td>
<td class="text-capitalize">{{ $subscriber->country ?? '—' }}</td>
<td>{{ $subscriber->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-muted py-4">No subscribers yet. Backend should pass a paginated <code>$subscribers</code> collection with optional <code>$counts</code> and <code>$filters</code>.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
