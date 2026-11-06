@extends('admin.layout')

@section('title', __('admin.menu.orders.title'))


@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">{{ __('admin.menu.orders.title') }}</h1>@can('add orders')
<a class="add-btn btn text-capitalize" href="{{ route('admin.orders.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>{{ __('buttons.add_new') }}</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>{{ __('admin.menu.dashboard.title') }}</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">{{ __('admin.menu.orders.title') }}</span>
</div>
</div>
</div>
</div>
</div>
@php
    $orderFilterTabs = [
        ['label' => __('admin.filters.all'), 'key' => 'all', 'params' => []],
        ['label' => __('admin.filters.trashed'), 'key' => 'trashed', 'params' => ['trashed' => '1']],
    ];
    foreach ($counts ?? [] as $slug => $number) {
        if (in_array($slug, ['all', 'trashed'], true)) {
            continue;
        }
        $orderFilterTabs[] = [
            'label' => ucwords(str_replace(['_', '-'], ' ', (string) $slug)),
            'key' => $slug,
            'params' => ['status' => $slug],
        ];
    }
@endphp
<div class="row">
<x-index-list-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$orderFilterTabs" route="admin.orders.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="orders">
<thead>
<tr>
<th></th>
<th class="text-uppercase">{{ __('tables.columns.order') }}</th>
<th class="text-uppercase">{{ __('tables.columns.status') }}</th>
<th class="text-uppercase">{{ __('tables.columns.customer') }}</th>
<th class="text-uppercase">{{ __('tables.columns.total_price') }}</th>
<th class="text-uppercase">{{ __('tables.columns.destination') }}</th>
<th class="text-uppercase">{{ __('tables.columns.updated_date') }}</th>
<th class="text-uppercase">{{ __('tables.columns.action') }}</th>
</tr>
</thead>
<tbody>
@foreach ($orders as $order)
@php
    $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: '—';
    $destination = $order->address ? trim(($order->address->city ?? '') . ', ' . ($order->address->state ?? '')) : '—';
@endphp
<tr>
<td></td>
<td class="text-uppercase" data-order="{{ $order->id }}">#{{ $order->id }}</td>
<x-order-status :status="$order->orderStatus" />
<td class="text-capitalize">{{ $customerName }}</td>
<td class="text-uppercase text-center">${{ number_format($order->amount ?? 0) }}</td>
<td class="text-capitalize">{{ $destination }}</td>
<td class="text-uppercase" data-order="{{ $order->updated_at?->getTimestamp() ?? 0 }}">{{ $order->updated_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<x-resource-actions :model="$order" resource="orders" destroy-label="order" />
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
if ($.fn.DataTable && $('#orders').length) {
      // Data Tables
      let product_table = $('#orders').DataTable({
      	layout: (window.resolveAdminDataTableLayout && window.resolveAdminDataTableLayout()) || { topStart: 'buttons', topEnd: 'search', bottomStart: 'info', bottomEnd: 'paging' },
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			orderable: false, 
      			targets: [ 0, 7] 
      		},
      		{ 
      			searchable: false, 
      			targets: [ 0, 7] 
      		},
      		{
      			targets: [1, 6],
      			type: 'num',
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[1, 'desc']
      	],
      	language: {
      		emptyTable: "{{ __('tables.empty.orders') }}",
      		zeroRecords: "{{ __('tables.zeroRecords') }}",
      		info: "{{ __('tables.words.show') }} _START_ {{ __('tables.words.to') }} _END_ {{ __('tables.words.of') }} _TOTAL_ {{ __('tables.words.orders') }}",
      		search: "{{ __('tables.words.search') }}",
      		buttons: {
      			pageLength: "{{ __('tables.words.show') }} %d {{ __('tables.words.orders') }}",
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
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 {{ __('tables.words.orders') }}', '15 {{ __('tables.words.orders') }}', '25 {{ __('tables.words.orders') }}', '50 {{ __('tables.words.orders') }}', '75 {{ __('tables.words.orders') }}', '100 {{ __('tables.words.orders') }}']],
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
