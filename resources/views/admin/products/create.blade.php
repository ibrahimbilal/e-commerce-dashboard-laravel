@extends('admin.layout')

@section('title', 'E-Commerce Project')

@push('stylesheet')
<link href="{{ asset('css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/quill.snow.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">add product</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.products.index') }}">products</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
<form action="{{ route('admin.products.store') }}" class="row d-block clearfix" data-post-type="Product" id="add-newitem-form" method="POST" data-ajax-form novalidate>
@csrf
<input type="hidden" name="status" id="product-status" value="{{ old('status', 'draft') }}"/>

@php
    $selectedCategoryIds = array_map('intval', (array) old('category_ids', isset($product) ? $product->categories->pluck('id')->all() : []));
    $selectedTagIds = array_map('intval', (array) old('tag_ids', old('product_tags', isset($product) ? $product->tags->pluck('id')->all() : [])));
    $activeLang = old('langs', isset($product) ? ($product->locales->firstWhere('locale', old('langs'))?->locale ?? $product->locales->first()?->locale) : null);
    if (! $activeLang) {
        $activeLang = old('langs', $langs->first()->code ?? 'en');
    }
    $productLocale = isset($product) ? $product->locales->firstWhere('locale', $activeLang) : null;
    $localeName = old('product_name', $productLocale?->name ?? '');
    $localeDescription = old('description', $productLocale?->description ?? '');
    $localeMetaTitle = old('meta_title', $productLocale?->meta_title ?? '');
    $localeMetaDescription = old('meta_description', $productLocale?->meta_description ?? '');
    $localeMetaKeywords = old('meta_keywords', $productLocale?->meta_keywords ?? '');
@endphp
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">product name<span class="text-danger">*</span></h2>
<input class="form-control" id="item-title" name="product_name" type="text" value="{{ $localeName }}" required/>
</div>
<div class="divider"></div>
<div class="form-item primary">
<h2 class="box-title item-title">product description</h2>
<div id="product-desc" data-error-for="description">
<div class="editor-container"></div>
<input type="hidden" name="description" id="description-input" value="{{ e($localeDescription) }}"/>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 float-end meta-box">
<div class="row d-block clearfix">
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces">
@include('components.product-form-sidebar-meta', ['activeLang' => $activeLang])
<x-resource-timestamps />
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn regular-btn draft" type="button" data-post-type="Product" data-ajax-status="draft" data-ajax-form-trigger>save as draft</button>
<button class="btn solid-btn" type="submit" data-ajax-status="published">publish </button>
</div>
<div class="btns-holder d-flex justify-content-between mt-2">
<button class="btn trans-btn w-100 text-start delete" data-post-type="Product"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-12 float-start float-lg-none">
<div class="main-box box-spaces form-item" id="product-cat" data-error-for="category_ids">
<h2 class="box-title item-title">product category<span class="text-danger">*</span></h2>
@include('components.product-category-tree', ['categories' => $categories, 'selectedCategoryIds' => $selectedCategoryIds])
</div>
</div>
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces form-item mb-lg-0" id="product-tags">
<h2 class="box-title item-title">product tags:<span class="icon info ms-2" flow="up" tooltip="separate tags with comma (,)"><i class="fi-rr-info"> </i></span></h2>
<select class="form-select multi-select" id="product-tags-select" multiple="multiple" name="tag_ids[]">
@foreach ($tags as $tag)
<option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTagIds, true))>{{ $tag->title }}</option>
@endforeach
</select>
<div class="selected-tags-container"></div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces mb-0">
<div class="form-item primary">
<h2 class="box-title item-title">product details</h2>
</div>
<div class="tabs-holder">
<div class="tabs-buttons"><a class="btn tab-btn active" data-tab-id="#general" href="javascript:void(0)">general</a><a class="btn tab-btn" data-tab-id="#price" href="javascript:void(0)">price</a><a class="btn tab-btn" data-tab-id="#attribute" href="javascript:void(0)">attribute</a><a class="btn tab-btn" data-tab-id="#seo" href="javascript:void(0)">seo</a></div>
<div class="tabs-boxs box-spaces mb-0">
<div class="tab-box active" id="general">
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="product-sku">product SKU:<span class="icon info ms-2" flow="up" tooltip="A stock keeping unit is a unique identifier for an item sold by a retailer."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="product-sku" name="sku" type="text" value="{{ old('sku') }}"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="product-quantity">product quantity:<span class="icon info ms-2" flow="up" tooltip="total number of product in the stock."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="product-quantity" name="quantity" type="text" value="{{ old('quantity') }}"/>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-new">product is new:<span class="icon info ms-2" flow="up" tooltip='check this if you want add "new" sticker to the product.'><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input type="hidden" name="new" value="0"/>
<input class="switch" id="product-new" name="new" type="checkbox" value="1" @checked(old('new', false))/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-featured">product is featured:<span class="icon info ms-2" flow="up" tooltip='check this if you want add "featured" sticker to the product.'><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input type="hidden" name="featured" value="0"/>
<input class="switch" id="product-featured" name="featured" type="checkbox" value="1" @checked(old('featured', false))/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2" for="product-image">product image:<span class="icon info ms-2" flow="up" tooltip="the main image of the product."><i class="fi-rr-info"> </i></span></label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview" src="{{ asset('images/products/image-10.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2" for="product-gallery">Gallery Images:<span class="icon info ms-2" flow="up" tooltip="the others images of the product."><i class="fi-rr-info"> </i></span></label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">add Images</a>
<div class="selected-img d-flex flex-wrap">
<div class="img-holder mt-3 me-2"><img class="preview" src="{{ asset('images/products/image-8.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
<div class="img-holder mt-3 me-2"><img class="preview" src="{{ asset('images/products/image-6.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
<div class="img-holder mt-3"><img class="preview" src="{{ asset('images/products/image-5.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
</div>
<div class="tab-box" id="price">
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="reg-price">Regular Price:<span class="text-danger">*</span><span class="icon info ms-2" flow="up" tooltip="the price at which the product are sold"><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="reg-price" name="regular_price" type="number" step="0.01" min="0" value="{{ old('regular_price') }}" required/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="sale-price">Sale Price:<span class="icon info ms-2" flow="up" tooltip="the price at which something is sold at after it's price has been reduced."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="sale-price" name="sale_price" type="number" step="0.01" min="0" value="{{ old('sale_price') }}"/>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="schedule">Schedule Sale Price:<span class="icon info ms-2" flow="up" tooltip="check this if you want Schedule Sale of product."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="schedule" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="last-sale-date">Last Day Of Sale:<span class="icon info ms-2" flow="up" tooltip="the date which sale will be end."><i class="fi-rr-info"> </i></span></label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="last-sale-date" name="schedule_sale" type="text" value="{{ old('schedule_sale', old('last_sale_date')) }}"/>
</div>
</div>
</div>
<div class="tab-box" id="attribute">
<x-product-variant-rows :attribute-list="$attributeList" />
</div>
<div class="tab-box" id="seo">
<div class="form-item second d-flex flex-wrap flex-sm-nowrap">
<label class="item-title" for="meta-title">meta title:<span class="icon info ms-2" flow="up" tooltip="the title which be shown in search engines."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="meta-title" name="meta_title" type="text" value="{{ old('meta_title') }}"/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="meta-desc">meta description:<span class="icon info ms-2" flow="up" tooltip="the description which will be shown under the title in search engines."><i class="fi-rr-info"> </i></span></label>
<textarea class="form-control" id="meta-desc" name="meta_description" rows="3" style="resize:none">{{ old('meta_description') }}</textarea>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="meta-keyword">meta keywords:<span class="icon info ms-2" flow="up" tooltip="The keyword or key phrase is the search term that you want a page or post to rank for most. When people search for that phrase, they should find you.
separate keywords with comma (,)."><i class="fi-rr-info"> </i></span></label>
<textarea class="form-control" id="meta-keyword" name="meta_keywords" rows="3" style="resize:none">{{ old('meta_keywords') }}</textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
@include('components.ajax-form-assets')
@endsection

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/select2_args.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/speakingurl.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.stringtoslug.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/quill.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pickadate/picker.date.js') }}" type="text/javascript"></script>
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
      var editorEl = document.querySelector('.editor-container');
      var descriptionInput = document.getElementById('description-input');
      var formEl = document.getElementById('add-newitem-form');
      if (editorEl && typeof Quill !== 'undefined') {
        var quill = new Quill('.editor-container', setting);
        if (descriptionInput && descriptionInput.value) {
          quill.root.innerHTML = descriptionInput.value;
        }
        if (formEl && descriptionInput) {
          formEl.addEventListener('submit', function () {
            descriptionInput.value = quill.root.innerHTML;
          });
        }
      }
    </script>
@endpush
