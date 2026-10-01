@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view order</h1><a class="add-btn btn text-capitalize" href="{{ route('orders.create') }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit <span class="page">order<span></span></span></a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('orders.index') }}">orders</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">order Details:</h2>
<div class="row">
<div class="col-sm-6">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table">
<tbody>
<tr>
<td>Order ID:</td>
<td>#27282</td>
</tr>
<tr>
<td>Order Date:</td>
<td>26/03/2021 14:58</td>
</tr>
<tr>
<td>Order Status:</td>
<td class="status success">Processing</td>
</tr>
<tr>
<td>Payment Method:</td>
<td>Cash On Delivery</td>
</tr>
<tr>
<td>Payment Status:</td>
<td>Paid</td>
</tr>
<tr>
<td>Payment Currency:</td>
<td>USD</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table">
<tbody>
<tr>
<td>Customer Name:</td>
<td>Mildred Stoddard</td>
</tr>
<tr>
<td>Email Address:</td>
<td>m.stoddard@gmail.com</td>
</tr>
<tr>
<td>Mobile:</td>
<td>516-913-8323</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">order Addresses:</h2>
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table w-100">
<thead>
<th></th>
<th>Billing to:</th>
<th>Shipping to:</th>
</thead>
<tbody>
<tr>
<td>
<p class="title title-2 mb-0">Full Name:</p>
</td>
<td>Jayson Hinrichsen</td>
<td>Jayson Hinrichsen</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Address:</p>
</td>
<td>1881  Rosewood Lane</td>
<td>1881  Rosewood Lane</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">City:</p>
</td>
<td>New York City</td>
<td>New York City</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Country:</p>
</td>
<td>United State</td>
<td>United State</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Postal:</p>
</td>
<td>10011</td>
<td>10011</td>
</tr>
<tr>
<td>
<p class="title title-2 mb-0">Mobile:</p>
</td>
<td>516-913-8323</td>
<td>516-913-8323</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize mb-3">order Items:</h2>
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped">
<thead>
<tr>
<th class="text-uppercase">image</th>
<th class="text-uppercase">product name</th>
<th class="text-uppercase">price</th>
<th class="text-uppercase">quantity</th>
<th class="text-uppercase">total</th>
</tr>
</thead>
<tbody>
<tr>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-1.png') }}" width="40"/></div>
</td>
<td class="text-capitalize">Apple Watch Series 4 GPS</td>
<td class="text-capitalize">399$</td>
<td class="text-capitalize">10</td>
<td class="text-capitalize">3990$</td>
</tr>
<tr>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-2.png') }}" width="40"/></div>
</td>
<td class="text-capitalize">Apple Watch Series 4 GPS</td>
<td class="text-capitalize">300$</td>
<td class="text-capitalize">5</td>
<td class="text-capitalize">1500$</td>
</tr>
<tr>
<td class="prod-img">
<div class="img-holder"><img src="{{ asset('assets/images/products/image-3.png') }}" width="40"/></div>
</td>
<td class="text-capitalize">Apple Watch Series 4 GPS</td>
<td class="text-capitalize">100$</td>
<td class="text-capitalize">3</td>
<td class="text-capitalize">300$</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="order-footer d-flex flex-column flex-sm-row justify-content-between mt-3">
<div class="total-holder">
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">subtotal:</div><span class="ms-2">799$</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">tax:</div><span class="ms-2">100$</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">Shipping Costs:</div><span class="ms-2">159.8$</span>
</div>
<div class="item form-item second d-flex justify-content-between">
<div class="item-title">Order Total Costs:</div><span class="ms-2">1058.8$</span>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
@endpush

