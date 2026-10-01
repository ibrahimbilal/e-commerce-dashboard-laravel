@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0">
<h1 class="page-title">gallery</h1>
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"></i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"></i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">gallery</span>
</div>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<p class="text-muted mb-3">Upload and manage media from this page once the gallery API is wired. Individual deletes can use <code>gallery.destroy</code>.</p>
<div class="row g-3">
@forelse ($galleries ?? [] as $gallery)
<div class="col-6 col-md-4 col-lg-3">
<div class="main-box box-spaces h-100 d-flex flex-column">
@if (! empty($gallery->url))
<img src="{{ asset('storage/'.$gallery->url) }}" alt="" class="img-fluid mb-2"/>
@else
<img src="{{ asset('assets/images/product-placeholder.svg') }}" alt="" class="img-fluid mb-2"/>
@endif
<div class="mt-auto">
@if (Route::has('gallery.destroy'))
<form method="POST" action="{{ route('gallery.destroy', $gallery) }}" class="destroy-resource-form">
@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-sm js-destroy-submit" data-confirm-label="image">Delete</button>
</form>
@endif
</div>
</div>
</div>
@empty
<div class="col-12"><p class="text-center text-muted py-4 mb-0">No gallery items yet. Backend should pass <code>$galleries</code> (paginated) and an upload endpoint.</p></div>
@endforelse
</div>
@if (isset($galleries) && method_exists($galleries, 'hasPages'))
<x-pagination :paginator="$galleries" />
@endif
</div>
</div>
</div>
@endsection
