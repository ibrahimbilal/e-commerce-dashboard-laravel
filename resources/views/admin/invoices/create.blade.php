@extends('admin.layout')

@section('title', 'E-Commerce Project')

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<h1 class="page-title text-capitalize">add invoice</h1>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize" href="{{ route('admin.dashboard') }}">dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize" href="{{ route('admin.invoices.index') }}">invoices</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize">add</span></div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.invoices.store') }}" method="POST" class="row" data-ajax-form novalidate>
@csrf
<div class="col-12 col-lg-6">
<div class="main-box box-spaces">
@include('components.invoice-form-fields')
<div class="mt-4">
<button type="submit" class="btn solid-btn">save</button>
</div>
</div>
</div>
</form>
@include('components.ajax-form-assets')
@endsection