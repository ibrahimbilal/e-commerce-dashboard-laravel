@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">settings</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">settings</span>
</div>
</div>
</div>
</div>
</div>
@csrf
@method('PUT')
<form action="{{ route('settings.update') }}" class="row d-block clearfix" data-post-type="settings" id="settings-form" method="POST">
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Emails Settings</h2>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="email-from">"From" Name:<span class="icon info ms-2" flow="up" tooltip="How the sender name appears in outgoing your store emails."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="email-from" name="email_from" placeholder="Store Name" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="email-from">"From" Address:<span class="icon info ms-2" flow="up" tooltip="How the sender email appears in outgoing from your store emails."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="email-from" name="email_from" placeholder="example@email.com" type="text"/>
</div>
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Base Color:<span class="icon info ms-2" flow="up" tooltip="The base color for store email templates. Default #2C2CCC."><i class="fi-rr-info"> </i></span></label>
<input class="form-control-color" name="email_base_color" title="Choose your color" type="color" value="#2C2CCC"/>
</div>
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Background Color:<span class="icon info ms-2" flow="up" tooltip="The background color for store email templates. Default #F7F7F7."><i class="fi-rr-info"> </i></span></label>
<input class="form-control-color" name="email_bg_color" title="Choose your color" type="color" value="#F7F7F7"/>
</div>
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Body Background Color:<span class="icon info ms-2" flow="up" tooltip="The main body background color. Default #FFFFFF."><i class="fi-rr-info"> </i></span></label>
<input class="form-control-color" name="email_body_bg_color" title="Choose your color" type="color" value="#FFFFFF"/>
</div>
<div class="form-item second d-flex flex-wrap align-items-center mt-3">
<label class="item-title mb-2">Body Text Color:<span class="icon info ms-2" flow="up" tooltip="The main body text color. Default #333333."><i class="fi-rr-info"> </i></span></label>
<input class="form-control-color" name="email_text_color" title="Choose your color" type="color" value="#333333"/>
</div>
<hr/>
<div class="form-item primary mb-3">
<h2 class="box-title item-title">Email Notification Settings</h2>
</div>
<div class="form-item second d-flex mt-3 flex-wrap">
<div class="item-title d-block mb-2">
<label class="item-title" for="new-order">New Order Placed:<span class="icon info ms-2" flow="up" tooltip="Sent email when a new order is placed"><i class="fi-rr-info"> </i></span></label><small>Recipient Are Store Users</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch control-toggle" data-toggle="new-order-recipients" id="new-order" name="email-new-order" type="checkbox"/><span class="slider"></span>
</label>
<div class="form-item d-flex flex-column mt-1" id="new-order-recipients">
<div class="item-title">send to:<span class="icon info ms-2" flow="up" tooltip="Custom Recipients: you should choose recipients from the list. Recipients By Role: all members in the role will be receive the email."><i class="fi-rr-info"> </i></span></div>
<div class="controls-wrapper d-flex align-items-start mt-2">
<select class="form-select w-mc me-2" name="new-order-recipients-type">
<option value="custom">Custom Recipients</option>
<option value="recipients-role">Recipients By Role</option>
</select>
<div class="select2-wrapper w-100">
<select class="form-select multi-select" id="new-order-recipients-emails" multiple="multiple" name="new-order-recipients-emails" placeholder="Select Recipients">
<option value="example1@email.com">example1@email.com</option>
<option value="example2@email.com">example2@email.com</option>
<option value="example3@email.com">example3@email.com</option>
<option value="example4@email.com">example4@email.com</option>
<option value="example5@email.com">example5@email.com</option>
<option value="example6@email.com">example6@email.com</option>
</select>
</div>
</div>
</div>
</div>
</div>
<div class="form-item second d-flex mt-3 flex-wrap">
<div class="item-title d-block mb-2">
<label class="item-title" for="out-of-stock">Out Of Stock:<span class="icon info ms-2" flow="up" tooltip="Sent email when product is out of stock"><i class="fi-rr-info"> </i></span></label><small>Recipient Are Store Users</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch control-toggle" data-toggle="out-of-stock-recipients" id="out-of-stock" name="email-new-order" type="checkbox"/><span class="slider"></span>
</label>
<div class="form-item d-flex flex-column mt-1" id="out-of-stock-recipients">
<div class="item-title">send to:<span class="icon info ms-2" flow="up" tooltip="Custom Recipients: you should choose recipients from the list. Recipients By Role: all members in the role will be receive the email."><i class="fi-rr-info"> </i></span></div>
<div class="controls-wrapper d-flex align-items-start mt-2">
<select class="form-select w-mc me-2" name="out-of-stock-recipients-type">
<option value="custom">Custom Recipients</option>
<option value="recipients-role">Recipients By Role</option>
</select>
<div class="select2-wrapper w-100">
<select class="form-select multi-select" id="out-of-stock-recipients-emails" multiple="multiple" name="out-of-stock-recipients-emails" placeholder="Select Recipients">
<option value="example1@email.com">example1@email.com</option>
<option value="example2@email.com">example2@email.com</option>
<option value="example3@email.com">example3@email.com</option>
<option value="example4@email.com">example4@email.com</option>
<option value="example5@email.com">example5@email.com</option>
<option value="example6@email.com">example6@email.com</option>
</select>
</div>
</div>
</div>
</div>
</div>
<div class="form-item second d-flex mt-3 flex-wrap">
<div class="item-title d-block mb-2">
<label class="item-title" for="order-canceled">Order Canceled:<span class="icon info ms-2" flow="up" tooltip="Sent email when customer canceled the order"><i class="fi-rr-info"> </i></span></label><small>Recipient Are Store Users</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch control-toggle" data-toggle="order-canceled-recipients" id="order-canceled" name="email-new-order" type="checkbox"/><span class="slider"></span>
</label>
<div class="form-item d-flex flex-column mt-1" id="order-canceled-recipients">
<div class="item-title">send to:<span class="icon info ms-2" flow="up" tooltip="Custom Recipients: you should choose recipients from the list. Recipients By Role: all members in the role will be receive the email."><i class="fi-rr-info"> </i></span></div>
<div class="controls-wrapper d-flex align-items-start mt-2">
<select class="form-select w-mc me-2" name="order-canceled-recipients-type">
<option value="custom">Custom Recipients</option>
<option value="recipients-role">Recipients By Role</option>
</select>
<div class="select2-wrapper w-100">
<select class="form-select multi-select" id="order-canceled-recipients-emails" multiple="multiple" name="order-canceled-recipients-emails" placeholder="Select Recipients">
<option value="example1@email.com">example1@email.com</option>
<option value="example2@email.com">example2@email.com</option>
<option value="example3@email.com">example3@email.com</option>
<option value="example4@email.com">example4@email.com</option>
<option value="example5@email.com">example5@email.com</option>
<option value="example6@email.com">example6@email.com</option>
</select>
</div>
</div>
</div>
</div>
</div>
<div class="form-item second d-flex mt-3">
<div class="item-title d-block mb-2">
<label class="item-title" for="order-confirmed">Order Confirmed:<span class="icon info ms-2" flow="up" tooltip="Sent email automatically after purchase"><i class="fi-rr-info"> </i></span></label><small>Recipient Is Customer</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch" id="order-confirmed" name="order-confirmed" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
<div class="form-item second d-flex mt-3">
<div class="item-title d-block mb-2">
<label class="item-title" for="order-shipped">Order Shipped:<span class="icon info ms-2" flow="up" tooltip="Sent email automatically when an order is marked as shipped"><i class="fi-rr-info"> </i></span></label><small>Recipient Is Customer</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch" id="order-shipped" name="order-shipped" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
<div class="form-item second d-flex mt-3">
<div class="item-title d-block mb-2">
<label class="item-title" for="order-completed">Order Completed:<span class="icon info ms-2" flow="up" tooltip="Sent automatically when an order is marked as completed"><i class="fi-rr-info"> </i></span></label><small>Recipient Is Customer</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch" id="order-completed" name="order-completed" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
<div class="form-item second d-flex mt-3">
<div class="item-title d-block mb-2">
<label class="item-title" for="order-refunded">Order Refunded:<span class="icon info ms-2" flow="up" tooltip="Sent automatically when a refund is issued"><i class="fi-rr-info"> </i></span></label><small>Recipient Is Customer</small>
</div>
<div class="item-content">
<label class="switch text-start">
<input checked="" class="switch" id="order-refunded" name="order-refunded" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-3 float-end meta-box">
<div class="main-box box-spaces mb-0 mt-3 mt-lg-0">
<div class="btns-holder d-flex justify-content-between">
<button class="btn solid-btn w-100" type="submit">Save Changes </button>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2_args.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
@endpush

