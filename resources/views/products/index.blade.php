@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">products</h1><a class="add-btn btn text-capitalize" href="{{ route('products.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">products</span>
</div>
</div>
</div>
</div>
</div>
@php
    $productFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Published', 'key' => 'published', 'params' => ['status' => 'published']],
        ['label' => 'Draft', 'key' => 'draft', 'params' => ['status' => 'draft']],
        ['label' => 'Trashed', 'key' => 'trashed', 'params' => ['trashed' => '1']],
        ['label' => 'Featured', 'key' => 'featured', 'params' => ['featured' => '1']],
        ['label' => 'New', 'key' => 'new', 'params' => ['new' => '1']],
        ['label' => 'Sale', 'key' => 'sale', 'params' => ['sale' => '1']],
    ];
@endphp
<div class="row">
<x-index-list-toolbar
    :counts="$counts ?? []"
    :filters="$filters ?? []"
    :tabs="$productFilterTabs"
    route="products.index"
/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="products">
<thead>
<tr>
<th></th>
<th class="text-uppercase">image</th>
<th class="text-uppercase">product name</th>
<th class="text-uppercase">sku</th>
<th class="text-uppercase">price</th>
<th class="text-uppercase">status</th>
<th class="text-uppercase text-center">featured</th>
<th class="text-uppercase text-center">new</th>
<th class="text-uppercase">published date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($products as $product)
@php
    $locale = $product->locales->first();
    $productName = $locale?->name ?? '—';
    $price = $product->sale_price ?? $product->regular_price;
@endphp
<tr>
<td></td>
<td class="prod-img">
<div class="img-holder"><img src="{{ $product->product_img ? asset($product->product_img) : asset('assets/images/product-placeholder.svg') }}" width="70" alt=""/></div>
</td>
<td class="prod-title">{{ $productName }}</td>
<td class="text-uppercase">{{ $product->sku }}</td>
<td>@if($price !== null)${{ number_format($price) }}@else—@endif</td>
<td class="text-capitalize">{{ $product->status ?? '—' }}</td>
<td class="text-center">
<label class="switch">
<input class="switch" type="checkbox" disabled @checked($product->featured)/><span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
<input class="switch" type="checkbox" disabled @checked($product->new)/><span class="slider"></span>
</label>
</td>
<td>{{ $product->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<x-resource-actions :model="$product" resource="products" destroy-label="product" :show="false" />
</td>
</tr>
@empty
<tr><td colspan="10" class="text-center text-muted py-4">No products found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
      // Data Tables
      let product_table = $('#products').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [0, 1, 5, 6, 7, 9] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [0, 1, 5, 6, 7, 9 ] 
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[8, 'desc']
      	],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ Products",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 25, 50, 75, 100 ], ['10 Products', '25 Products', '50 Products', '75 Products', '100 Products']],
      	buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
      		extend: 'collection',
      		text: 'Export',
      		className: 'btn btn-group',
      		buttons: [
      			{
      				extend: 'excelHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'csvHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'pdfHtml5',
      				className: 'dropdown-item'
      			}
      		]
      	}, 'colvis'] : ['pageLength', {
      		extend: 'collection',
      		text: 'Export',
      		className: 'btn btn-group',
      		buttons: [
      			{
      				extend: 'excelHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'csvHtml5',
      				className: 'dropdown-item'
      			},
      			{
      				extend: 'pdfHtml5',
      				className: 'dropdown-item'
      			}
      		]
      	}, 'colvis']
      });
      product_table.on("click", "th.select-checkbox", function() {
      	if ($("th.select-checkbox").hasClass("selected")) {
      		product_table.rows().deselect();
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		product_table.rows().select();
      		$("th.select-checkbox").addClass("selected");
      	}
      }).on("select deselect", function() {
      	("Some selection or deselection going on")
      	if (product_table.rows({
      		selected: true
      		}).count() !== product_table.rows().count()) {
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		$("th.select-checkbox").addClass("selected");
      	}
      });
    </script>
@endpush

