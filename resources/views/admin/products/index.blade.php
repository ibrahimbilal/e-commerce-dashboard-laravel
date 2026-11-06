@extends('admin.layout')

@section('title', __('admin.menu.products.title'))

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">{{ __('admin.menu.products.title') }}</h1>@can('add products')
<a class="add-btn btn text-capitalize" href="{{ route('admin.products.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>{{ __('buttons.add_new') }}</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>{{ __('admin.menu.dashboard.title') }}</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">{{ __('admin.menu.products.title') }}</span>
</div>
</div>
</div>
</div>
</div>
@php
    $productFilterTabs = [
        ['label' => __('admin.filters.all'), 'key' => 'all', 'params' => []],
        ['label' => __('admin.filters.published'), 'key' => 'published', 'params' => ['status' => 'published']],
        ['label' => __('admin.filters.featured'), 'key' => 'featured', 'params' => ['featured' => '1']],
        ['label' => __('admin.filters.new'), 'key' => 'new', 'params' => ['new' => '1']],
        ['label' => __('admin.filters.sale'), 'key' => 'sale', 'params' => ['sale' => '1']],
        ['label' => __('admin.filters.draft'), 'key' => 'draft', 'params' => ['status' => 'draft']],
        ['label' => __('admin.filters.trashed'), 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
@endphp
<div class="row">
<x-index-list-toolbar :showSearch="false"
    :counts="$counts ?? []"
    :filters="$filters ?? []"
    :tabs="$productFilterTabs"
    route="admin.products.index"
/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="products">
<thead>
<tr>
<th></th>
<th class="text-uppercase">{{ __('tables.columns.image') }}</th>
<th class="text-uppercase">{{ __('tables.columns.product_name') }}</th>
<th class="text-uppercase">{{ __('tables.columns.sku') }}</th>
<th class="text-uppercase">{{ __('tables.columns.price') }}</th>
<th class="text-uppercase">{{ __('tables.columns.status') }}</th>
<th class="text-uppercase text-center">{{ __('tables.columns.featured') }}</th>
<th class="text-uppercase text-center">{{ __('tables.columns.new') }}</th>
<th class="text-uppercase">{{ __('tables.columns.published_date') }}</th>
<th class="text-uppercase">{{ __('tables.columns.action') }}</th>
</tr>
</thead>
<tbody>
@foreach ($products as $product)
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
@can('edit products')
<input class="switch admin-field-toggle" type="checkbox" data-toggle-url="{{ route('admin.products.toggle', $product) }}" data-toggle-field="featured" @checked($product->featured)/>
@else
<input class="switch" type="checkbox" disabled @checked($product->featured)/>
@endcan
<span class="slider"></span>
</label>
</td>
<td class="text-center">
<label class="switch">
@can('edit products')
<input class="switch admin-field-toggle" type="checkbox" data-toggle-url="{{ route('admin.products.toggle', $product) }}" data-toggle-field="new" @checked($product->new)/>
@else
<input class="switch" type="checkbox" disabled @checked($product->new)/>
@endcan
<span class="slider"></span>
</label>
</td>
<td data-order="{{ ($product->created_at?->getTimestamp() ?? 0) * 100000 + (int) $product->id }}">{{ $product->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<x-resource-actions :model="$product" resource="products" destroy-label="product" :show="false" />
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('stylesheet')
@endpush

@push('scripts')
    @include('components.admin.datatables-assets')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#products').length) {
      // Data Tables
      let product_table = $('#products').DataTable({
      	layout: (window.resolveAdminDataTableLayout && window.resolveAdminDataTableLayout()) || { topStart: 'buttons', topEnd: 'search', bottomStart: 'info', bottomEnd: 'paging' },
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			orderable: false, 
      			targets: [0, 1, 5, 6, 7, 9] 
      		},
      		{ 
      			searchable: false, 
      			targets: [0, 1, 5, 6, 7, 9 ] 
      		},
      		{
      			targets: 8,
      			type: 'num',
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
      		emptyTable: "{{ __('tables.empty.products') }}",
      		zeroRecords: "{{ __('tables.zeroRecords') }}",
      		info: "{{ __('tables.words.show') }} _START_ {{ __('tables.words.to') }} _END_ {{ __('tables.words.of') }} _TOTAL_ {{ __('tables.words.products') }}",
      		search: "{{ __('tables.words.search') }}",
      		buttons: {
      			pageLength: "{{ __('tables.words.show') }} %d {{ __('tables.words.products') }}",
      			colvis: "{{ __('tables.words.colvis') }}",
      			print: "{{ __('tables.words.print') }}",
      		},
      		paginate: {
      			first: "{{ __('tables.buttons.first') }}",
      			previous: "{{ __('tables.buttons.prev') }}",
      			next: "{{ __('tables.buttons.next') }}",
      			last: "{{ __('tables.buttons.last') }}"
      		},
      		select: {
      			rows: {
      				_: "%d {{ __('tables.words.row_selected') }}"
      			},
      		}
      	}
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 25, 50, 75, 100 ], ['10 {{ __('tables.words.products') }}', '25 {{ __('tables.words.products') }}', '50 {{ __('tables.words.products') }}', '75 {{ __('tables.words.products') }}', '100 {{ __('tables.words.products') }}']],
      	buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
      		extend: 'collection',
      		text: "{{ __('tables.words.export') }}",
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
      		text: "{{ __('tables.words.export') }}",
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
    
}
</script>
@endpush
