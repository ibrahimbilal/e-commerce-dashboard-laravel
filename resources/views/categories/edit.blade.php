@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-straight.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/quill.snow.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">edit category</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('categories.index') }}">categories</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">edit</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('categories.update', $category) }}" class="row d-block clearfix" data-post-type="Category" id="add-newitem-form" method="POST">
@csrf
@method('PUT')
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">category title</h2>
<input class="form-control" id="item-title" name="category_name" type="text" value="{{ old('category_name', $category->category_name ?? '') }}" />
</div>
<div class="divider"></div>
<div class="form-item primary">
<h2 class="box-title item-title">category description</h2>
<div id="category-desc">
<div class="editor-container"></div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 float-end meta-box">
<div class="row d-block clearfix">
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces">
<div class="form-item second justify-content-between mb-2 d-flex align-items-sm-center">
<label class="item-title meta-title" for="newitem-lang">category Lang:</label>
<select class="form-select dropdown" id="newitem-lang" name="langs">
<option data-flag="./assets/images/flags/us.png" value="en">English</option>
<option data-flag="./assets/images/flags/sa.png" value="ar">Arabic</option>
<option data-flag="./assets/images/flags/fr.png" value="fr">French</option>
</select>
</div>
<div class="form-item second">
<label class="item-title meta-title" for="item-slug">category slug:<span class="icon info ms-2" flow="up" tooltip="slug is the bit of text that appears after your domain name in the URL of a page"><i class="fi-rr-info"> </i></span></label>
<input class="form-control mt-2" id="item-slug" name="category_slug" type="text" value="{{ old('category_slug', $category->category_slug ?? '') }}" />
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">created at: </label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn regular-btn draft" data-post-type="Category">save as draft</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
<div class="btns-holder d-flex justify-content-between mt-2">
<form method="POST" action="{{ route('categories.destroy', $category) }}" class="w-100 d-inline destroy-resource-form">
@csrf
@method('DELETE')
<button type="button" class="btn trans-btn w-100 text-start js-destroy-submit" data-confirm-label="categorie" data-post-type="Category"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
</form>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-12 float-start float-lg-none">
<div class="main-box box-spaces form-item" id="parent-cat">
<h2 class="box-title item-title">parent category</h2>
<div class="cat-list-holder">
<ul class="my-list main-list">
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="clothes"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">clothes</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="men"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">men</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="T-shirts"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">T-shirts</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="Jackets"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">Jackets</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="Coast"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">Coast</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="Sport"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">Sport</span>
</label>
</li>
</ul>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="women"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">women</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="T-shirts"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">T-shirts</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="Jackets"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">Jackets</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="Coast"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">Coast</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="Sport"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">Sport</span>
</label>
</li>
</ul>
</li>
</ul>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="shoeses"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">shoeses</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="men"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">men</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="women"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">women</span>
</label>
</li>
<li class="my-item">
<label class="my-radiobox">
<input class="my-radiobox__input" name="same" type="radio" value="childrens"/>
<div class="my-radiobox__icon"><i class="fi-rr-circle"> </i>
</div><span class="my-radiobox__label">childrens</span>
</label>
</li>
</ul>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces mb-0">
<div class="form-item primary">
<h2 class="box-title item-title">category details</h2>
</div>
<div class="tabs-holder">
<div class="tabs-buttons"><a class="btn tab-btn active" data-tab-id="#general" href="javascript:void(0)">general</a><a class="btn tab-btn" data-tab-id="#seo" href="javascript:void(0)">seo</a></div>
<div class="tabs-boxs box-spaces mb-0">
<div class="tab-box active" id="general">
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-new">Active This Category?<span class="icon info ms-2" flow="up" tooltip="check this if you want active this category."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="product-new" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2" for="product-image">category image:<span class="icon info ms-2" flow="up" tooltip="the image of the category."><i class="fi-rr-info"> </i></span></label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview" src="{{ asset('assets/images/products/image-10.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
</div>
<div class="tab-box" id="seo">
<div class="form-item second d-flex flex-wrap flex-sm-nowrap">
<label class="item-title" for="meta-title">meta title:<span class="icon info ms-2" flow="up" tooltip="the title which be shown in search engines."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="meta-title" name="meta_title" type="text" value="{{ old('meta_title', $category->meta_title ?? '') }}" />
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="meta-desc">meta description:<span class="icon info ms-2" flow="up" tooltip="the description which will be shown under the title in search engines."><i class="fi-rr-info"> </i></span></label>
<textarea class="form-control" id="meta-desc" name="meta_description" rows="3" style="resize:none">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="meta-keyword">meta keywords:<span class="icon info ms-2" flow="up" tooltip="The keyword or key phrase is the search term that you want a page or post to rank for most. When people search for that phrase, they should find you.
separate keywords with comma (,)."><i class="fi-rr-info"> </i></span></label>
<textarea class="form-control" id="meta-keyword" name="meta_keywords" rows="3" style="resize:none">{{ old('meta_keywords', $category->meta_keywords ?? '') }}</textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/select2_args.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/speakingurl.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.stringtoslug.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/quill.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
<script>
      // Data Tables
      const fontSizeArr = ['10px','12px','14px','16px','20px','24px','32px','36px','42px','54px'];
      var Size = Quill.import('attributors/style/size');
      Size.whitelist = fontSizeArr;
      Quill.register(Size, true);
      const toolbarOptions = [
      	[{ header: [1, 2, 3, 4, 5, 6, false] }],              // custom button values
      	['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      	[{ color: [] }],          // dropdown with defaults from theme
      	[{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
      
      	[{ list: 'bullet' }, { list: 'ordered' }],
      	[{ indent: '-1' }, { indent: '+1' }],          // outdent/indent
      	[{ direction: 'rtl' }],                         // text direction
      	[{ size: fontSizeArr }],  // custom dropdown
      	['blockquote'],
      	['clean']                                         // remove formatting button
      ];
      var setting = {
      	bounds: '.editor-container',
      	modules: {
      		toolbar: toolbarOptions,
      	},
      	placeholder: 'Write The Description Here...',
      	theme: 'snow'   // Specify theme in configuration
      };
      var quill = new Quill('.editor-container', setting);
      
      // ===========================================================
      // fire category checkbox function 
      radioBoxFunctions();
    </script>
@endpush

