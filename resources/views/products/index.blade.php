@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">products</h1><a class="add-btn btn text-capitalize" href="{{ route('products.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">products</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2">
<div class="dash-filters"><a class="item text-capitalize" href="#">Published (50)</a><a class="item text-capitalize" href="#">Draft (12)</a><a class="item text-capitalize" href="#">Trashed (99)</a><a class="item text-capitalize" href="#">Featured (45)</a><a class="item text-capitalize" href="#">New (675)</a><a class="item text-capitalize" href="#">Sale (124)</a>
</div>
<div class="bulk-action align-self-end">
<form class="bulk-form">
<select class="bulk-select text-capitalize">
<option value="">bulk action</option>
<option value="edit">edit</option>
<option value="delete">delete</option>
</select>
<button class="btn bulk-submit text-capitalize" type="submit">apply</button>
</form>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="products">
<thead>
<tr>
<th></th>
<th class="text-uppercase">image</th>
<th class="text-uppercase">product name</th>
<th class="text-uppercase">sku</th>
<th class="text-uppercase">price</th>
<th class="text-uppercase">status</th>
<th class="text-uppercase text-center">featured</th>
<th class="text-uppercase text-center">new</th>
<th class="text-uppercase">published date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Watch Series 4 GPS</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Beats Headphones</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Apple Ipad Pro 64GB</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">Published</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Aliquam Quaerat Ultrices Cursus</td>
<td class="text-uppercase">pd349</td>
<td>$398</td>
<td class="text-capitalize">draft</td>
<td class="text-center">
<label class="switch">
<input checked="" class="switch" data-product-id="1" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" data-product-id="1" name="new" type="checkbox"/><span class="slider"></span>
</label>
</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('products.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('products.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="product"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
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
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
      // Data Tables
      let product_table = $('#products').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [0, 1, 5, 6, 7, 9] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [0, 1, 5, 6, 7, 9 ] 
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[8, 'desc']
      	],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ Products",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 25, 50, 75, 100 ], ['10 Products', '25 Products', '50 Products', '75 Products', '100 Products']],
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
      product_table.on("click", "th.select-checkbox", function() {
      	if ($("th.select-checkbox").hasClass("selected")) {
      		product_table.rows().deselect();
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		product_table.rows().select();
      		$("th.select-checkbox").addClass("selected");
      	}
      }).on("select deselect", function() {
      	("Some selection or deselection going on")
      	if (product_table.rows({
      		selected: true
      		}).count() !== product_table.rows().count()) {
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		$("th.select-checkbox").addClass("selected");
      	}
      });
    </script>
@endpush

