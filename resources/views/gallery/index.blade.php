@extends('layouts.app')

@section('title', 'Gallery')

@push('styles')
<link href="{{ asset('assets/css/filepond/filepond.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/filepond/filepond-plugin-image-preview.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
@php
    $galleries = $galleries ?? collect();
    $selectedGallery = $selectedGallery ?? null;
    $indexQuery = request()->only(['search', 'trashed', 'page']);
@endphp
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

<div class="gallery-page">
@can('add gallery')
<div class="upload-holder mb-3">
<form action="{{ route('gallery.store') }}" enctype="multipart/form-data" id="upload-form" method="post"></form>
</div>
@endcan

<div class="row">
<x-soft-delete-index-toolbar :counts="$counts ?? []" :filters="$filters ?? []" route="gallery.index"/>
<div class="col-sm-12 col-lg-9 float-start post-box order-1 open">
<div class="g-holder main-box box-spaces d-flex flex-column mb-0">
<div class="images mt-3">
<ul class="list-unstyled images-list row g-2">
@forelse ($galleries as $gallery)
<li class="img-item col-6 col-md-4 col-lg-3">
<a class="d-block text-decoration-none" href="{{ route('gallery.index', array_merge($indexQuery, ['selected' => $gallery->id])) }}">
<x-gallery-thumbnail :gallery="$gallery" class="img-fluid w-100 @if($selectedGallery?->id === $gallery->id) border border-primary @endif"/>
</a>
@can('delete gallery')
<form method="POST" action="{{ route('gallery.destroy', $gallery) }}" class="destroy-resource-form mt-2">
@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-sm js-destroy-submit" data-confirm-label="image">Delete</button>
</form>
@endcan
</li>
@empty
<li class="col-12"><p class="text-center text-muted py-4 mb-0">No gallery items yet.</p></li>
@endforelse
</ul>
</div>
@if (is_object($galleries) && method_exists($galleries, 'hasPages') && $galleries->hasPages())
<x-pagination :paginator="$galleries" />
@endif
</div>
</div>

<div class="col-sm-12 col-lg-3 float-end meta-box order-lg-1 @if($selectedGallery) open @else hide @endif">
@if ($selectedGallery)
<div class="main-box box-spaces">
<div class="row">
<div class="col-12 d-flex justify-content-center align-items-center mb-3">
<div class="img-view text-center w-100"><x-gallery-thumbnail :gallery="$selectedGallery" class="img-fluid"/></div>
</div>
<div class="col-12">
@can('edit gallery')
<form method="POST" action="{{ route('gallery.update', $selectedGallery) }}" id="edit-image-gallery">
@csrf
@method('PUT')
<table class="mt-2 w-100">
<tbody>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">File Name:</label></div></td>
<td class="py-2"><div class="form-item second"><span class="ps-2">{{ basename($selectedGallery->url ?? '') ?: '—' }}</span></div></td>
</tr>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">updated date:</label></div></td>
<td class="py-2"><div class="form-item second"><span class="ps-2">{{ $selectedGallery->updated_at?->format('H:i d/m/Y') ?? '—' }}</span></div></td>
</tr>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">Image Title:</label></div></td>
<td class="py-2"><div class="form-item second"><input class="form-control ps-2" name="title" value="{{ old('title', $selectedGallery->title) }}"/></div></td>
</tr>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">Alt Text:</label></div></td>
<td class="py-2"><div class="form-item second"><input class="form-control ps-2" name="alt" value="{{ old('alt', $selectedGallery->alt) }}"/></div></td>
</tr>
</tbody>
</table>
<div class="btns-holder d-flex justify-content-between mt-4">
@can('delete gallery')
<button class="btn trans-btn text-start" type="button" onclick="document.getElementById('gallery-delete-{{ $selectedGallery->id }}').querySelector('.js-destroy-submit').click()"><span class="icon me-1"><i class="fi-rr-trash"> </i></span>move to trash</button>
@endcan
<button class="btn solid-btn" type="submit">save </button>
</div>
</form>
@else
<table class="mt-2 w-100">
<tbody>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">File Name:</label></div></td>
<td class="py-2"><div class="form-item second"><span class="ps-2">{{ basename($selectedGallery->url ?? '') ?: '—' }}</span></div></td>
</tr>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">updated date:</label></div></td>
<td class="py-2"><div class="form-item second"><span class="ps-2">{{ $selectedGallery->updated_at?->format('H:i d/m/Y') ?? '—' }}</span></div></td>
</tr>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">Image Title:</label></div></td>
<td class="py-2"><div class="form-item second"><span class="ps-2">{{ $selectedGallery->title ?: '—' }}</span></div></td>
</tr>
<tr>
<td class="py-2"><div class="form-item second"><label class="item-title meta-title">Alt Text:</label></div></td>
<td class="py-2"><div class="form-item second"><span class="ps-2">{{ $selectedGallery->alt ?: '—' }}</span></div></td>
</tr>
</tbody>
</table>
@endcan
@can('delete gallery')
<form method="POST" action="{{ route('gallery.destroy', $selectedGallery) }}" id="gallery-delete-{{ $selectedGallery->id }}" class="destroy-resource-form d-none">
@csrf
@method('DELETE')
<button type="button" class="js-destroy-submit" data-confirm-label="image"></button>
</form>
@endcan
</div>
</div>
</div>
@endif
</div>
</div>
</div>
@endsection

@push('scripts')
@can('add gallery')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond-plugin-image-preview.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-size.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond-plugin-file-validate-type.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/filepond/filepond.jquery.js') }}" type="text/javascript"></script>
<script>
if (typeof $.fn.filepond !== 'undefined' && document.getElementById('upload-form')) {
  $.fn.filepond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType
  );
  $('#upload-form').filepond({
    allowFileSizeValidation: true,
    allowFileTypeValidation: true,
    allowMultiple: true,
    allowReorder: true,
    maxFileSize: '10MB',
    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
    server: {
      process: {
        url: @json(route('gallery.store')),
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': @json(csrf_token()),
          'Accept': 'application/json',
        },
        onload: function () { window.location.reload(); },
        onerror: function () { return 'Upload failed'; },
      },
    },
  });
}
</script>
@endcan
@endpush
