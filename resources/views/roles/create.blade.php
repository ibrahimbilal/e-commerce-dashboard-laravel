@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">add role</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('roles.index') }}">roles</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('roles.store') }}" class="item-form row" data-post-type="role" id="add-newitem-form" method="POST">
@csrf
<div class="col-sm-12">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">role name</h2>
<input class="form-control" id="role-name" name="name" type="text" value="{{ old('name') }}" required maxlength="255"/>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-8 mb-3">
<div class="main-box box-spaces mb-0">
<div class="d-flex justify-content-between align-items-center mb-3">
<div class="form-item primary">
<h2 class="box-title item-title mb-0">Permissions</h2>
</div>
<div class="select-all"><a class="btn btn-primary btn-rounded me-2 py-1 text-capitalize" href="javascript:void(0)" id="role-perms-select-all">select all</a></div>
</div>
@include('components.spatie-role-permissions-matrix', ['permissions' => $permissions])
</div>
</div>
<div class="col-sm-12 col-lg-4">
<div class="main-box box-spaces">
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn solid-btn" type="submit">publish </button>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush
