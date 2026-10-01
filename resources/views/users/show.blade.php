@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view user</h1><a class="add-btn btn text-capitalize" href="{{ route('users.create') }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit <span class="page">user<span></span></span></a>
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
<div class="profile-image text-center w-100"><img src="{{ asset('assets/images/customers/image-2.png') }}"/></div>
</div>
<div class="col-sm-12 col-lg-9">
<div class="profile-details row mt-3 mt-lg-0">
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>First Name:</b></div><span class="ms-2">Mildred</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Last Name:</b></div><span class="ms-2">Stoddard</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Email Address:</b></div><span class="ms-2">m.stoddard@gmail.com</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Registered At:</b></div><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Updated At:</b></div><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Last Logged In:</b></div><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Device:</b></div><span class="ms-2">Samsung Galaxy S20</span>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Birth Of Date:</b></div><span class="ms-2">26/03/2021</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Mobile:</b></div><span class="ms-2">516-913-8323</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Gender:</b></div><span class="ms-2">Female</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>iP Address:</b></div><span class="ms-2">216.58.217.164</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>iP Country:</b></div><span class="ms-2">United State</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>iP City:</b></div><span class="ms-2">New York</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>role:</b></div><span class="ms-2">Administrator</span>
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

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script>
      // Data Tables
      let product_table = $('#activities').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{ 
      			bSortable: false, 
      			aTargets: [ 4] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [ 0, 1, 2, 3] 
      		}
      	],
      	order: [
      		[3, 'desc']
      	],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ Activity",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 Activities', '15 Activities', '25 Activities', '50 Activities', '75 Activities', '100 Activities']],
      	buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
      		extend: 'collection',
      		text: 'Export',
      		className: 'btn btn-group',
      		buttons: [
      			{
      				extend: 'excelHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'csvHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'pdfHtml5',
      				className: 'dropdown-item'
      			}
      		]
      	}, 'colvis'] : ['pageLength', {
      		extend: 'collection',
      		text: 'Export',
      		className: 'btn btn-group',
      		buttons: [
      			{
      				extend: 'excelHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'csvHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'pdfHtml5',
      				className: 'dropdown-item'
      			}
      		]
      	}, 'colvis']
      });
    </script>
@endpush

