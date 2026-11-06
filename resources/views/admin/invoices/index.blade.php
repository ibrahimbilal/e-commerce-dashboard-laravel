@extends('admin.layout')

@section('title', __('admin.menu.invoices.title'))


@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex align-items-sm-center justify-content-between w-100">
<h1 class="page-title">{{ __('admin.menu.invoices.title') }}</h1>
@if (Route::has('invoices.create'))
@can('add invoices')
<a class="add-btn btn text-capitalize" href="{{ route('admin.invoices.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>{{ __('buttons.add_new') }}</a>
@endcan
@endif
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>{{ __('admin.menu.dashboard.title') }}</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">{{ __('admin.menu.invoices.title') }}</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" route="admin.invoices.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="invoices">
<thead>
<tr>
<th></th>
<th class="text-uppercase">{{ __('tables.columns.invoice_no') }}</th>
<th class="text-uppercase">{{ __('tables.columns.customer') }}</th>
<th class="text-uppercase">{{ __('tables.columns.total_cost') }}</th>
<th class="text-uppercase">{{ __('tables.columns.created_date') }}</th>
<th class="text-uppercase">{{ __('tables.columns.action') }}</th>
</tr>
</thead>
<tbody>
@foreach ($invoices as $invoice)
@php
    $cust = $invoice->order?->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '—';
    $total = $invoice->order?->amount;
@endphp
<tr>
<td></td>
<td>#{{ $invoice->invoice_no }}</td>
<td class="prod-title">{{ $custLabel ?: '—' }}</td>
<td class="text-center">@if($total !== null)${{ number_format($total) }}@else—@endif</td>
<td data-order="{{ $invoice->created_at?->getTimestamp() ?? 0 }}">{{ $invoice->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<x-resource-actions :model="$invoice" resource="invoices" destroy-label="invoice" />
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
if ($.fn.DataTable && $('#invoices').length) {
      // Data Tables
      let product_table = $('#invoices').DataTable({
      	layout: window.AdminDataTableLayout || { topStart: 'buttons', topEnd: 'search', bottomStart: 'info', bottomEnd: 'paging' },
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			orderable: false, 
      			targets: [ 0, 5] 
      		},
      		{ 
      			searchable: false, 
      			targets: [ 0, 5] 
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[4, 'desc']
      	],
      	language: {
      		emptyTable: "{{ __('tables.empty.invoices') }}",
      		zeroRecords: "{{ __('tables.zeroRecords') }}",
      		info: "{{ __('tables.words.show') }} _START_ {{ __('tables.words.to') }} _END_ {{ __('tables.words.of') }} _TOTAL_ {{ __('tables.words.invoices') }}",
      		search: "{{ __('tables.words.search') }}",
      		buttons: {
      			pageLength: "{{ __('tables.words.show') }} %d {{ __('tables.words.invoices') }}",
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
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 {{ __('tables.words.invoices') }}', '15 {{ __('tables.words.invoices') }}', '25 {{ __('tables.words.invoices') }}', '50 {{ __('tables.words.invoices') }}', '75 {{ __('tables.words.invoices') }}', '100 {{ __('tables.words.invoices') }}']],
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
