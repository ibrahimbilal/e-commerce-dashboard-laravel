@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view user</h1>
@if (Route::has('users.edit'))
@can('edit users')
<a class="add-btn btn text-capitalize" href="{{ route('users.edit', $user) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit <span class="page">user<span></span></span></a>
@endcan
@endif
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('users.index') }}">users</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<div class="row">
<div class="col-sm-12 col-lg-3 d-flex justify-content-center user-holder">
<div class="profile-image text-center w-100"><img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('assets/images/customers/image-2.png') }}" alt=""/></div>
</div>
<div class="col-sm-12 col-lg-9">
<div class="profile-details row mt-3 mt-lg-0">
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>First Name:</b></div><span class="ms-2">{{ $user->first_name ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Last Name:</b></div><span class="ms-2">{{ $user->last_name ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Email Address:</b></div><span class="ms-2">{{ $user->email }}</span>
</div>
<x-account-activity-meta :subject="$user" />
</div>
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Mobile:</b></div><span class="ms-2">{{ $user->mobile ?? '—' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Roles:</b></div>
<span class="ms-2">
@if ($user->getRoleNames()->isNotEmpty())
@foreach ($user->getRoleNames() as $roleName)
<span class="badge bg-secondary me-1 text-capitalize">{{ $roleName }}</span>
@endforeach
@else
—
@endif
</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">Activities</h2>
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="activities">
<thead>
<tr>
<th class="text-uppercase">Activiy</th>
<th class="text-uppercase">Post Type</th>
<th class="text-uppercase">Post Title</th>
<th class="text-uppercase">Activity Date</th>
<th class="text-uppercase">Action</th>
</tr>
</thead>
<tbody>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Apple Ipad Pro 64GB</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Aliquam Quaerat Ultrices Cursus</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Apple Ipad Pro 64GB</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Aliquam Quaerat Ultrices Cursus</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Apple Ipad Pro 64GB</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Aliquam Quaerat Ultrices Cursus</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Apple Ipad Pro 64GB</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Aliquam Quaerat Ultrices Cursus</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Apple Ipad Pro 64GB</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Product</td>
<td class="text-capitalize">Aliquam Quaerat Ultrices Cursus</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase delete">delete</td>
<td class="text-capitalize">Attribute</td>
<td class="text-capitalize">Color</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Category</td>
<td class="text-capitalize">Clothes, Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase create">create</td>
<td class="text-capitalize">Order</td>
<td class="text-capitalize">#23234</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td class="status text-uppercase update">update</td>
<td class="text-capitalize">Tag</td>
<td class="text-capitalize">Men</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="javascript:void(0)"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection
