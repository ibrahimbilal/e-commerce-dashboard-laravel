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
<h1 class="page-title">edit role</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('roles.index') }}">roles</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('roles.update', $role) }}" class="item-form row" data-post-type="role" id="add-newitem-form" method="POST">
@csrf
@method('PUT')
<div class="col-sm-12">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">role title</h2>
<input class="form-control" id="role-name" name="role_name" type="text" value="{{ old('role_name', $role->role_name ?? '') }}" />
</div>
</div>
</div>
<div class="col-sm-12 col-lg-8 mb-3">
<div class="main-box box-spaces mb-0">
<div class="d-flex justify-content-between align-items-center mb-3">
<div class="form-item primary">
<h2 class="box-title item-title mb-0">Permissions</h2>
</div>
<div class="select-all"><a class="btn btn-primary btn-rounded me-2 py-1 text-capitalize">select all</a></div>
</div>
<div class="tabs-holder">
<div class="tabs-boxs border-none">
<div class="tab-box active">
<div class="table-responsive">
<table class="table mb-0 border-0">
<tbody>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>Products</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>Attributes</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>reviews</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>Categories</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>Tags</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>discounts</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>Customers</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>orders</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>invoices</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>analytics</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>marketing</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>users</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>roles</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>gallary</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>languages</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>Settings</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-4">
<div class="main-box box-spaces">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">created at: </label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<form method="POST" action="{{ route('roles.destroy', $role) }}" class="w-100 d-inline destroy-resource-form">
@csrf
@method('DELETE')
<button type="button" class="btn trans-btn w-100 text-start js-destroy-submit" data-confirm-label="role" data-post-type="role"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
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

