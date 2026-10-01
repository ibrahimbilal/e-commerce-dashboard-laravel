@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0">
<h1 class="page-title">my account</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center">
<a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a>
<span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span>
<span class="item text-capitalize d-flex justify-content-between align-items-center">profile</span>
</div>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12 col-lg-3 d-flex justify-content-center user-holder mb-3 mb-lg-0">
<div class="profile-image text-center w-100">
<img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('assets/images/avatar-placeholder.svg') }}" alt=""/>
</div>
</div>
<div class="col-sm-12 col-lg-9">
@if (Route::has('profile.update'))
<div class="main-box box-spaces mb-3">
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Profile details</h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="first-name">first name:</label>
<input class="form-control" id="first-name" name="first_name" type="text" value="{{ old('first_name', $user->first_name ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="last-name">last name:</label>
<input class="form-control" id="last-name" name="last_name" type="text" value="{{ old('last_name', $user->last_name ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="email">email address:</label>
<input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="mobile">mobile:</label>
<input class="form-control" id="mobile" name="mobile" type="tel" value="{{ old('mobile', $user->mobile ?? '') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="profile-picture">profile picture:</label>
<input class="form-control" id="profile-picture" name="profile_picture" type="file" accept="image/*"/>
</div>
<div class="mt-4">
<button class="btn solid-btn" type="submit">save profile</button>
</div>
</form>
</div>
@endif

@if (Route::has('profile.password'))
<div class="main-box box-spaces">
<form action="{{ route('profile.password') }}" method="POST">
@csrf
@method('PUT')
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Change password</h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="current-password">current password:</label>
<div class="with-icon w-100">
<input class="form-control" id="current-password" name="current_password" type="password" autocomplete="current-password"/>
<span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="password">new password:</label>
<div class="with-icon w-100">
<input class="form-control" id="password" name="password" type="password" autocomplete="new-password"/>
<span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="password-confirmation">confirm password:</label>
<div class="with-icon w-100">
<input class="form-control" id="password-confirmation" name="password_confirmation" type="password" autocomplete="new-password"/>
<span class="show-pass"><i class="fi-rr-eye"> </i></span>
</div>
</div>
<div class="mt-4">
<button class="btn solid-btn" type="submit">update password</button>
</div>
</form>
</div>
@endif

@if (! Route::has('profile.update') && ! Route::has('profile.password'))
<div class="main-box box-spaces">
<p class="text-muted mb-0">Profile settings are not available yet.</p>
</div>
@endif
</div>
</div>
@endsection
