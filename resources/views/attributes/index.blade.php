@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">attributes</h1>@can('add attributes')
<a class="add-btn btn text-capitalize" href="{{ route('attributes.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">attributes</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-index-list-toolbar
    :counts="$counts ?? []"
    :filters="$filters ?? []"
    :tabs="[['label' => 'All', 'key' => 'all', 'params' => []]]"
    route="attributes.index"
/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="attributes">
<thead>
<tr>
<th></th>
<th class="text-uppercase">the title</th>
<th class="text-uppercase">slug</th>
<th class="text-uppercase">term</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($attributeList as $attribute)
<tr>
<td></td>
<td class="prod-title">{{ $attribute->attribute_key }}</td>
<td>{{ \Illuminate\Support\Str::slug($attribute->attribute_key) }}</td>
<td>{{ $attribute->attribute_value }}</td>
<td>
<x-resource-actions :model="$attribute" resource="attributes" destroy-label="attribute" :show="false" />
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-4">No attributes found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<x-pagination :paginator="$attributeList" />
</div>
</div>
@endsection


