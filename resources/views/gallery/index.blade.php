@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
@php
    $galleries = $galleries ?? collect();
    $galleryFilterTabs = [['label' => 'All', 'key' => 'all', 'params' => []]];
    foreach ($counts ?? [] as $tabKey => $tabCount) {
        if (in_array($tabKey, ['all'], true)) {
            continue;
        }
        $paramKey = $tabKey === 'trashed' ? 'trashed' : $tabKey;
        $paramValue = $tabKey === 'trashed' ? '1' : '1';
        $galleryFilterTabs[] = [
            'label' => ucwords(str_replace(['_', '-'], ' ', (string) $tabKey)),
            'key' => $tabKey,
            'params' => [$paramKey => $paramValue],
        ];
    }
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

<div class="row">
<x-index-list-toolbar :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$galleryFilterTabs" route="gallery.index"/>
<div class="col-12">
<div class="main-box box-spaces">
<div class="row g-3">
@forelse ($galleries as $gallery)
<div class="col-6 col-md-4 col-lg-3">
<div class="main-box box-spaces h-100 d-flex flex-column">
<x-gallery-thumbnail :gallery="$gallery" class="img-fluid mb-2"/>
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
<div class="col-12"><p class="text-center text-muted py-4 mb-0">No gallery items yet.</p></div>
@endforelse
</div>
@if (is_object($galleries) && method_exists($galleries, 'hasPages') && $galleries->hasPages())
<x-pagination :paginator="$galleries" />
@endif
</div>
</div>
</div>
@endsection
