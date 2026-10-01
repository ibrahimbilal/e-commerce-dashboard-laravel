@extends('layouts.app')

@section('title', 'E-Commerce Project')


@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">orders</h1>@can('add orders')
<a class="add-btn btn text-capitalize" href="{{ route('orders.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">orders</span>
</div>
</div>
</div>
</div>
</div>
@php
    $orderFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Trashed', 'key' => 'trashed', 'params' => ['trashed' => '1']],
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
<x-index-list-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$orderFilterTabs" route="orders.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="orders">
<thead>
<tr>
<th></th>
<th class="text-uppercase">Order</th>
<th class="text-uppercase">status</th>
<th class="text-uppercase">customer</th>
<th class="text-uppercase">total price</th>
<th class="text-uppercase">destination</th>
<th class="text-uppercase">updated date</th>
<th class="text-uppercase">action</th>
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
<td class="text-uppercase">#{{ $order->id }}</td>
<td class="status text-capitalize">{{ $order->orderStatus->title ?? '—' }}</td>
<td class="text-capitalize">{{ $customerName }}</td>
<td class="text-uppercase text-center">${{ number_format($order->amount ?? 0) }}</td>
<td class="text-capitalize">{{ $destination }}</td>
<td class="text-uppercase">{{ $order->updated_at?->format('H:i d/m/Y') ?? '—' }}</td>
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

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#orders').length) {
      // Data Tables
      let product_table = $('#orders').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [ 0, 7] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [ 0, 7] 
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
      		emptyTable: 'No orders found.',
      		info: "Show _START_ To _END_ Of _TOTAL_ Orders",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 Orders', '15 Orders', '25 Orders', '50 Orders', '75 Orders', '100 Orders']],
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
    
}
</script>
@endpush
