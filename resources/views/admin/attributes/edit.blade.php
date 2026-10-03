@extends('admin.layout')

@section('title', 'E-Commerce Project')

@push('stylesheet')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">edit attribute</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.attributes.index') }}">attributes</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.attributes.update', $attribute) }}" class="row clearfix" data-post-type="attribute" id="add-newitem-form" method="POST">
@csrf
@method('PUT')
<div class="col-sm-12">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">attribute title</h2>
<input class="form-control" id="item-title" name="attribute_key" type="text" value="{{ old('attribute_key', $attribute->attribute_key ?? '') }}" />
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">Attribute Terms</h2>
</div>
<div class="alerts warning">
<ul class="list">
<li class="content">You Haven't Create Any Terms Yet.</li>
</ul>
</div>
<div class="repeater-holder">
<div class="repeater mb-3">
<div class="repeater-title p-3 mb-3 d-flex justify-content-between align-items-center">
<h3 class="h5 mb-0">Term Title</h3>
<div class="icons d-flex align-items-center"><span class="icon active"><i class="fi-rr-angle-small-down"> </i></span><span class="remove" flow="up" tooltip="Remove"><i class="fi-rr-trash"> </i></span></div>
</div>
<div class="repeater-inputs px-3 active">
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="term-title">term title:</label>
<input class="form-control" id="term-title" type="text" disabled="disabled" placeholder="Terms UI only (not saved with attribute)"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="term-type">term type:</label>
<select class="form-select" id="term-type">
<option>Text</option>
<option>Color</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="term-value">term value:</label>
<input class="form-control" id="term-value" name="attribute_value" type="text" value="{{ old('attribute_value', $attribute->attribute_value ?? '') }}" />
</div>
</div>
</div>
</div>
<div class="add-repeater-item mt-3"><a class="btn">Add New Attribute Term</a></div>
</div>
</div>
<div class="col-sm-12 col-lg-3 meta-box">
<div class="row d-block clearfix">
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces mb-0">
<div class="form-item second">
<label class="item-title meta-title" for="item-slug">attribute slug:<span class="icon info ms-2" flow="up" tooltip="slug is the bit of text that appears after your domain name in the URL of a page"><i class="fi-rr-info"> </i></span></label>
<input class="form-control mt-2" id="item-slug" type="text" value="{{ old('attribute_slug', $attribute->attribute_slug ?? '') }}" />
</div>
<x-resource-timestamps :model="$attribute" />
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn regular-btn draft" data-post-type="tag">save as draft</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
<div class="btns-holder d-flex justify-content-between mt-2">
<button type="button" class="btn trans-btn w-100 text-start" data-confirm-delete="soft" form="attribute-destroy-form" data-confirm-label="attribute" data-post-type="tag"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
</div>
</div>
</div>
</div>
</div>
</form>
<form method="POST" action="{{ route('admin.attributes.destroy', $attribute) }}" id="attribute-destroy-form" class="destroy-resource-form d-none" data-confirm-delete="soft">@csrf @method('DELETE')</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/speakingurl.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.stringtoslug.min.js') }}" type="text/javascript"></script>
@endpush

