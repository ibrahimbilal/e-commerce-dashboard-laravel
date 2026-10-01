@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/quill.snow.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">add tag</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('tags.index') }}">tags</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">add</span>
</div>
</div>
</div>
</div>
</div>
@csrf
<form action="{{ route('tags.store') }}" class="row clearfix" data-post-type="tag" id="add-newitem-form" method="POST">
<div class="col-sm-12 col-lg-9 post-box">
<div class="main-box box-spaces">
<div class="form-item primary">
<h2 class="box-title item-title">tag title</h2>
<input class="form-control" id="item-title" name="tag_name" type="text"/>
</div>
<div class="divider"></div>
<div class="form-item primary">
<h2 class="box-title item-title">tag description</h2>
<div id="tag-desc">
<div class="editor-container"></div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-3 meta-box">
<div class="row d-block clearfix">
<div class="col-sm-6 col-lg-12 float-end float-lg-none">
<div class="main-box box-spaces">
<div class="form-item second justify-content-between mb-2 d-flex align-items-sm-center">
<label class="item-title meta-title" for="newitem-lang">tag Lang:</label>
<select class="form-select dropdown" id="newitem-lang" name="langs">
<option data-flag="./assets/images/flags/us.png" value="en">English</option>
<option data-flag="./assets/images/flags/sa.png" value="ar">Arabic</option>
<option data-flag="./assets/images/flags/fr.png" value="fr">French</option>
</select>
</div>
<div class="form-item second">
<label class="item-title meta-title" for="item-slug">tag slug:<span class="icon info ms-2" flow="up" tooltip="slug is the bit of text that appears after your domain name in the URL of a page"><i class="fi-rr-info"> </i></span></label>
<input class="form-control mt-2" id="item-slug" name="tag_slug" type="text"/>
</div>
<div class="form-item second mt-2">
<label class="item-title meta-title" for="parent-id">parent tag:</label>
<select class="form-select" id="parent-id" name="parent_id">
<option value="">None / top level</option>
@foreach ($parents as $parent)
<option value="{{ $parent->id }}" @selected((string) old('parent_id', optional($tag ?? null)->parent_id) === (string) $parent->id)>{{ $parent->title }}</option>
@endforeach
</select>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">created at: </label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="btns-holder d-flex justify-content-between mt-4">
<button class="btn regular-btn draft" data-post-type="tag">save as draft</button>
<button class="btn solid-btn" type="submit">publish </button>
</div>
<div class="btns-holder d-flex justify-content-between mt-2">
<button class="btn trans-btn w-100 text-start delete" data-post-type="tag"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-12 col-lg-9 post-box">
<div class="main-box box-spaces mb-0">
<div class="form-item primary">
<h2 class="box-title item-title">tag details</h2>
</div>
<div class="tabs-holder">
<div class="tabs-buttons"><a class="btn tab-btn active" data-tab-id="#general" href="javascript:void(0)">general</a><a class="btn tab-btn" data-tab-id="#seo" href="javascript:void(0)">seo</a></div>
<div class="tabs-boxs box-spaces mb-0">
<div class="tab-box active" id="general">
<div class="form-item second d-flex align-items-center mt-3">
<label class="item-title" for="product-new">Active This tag?<span class="icon info ms-2" flow="up" tooltip="check this if you want active this tag."><i class="fi-rr-info"> </i></span></label>
<label class="switch text-start">
<input class="switch" id="product-new" name="new" type="checkbox"/><span class="slider"></span>
</label>
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
      // fire tag checkbox function 
      checkboxFunctions();
    </script>
@endpush

