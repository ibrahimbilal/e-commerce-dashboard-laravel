@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="page-title text-capitalize">add user</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('users.index') }}">users</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('users.store') }}" class="row d-block clearfix" data-post-type="user" id="add-newitem-form" method="POST">
@csrf
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">user details</h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="first-name">first name:</label>
<input class="form-control" id="first-name" name="first_name" type="text" value="{{ old('first_name') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="last-name">last name:</label>
<input class="form-control" id="last-name" name="last_name" type="text" value="{{ old('last_name') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="email">email address:</label>
<input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="password">password:</label>
<div class="with-icon">
<input class="form-control" id="password" name="password" type="password"/><span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
<button class="btn regular-btn ms-sm-3 mt-2 mt-sm-0 text-nowrap generate-password" type="button">generate</button>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="mobile">mobile:</label>
<input class="form-control" id="mobile" name="mobile" type="tel" value="{{ old('mobile') }}"/>
</div>
@include('components.user-roles-field')
<input type="hidden" name="profile_picture" value="{{ old('profile_picture') }}"/>
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
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box">
<div class="main-box box-spaces mb-0">
<div class="btns-holder d-flex justify-content-between">
<button class="btn solid-btn w-100" type="submit">create </button>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.date.js') }}" type="text/javascript"></script>
@endpush

