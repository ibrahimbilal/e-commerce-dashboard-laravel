@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">categorys</h1>@can('add categories')
<a class="add-btn btn text-capitalize" href="{{ route('categories.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">categories</span>
</div>
</div>
</div>
</div>
</div>
@php
    $categoryFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Active', 'key' => 'active', 'params' => ['active' => '1']],
        ['label' => 'Inactive', 'key' => 'inactive', 'params' => ['active' => '0']],
        ['label' => 'Trashed', 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
@endphp
<div class="row">
<x-index-list-toolbar
    :counts="$counts ?? []"
    :filters="$filters ?? []"
    :tabs="$categoryFilterTabs"
    route="categories.index"
/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="categories">
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
@forelse ($categories as $category)
<tr>
<td></td>
<td class="prod-title">{{ $category->parent_id ? '— ' : '' }}{{ $category->title }}</td>
<td class="text-capitalize">{{ $category->description ?? '—' }}</td>
<td>{{ $category->category_slug ?? '—' }}</td>
<td class="text-center">{{ $category->products_count ?? '—' }}</td>
<td class="text-center">
<label class="switch">
<input class="switch" type="checkbox" disabled @checked($category->active)/><span class="slider"></span>
</label>
</td>
<td>
<x-resource-actions :model="$category" resource="categories" destroy-label="category" :show="false" />
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No categories found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<x-pagination :paginator="$categories" />
</div>
</div>
@endsection


