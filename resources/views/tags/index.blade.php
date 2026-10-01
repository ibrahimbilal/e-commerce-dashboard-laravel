@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">tags</h1>@can('add tags')
<a class="add-btn btn text-capitalize" href="{{ route('tags.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">tags</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :counts="$counts ?? []" :filters="$filters ?? []" route="tags.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="tags">
<thead>
<tr>
<th></th>
<th class="text-uppercase">the title</th>
<th class="text-uppercase">description</th>
<th class="text-uppercase">slug</th>
<th class="text-uppercase">count</th>
<th class="text-uppercase text-center">active</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($tags as $tag)
<tr>
<td></td>
<td class="prod-title">{{ $tag->title }}</td>
<td class="text-capitalize">{{ $tag->meta_description ?? '—' }}</td>
<td>{{ $tag->tag_slug ?? '—' }}</td>
<td class="text-center">{{ $tag->products->count() }}</td>
<td class="text-center">
<label class="switch">
<input class="switch" type="checkbox" disabled @checked(! $tag->deleted)/><span class="slider"></span>
</label>
</td>
<td>
<x-resource-actions :model="$tag" resource="tags" destroy-label="tag" :show="false" />
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No tags found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection


