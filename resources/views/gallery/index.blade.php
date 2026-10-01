@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/filepond/filepond.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/filepond/filepond-plugin-image-preview.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">gallery</h1>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">gallery</span>
</div>
</div>
</div>
</div>
</div>
<div class="gallery-page">
<div class="upload-holder mb-3">
<form action="./upload" enctype="multipart/form-data" id="upload-form" method="post"></form>
</div>
<div class="page-content row">
<div class="col-sm-12 col-lg-9 float-start post-box order-1 open">
<div class="g-holder main-box box-spaces d-flex flex-column mb-0">
<div class="d-flex justify-content-between align-items-sm-center flex-column-reverse flex-sm-row mb-2">
<div class="bulk-action align-self-end mt-2 mt-sm-0 w-100">
<form class="bulk-form">
<select class="bulk-select text-capitalize">
<option value="">bulk action</option>
<option value="edit">edit</option>
<option value="delete">delete</option>
</select>
<button class="btn bulk-submit text-capitalize" type="submit">apply</button>
</form>
</div>
<div class="search-holder">
<form class="search-form">
<div class="form-item second d-flex align-items-center">
<label class="item-title meta-title me-2" for="gal-search">Search:</label>
<input class="form-control d-inline-block" id="gal-search" name="s" type="text"/>
</div>
</form>
</div>
</div>
<div class="images mt-3">
<ul class="list-unstyled images-list">
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-1-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-1.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-2-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-2.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-3-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-3.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-4-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-4.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-5-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-5.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-6-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-6.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-7-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-7.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-8-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-8.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-9-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-9.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-10-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-10.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-11-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-11.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-12-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-12.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-13-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-13.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-14-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-14.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-15-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-15.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-16-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-16.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-17-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-17.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-18-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-18.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-19-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-19.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-20-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-20.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-21-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-21.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-22-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-22.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-23-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-23.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-24-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-24.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-25-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-25.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-26-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-26.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-27-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-27.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-28-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-28.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-29-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-29.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-30-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-30.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-31-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-31.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-32-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-32.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-33-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-33.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-34-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-34.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-35-0" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-35.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-1-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-1.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-2-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-2.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-3-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-3.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-4-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-4.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-5-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-5.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-6-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-6.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-7-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-7.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-8-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-8.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-9-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-9.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-10-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-10.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-11-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-11.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-12-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-12.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-13-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-13.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-14-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-14.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-15-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-15.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-16-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-16.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-17-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-17.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-18-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-18.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-19-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-19.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-20-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-20.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-21-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-21.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-22-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-22.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-23-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-23.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-24-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-24.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-25-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-25.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-26-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-26.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-27-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-27.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-28-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-28.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-29-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-29.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-30-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-30.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-31-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-31.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-32-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-32.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-33-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-33.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-34-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-34.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-35-1" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-35.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-1-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-1.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-2-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-2.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-3-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-3.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-4-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-4.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-5-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-5.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-6-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-6.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-7-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-7.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-8-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-8.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-9-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-9.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-10-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-10.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-11-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-11.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-12-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-12.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-13-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-13.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-14-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-14.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-15-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-15.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-16-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-16.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-17-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-17.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-18-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-18.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-19-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-19.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-20-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-20.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-21-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-21.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-22-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-22.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-23-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-23.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-24-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-24.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-25-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-25.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-26-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-26.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-27-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-27.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-28-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-28.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-29-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-29.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-30-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-30.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-31-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-31.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-32-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-32.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-33-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-33.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-34-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-34.jpg') }}"/>
</label>
</li>
<li class="img-item">
<label class="d-flex justify-content-center align-items-center">
<input name="img-35-2" type="checkbox"/><img src="{{ asset('assets/images/gallery/image-35.jpg') }}"/>
</label>
</li>
</ul>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 float-end meta-box order-lg-1 hide">
<div class="main-box box-spaces">
<div class="row">
<div class="col-sm-5 col-lg-12 d-flex justify-content-center align-items-center">
<div class="img-view text-center"><img src="{{ asset('assets/images/products/image-v.png') }}"/></div>
</div>
<div class="col-sm-7 col-lg-12">
<form id="edit-image-gallery">
<table class="mt-2 w-100">
<tbody>
<tr>
<td class="py-2">
<div class="form-item second">
<label class="item-title meta-title">File Name:</label>
</div>
</td>
<td class="py-2">
<div class="form-item second"><span class="ps-2">product-12.jpg</span></div>
</td>
</tr>
<tr>
<td class="py-2">
<div class="form-item second">
<label class="item-title meta-title">updated date:</label>
</div>
</td>
<td class="py-2">
<div class="form-item second"><span class="ps-2">26/03/2021 14:58</span></div>
</td>
</tr>
<tr>
<td class="py-2">
<div class="form-item second">
<label class="item-title meta-title">uploaded by:</label>
</div>
</td>
<td class="py-2">
<div class="form-item second"><span class="ps-2">Jayson Hinrichsen</span></div>
</td>
</tr>
<tr>
<td class="py-2">
<div class="form-item second">
<label class="item-title meta-title">Image Url:</label>
</div>
</td>
<td class="py-2">
<div class="form-item second">
<input class="form-control ps-2" disabled="" readonly="" value="https://website.com/public/..."/>
</div>
</td>
</tr>
<tr>
<td class="py-2">
<div class="form-item second">
<label class="item-title meta-title">Image Title:</label>
</div>
</td>
<td class="py-2">
<div class="form-item second">
<input class="form-control ps-2" value="product 12"/>
</div>
</td>
</tr>
<tr>
<td class="py-2">
<div class="form-item second">
<label class="item-title meta-title">Alt Text:</label>
</div>
</td>
<td class="py-2">
<div class="form-item second">
<input class="form-control ps-2"/>
</div>
</td>
</tr>
</tbody>
</table>
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn trans-btn text-start delete" data-post-type="Product"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
<button class="btn solid-btn" type="submit">save </button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond-plugin-image-preview.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-size.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-type.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond.jquery.js') }}" type="text/javascript"></script>
<script>
      $.fn.filepond.registerPlugin(
      	FilePondPluginImagePreview,
      	FilePondPluginFileValidateSize,
      	FilePondPluginFileValidateType
      );
      
      var mockServer = {
      	remove: null,
      	revert: null,
      	process: function(fieldName, file, metadata, load, error, progress, abort, transfer, options) {
      
      		var prog = 0;
      		var total = file.size;
      		var speed = 256 * 1024; // KB/s
      
      		const tick = function() {
      
      			prog += Math.random() * speed;
      			prog = Math.min(total, prog);
      
      			progress(true, prog, total);
      
      			if (prog === total) {
      				load(Date.now());
      				return;
      			}
      
      			setTimeout(tick, Math.random() * 250)
      		}
      
      		tick();
      
      		return {
      			abort: function() {
      				abort()
      			}
      		}
      	}
      };
      
      $('#upload-form').filepond({
      	allowFileSizeValidation: true,
      	allowFileTypeValidation: true,
      	allowMultiple: true,
      	allowReorder: true,
      	maxFileSize: '2MB',
      	acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
      	labelFileTypeNotAllowed: 'File is invalid type',
      	fileValidateTypeLabelExpectedTypes: '{allButLastType}',
      	server: mockServer,
      });
      $('#upload-form').on('FilePond:init', function(e) {
      	console.log('file added event', e);
      });
    </script>
@endpush

