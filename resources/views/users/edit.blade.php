@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="page-title text-capitalize">edit user</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('users.index') }}">users</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('users.update', $user) }}" class="row d-block clearfix" data-post-type="user" id="add-newitem-form" method="POST">
@csrf
@method('PUT')
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">user details</h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="first-name">first name:</label>
<input class="form-control" id="first-name" name="first_name" type="text"   value="{{ old('first_name', $user->first_name ?? '') }}" />
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="last-name">last name:</label>
<input class="form-control" id="last-name" name="last_name" type="text"   value="{{ old('last_name', $user->last_name ?? '') }}" />
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="email">email address:</label>
<input class="form-control" id="email" name="email" type="email"   value="{{ old('email', $user->email ?? '') }}" />
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="mobile">mobile:</label>
<input class="form-control" id="mobile" name="mobile" type="tel"   value="{{ old('mobile', $user->mobile ?? '') }}" />
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="birth-date">Birth Of Date:</label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="birth-date" name="birth_date" type="text"   value="{{ old('birth_date', $user->birth_date ?? '') }}" />
</div>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title">gender:</label>
<label class="radio-label" for="male">
<input checked="" class="input-radio" id="male" name="customer_type" type="radio" value="Male"/>Male
              </label>
<label class="radio-label" for="female">
<input class="input-radio" id="female" name="customer_type" type="radio" value="Female"/>Female
              </label>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="user-role">role:</label>
<select class="form-select" id="user-role" name="user_role">
<option>administrator</option>
<option>store manager</option>
<option>accountant</option>
</select>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="user-status">status:</label>
<select class="form-select" id="user-status" name="user_status">
<option>not verified</option>
<option>verified</option>
<option>blocked</option>
</select>
</div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2" for="profile-picture">Profile Picture:</label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview" src="{{ asset('assets/images/customers/image-1.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
</div>
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">Change Password</h2>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="current-password">current password:</label>
<div class="with-icon">
<input class="form-control" id="current-password" name="current_password" type="password"   /><span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="new-password">new password:</label>
<div class="with-icon">
<input class="form-control" id="password" name="password" type="password"   /><span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password" type="button">generate</button>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="confirm-password">confirm password:</label>
<div class="with-icon">
<input class="form-control" id="confirm-password" name="confirm_password" type="password"   /><span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box">
<div class="main-box box-spaces">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">Registered At:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">Last Logged In:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">Device:</label><span class="ms-2">Samsung Galaxy S20</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">iP Address:</label><span class="ms-2">216.58.217.164</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">iP Country:</label><span class="ms-2">United State</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">iP City:</label><span class="ms-2">New York</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn solid-btn" type="submit">update </button>
</div>
<div class="btns-holder d-flex justify-content-between mt-2">
<form method="POST" action="{{ route('users.destroy', $user) }}" class="w-100 d-inline destroy-resource-form">
@csrf
@method('DELETE')
<button type="button" class="btn trans-btn w-100 text-start js-destroy-submit" data-confirm-label="user"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
</form>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">Two Factor Authentication</h2>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2">status:</label>
</div>
<div class="item-content">
<p class="mb-0">2FA Is Disabled</p><small>When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.</small><br/>
<button class="btn regular-btn mt-2 text-nowrap" type="button">Enable</button>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">Browser Sessions</h2>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap"><small>If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.</small></div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2">Active Sessions:</label>
</div>
<div class="item-content">
<div class="sessions-list">
<div class="session-item">
<div class="icon"> <i class="fi-rr-computer"> </i>
</div>
<div class="details">
<div class="browser">Windows - Chrome</div>
<div class="status"><span class="ip">127.0.0.1,</span><span class="login this">This device</span></div>
</div>
</div>
<div class="session-item">
<div class="icon"> <i class="fi-rr-smartphone"> </i>
</div>
<div class="details">
<div class="browser">AndroidOS - Chrome</div>
<div class="status"><span class="ip">127.0.0.1,</span><span class="login">Last active 15 seconds ago</span></div>
</div>
</div>
</div>
<button class="btn solid-btn mt-3" type="button">Log Out Other Browser Sessions </button>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces mb-0">
<div class="form-item primary">
<h2 class="box-title item-title">Activities</h2>
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
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.date.js') }}" type="text/javascript"></script>
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

