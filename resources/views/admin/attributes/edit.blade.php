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
<form action="{{ route('admin.attributes.update', $attribute) }}" class="row clearfix" data-post-type="attribute" id="add-newitem-form" method="POST" data-ajax-form novalidate>
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
<div class="col-sm-12 col-lg-9 post-box flex-grow-1">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">Attribute Terms</h2>
</div>
@include('components.admin.attribute-terms-repeater', ['attribute' => $attribute ?? null, 'terms' => $terms ?? null])

</div>
</div>
<div class="col-sm-12 meta-box">
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
@include('components.ajax-form-assets')
@include('components.repeater-assets')
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/speakingurl.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.stringtoslug.min.js') }}" type="text/javascript"></script>
@endpush
