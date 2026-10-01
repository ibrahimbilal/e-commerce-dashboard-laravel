@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/quill.snow.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">add product</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('products.index') }}">products</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
@csrf
<form action="{{ route('products.store') }}" class="row d-block clearfix" data-post-type="Product" id="add-newitem-form" method="POST">
<div class="col-sm-12 col-lg-9 float-start post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">product name</h2>
<input class="form-control" id="item-title" name="product_name" type="text"/>
</div>
<div class="divider"></div>
<div class="form-item primary">
<h2 class="box-title item-title">product description</h2>
<div id="product-desc">
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
<label class="item-title meta-title" for="newitem-lang">Product Lang:</label>
<select class="form-select dropdown" id="newitem-lang" name="langs">
<option data-flag="./assets/images/flags/us.png" value="en">English</option>
<option data-flag="./assets/images/flags/sa.png" value="ar">Arabic</option>
<option data-flag="./assets/images/flags/fr.png" value="fr">French</option>
</select>
</div>
<div class="form-item second">
<label class="item-title meta-title" for="item-slug">product slug:<span class="icon info ms-2" flow="up" tooltip="slug is the bit of text that appears after your domain name in the URL of a page"><i class="fi-rr-info"> </i></span></label>
<input class="form-control mt-2" id="item-slug" name="product_slug" type="text"/>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">created at: </label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn regular-btn draft" data-post-type="Product">save as draft</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
<div class="btns-holder d-flex justify-content-between mt-2">
<button class="btn trans-btn w-100 text-start delete" data-post-type="Product"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-12 float-start float-lg-none">
<div class="main-box box-spaces form-item" id="product-cat">
<h2 class="box-title item-title">product category</h2>
<div class="cat-list-holder">
<ul class="my-list main-list">
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">clothes</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">men</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">T-shirts</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Jackets</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Coast</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Sport</span>
</label>
</li>
</ul>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">women</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">T-shirts</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Jackets</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Coast</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">Sport</span>
</label>
</li>
</ul>
</li>
</ul>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">shoeses</span>
</label>
<ul class="my-list child-cat">
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">men</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">women</span>
</label>
</li>
<li class="my-item">
<label class="my-checkbox">
<input class="my-checkbox__input" type="checkbox"/>
<div class="my-checkbox__icon"><i class="fi-rr-square"> </i>
</div><span class="my-checkbox__label">childrens</span>
</label>
</li>
</ul>
</li>
</ul>
</div>
</div>
</div>
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces form-item mb-lg-0" id="product-tags">
<h2 class="box-title item-title">product tags:<span class="icon info ms-2" flow="up" tooltip="separate tags with comma (,)"><i class="fi-rr-info"> </i></span></h2>
<select class="form-select multi-select" id="product-tags-select" multiple="multiple" name="product_tags">
<option selected="" value="Something">Something</option>
<option selected="" value="Clothes">Clothes</option>
<option selected="" value="Yello">Yello</option>
<option value="John">John</option>
<option value="Doe">Doe</option>
<option value="Banana">Banana</option>
<option value="Orange">Orange</option>
<option value="Apple">Apple</option>
<option value="Mango">Mango</option>
<option value="Cabbage">Cabbage</option>
<option value="Turnip">Turnip</option>
<option value="Radish">Radish</option>
<option value="Carrot">Carrot</option>
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
<input class="form-control" id="product-sku" name="product_sku" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="product-quantity">product quantity:<span class="icon info ms-2" flow="up" tooltip="total number of product in the stock."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="product-quantity" name="product_quantity" type="text"/>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-new">product is new:<span class="icon info ms-2" flow="up" tooltip='check this if you want add "new" sticker to the product.'><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="product-new" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-featured">product is featured:<span class="icon info ms-2" flow="up" tooltip='check this if you want add "featured" sticker to the product.'><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="product-featured" name="featured" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2" for="product-image">product image:<span class="icon info ms-2" flow="up" tooltip="the main image of the product."><i class="fi-rr-info"> </i></span></label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">Change Image</a>
<div class="selected-img">
<div class="img-holder mt-3"><img class="preview" src="{{ asset('assets/images/products/image-10.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
<div class="form-item second d-flex mt-3 flex-wrap flex-sm-nowrap">
<div class="item-title">
<label class="item-title mb-2" for="product-gallery">Gallery Images:<span class="icon info ms-2" flow="up" tooltip="the others images of the product."><i class="fi-rr-info"> </i></span></label>
</div>
<div class="item-content"><a class="btn regular-btn gallery-btn" href="javascript:void(0)" style="width: 150px">add Images</a>
<div class="selected-img d-flex flex-wrap">
<div class="img-holder mt-3 me-2"><img class="preview" src="{{ asset('assets/images/products/image-8.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
<div class="img-holder mt-3 me-2"><img class="preview" src="{{ asset('assets/images/products/image-6.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
<div class="img-holder mt-3"><img class="preview" src="{{ asset('assets/images/products/image-5.png') }}" width="70"/><span class="overlay"><i class="fi-rr-trash"> </i><span>remove</span></span></div>
</div>
</div>
</div>
</div>
<div class="tab-box" id="price">
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="reg-price">Regular Price:<span class="icon info ms-2" flow="up" tooltip="the price at which the product are sold"><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="reg-price" name="regular_price" type="text"/>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="sale-price">Sale Price:<span class="icon info ms-2" flow="up" tooltip="the price at which something is sold at after it's price has been reduced."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="sale-price" name="sale_price" type="text"/>
</div>
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="schedule">Schedule Sale Price:<span class="icon info ms-2" flow="up" tooltip="check this if you want Schedule Sale of product."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="schedule" name="new" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="last-sale-date">Last Day Of Sale:<span class="icon info ms-2" flow="up" tooltip="the date which sale will be end."><i class="fi-rr-info"> </i></span></label>
<div class="position-relative w-100">
<input class="form-control" data-toggle="datepicker" id="last-sale-date" name="last_sale_date" type="text"/>
</div>
</div>
</div>
<div class="tab-box" id="attribute">
<div class="select2-wrapper">
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap">
<label class="item-title" for="product-sizes">sizes:<span class="icon info ms-2" flow="up" tooltip="the attribute you created."><i class="fi-rr-info"> </i></span></label>
<select class="form-select multi-select" id="product-sizes" multiple="multiple" name="sizes" placeholder="Select Attribute From The List.">
<option value="XS">XS</option>
<option value="S">S</option>
<option value="M">M</option>
<option value="L">L</option>
<option value="XL">XL</option>
<option value="XXL">XXL</option>
</select>
</div>
<div class="form-item second d-flex align-items-center flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="product-colors">colors:<span class="icon info ms-2" flow="up" tooltip="the attribute you created."><i class="fi-rr-info"> </i></span></label>
<select class="form-select multi-select" id="product-colors" multiple="multiple" name="colors" placeholder="Select Attribute From The List.">
<option value="#000000">black</option>
<option value="#45CC5B">green</option>
<option value="#FE2B2B">red</option>
<option value="#FFA620">orang</option>
<option value="#3932FE">blue</option>
</select>
</div>
</div>
</div>
<div class="tab-box" id="seo">
<div class="form-item second d-flex flex-wrap flex-sm-nowrap">
<label class="item-title" for="meta-title">meta title:<span class="icon info ms-2" flow="up" tooltip="the title which be shown in search engines."><i class="fi-rr-info"> </i></span></label>
<input class="form-control" id="meta-title" name="meta_title" type="text"/>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="meta-desc">meta description:<span class="icon info ms-2" flow="up" tooltip="the description which will be shown under the title in search engines."><i class="fi-rr-info"> </i></span></label>
<textarea class="form-control" id="meta-desc" name="meta_description" rows="3" style="resize:none"></textarea>
</div>
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title" for="meta-keyword">meta keywords:<span class="icon info ms-2" flow="up" tooltip="The keyword or key phrase is the search term that you want a page or post to rank for most. When people search for that phrase, they should find you.
separate keywords with comma (,)."><i class="fi-rr-info"> </i></span></label>
<textarea class="form-control" id="meta-keyword" name="meta_keywords" rows="3" style="resize:none"></textarea>
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
<script src="{{ asset('assets/js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.date.js') }}" type="text/javascript"></script>
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
      checkboxFunctions();
    </script>
@endpush

