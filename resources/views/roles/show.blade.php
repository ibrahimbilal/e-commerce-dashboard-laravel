@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view role</h1>
<a class="add-btn btn text-capitalize" href="{{ route('roles.edit', $role) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('roles.index') }}">roles</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 col-lg-8">
<div class="main-box box-spaces mb-3">
<p class="mb-1"><strong>Name:</strong> {{ $role->name }}</p>
<p class="mb-0"><strong>Assigned permissions:</strong> {{ $role->permissions->count() }}</p>
</div>
<div class="main-box box-spaces">
<h2 class="box-title item-title mb-3">Permissions (read-only)</h2>
@php
    $roleReadOnly = $role;
    $permissionsReadOnly = true;
@endphp
<form class="item-form" onsubmit="return false;">
@include('components.spatie-role-permissions-matrix', ['permissions' => $permissions, 'role' => $role])
</form>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.spatie-permissions-matrix input[type="checkbox"]').forEach(function (el) {
    el.disabled = true;
});
document.querySelectorAll('.js-spatie-select-row, .js-spatie-select-col, #role-perms-select-all').forEach(function (el) {
    if (el) { el.style.display = 'none'; }
});
</script>
@endpush
