@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">users</h1>@can('add users')
<a class="add-btn btn text-capitalize" href="{{ route('users.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">users</span>
</div>
</div>
</div>
</div>
</div>
@php
    $userFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Trashed', 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
    foreach ($counts ?? [] as $roleKey => $number) {
        if (in_array($roleKey, ['all', 'trashed'], true)) {
            continue;
        }
        $userFilterTabs[] = [
            'label' => ucwords(str_replace(['_', '-'], ' ', (string) $roleKey)),
            'key' => $roleKey,
            'params' => ['role' => $roleKey],
        ];
    }
@endphp
<div class="row">
<x-index-list-toolbar :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$userFilterTabs" route="users.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="users">
<thead>
<tr>
<th></th>
<th class="text-uppercase">image</th>
<th class="text-uppercase">name</th>
<th class="text-uppercase">email</th>
<th class="text-uppercase">role</th>
<th class="text-uppercase">registered date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($users as $user)
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('assets/images/avatar-placeholder.svg') }}" width="70" alt=""/></div>
</td>
<td class="user-title">{{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: '—' }}</td>
<td>{{ $user->email }}</td>
<td>
@if ($user->getRoleNames()->isNotEmpty())
@foreach ($user->getRoleNames() as $roleName)
<span class="badge bg-secondary me-1 text-capitalize">{{ $roleName }}</span>
@endforeach
@else
—
@endif
</td>
<td>{{ $user->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<div class="btn-group">
<a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('users.show', $user) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a>
<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('users.edit', $user) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a>
<form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="user"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form>
</div>
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
@endforelse
</tbody>
<tfoot>
<tr>
<th></th>
<th class="text-uppercase">image</th>
<th class="text-uppercase">name</th>
<th class="text-uppercase">email</th>
<th class="text-uppercase">role</th>
<th class="text-uppercase">registered date</th>
<th class="text-uppercase">action</th>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection


