@extends('admin.layout')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">order statuses</h1>@can('add orders')
<a class="add-btn btn text-capitalize" href="{{ route('admin.order-statuses.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>
<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.orders.index') }}">orders</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">statuses</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" route="admin.order-statuses.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="order-statuses">
<thead>
<tr>
<th class="text-uppercase">title</th>
<th class="text-uppercase">orders</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@foreach ($orderStatuses as $orderStatus)
<tr>
<td class="prod-title">{{ $orderStatus->title }}</td>
<td class="text-center">{{ $orderStatus->orders_count ?? 0 }}</td>
<td>
<x-resource-actions :model="$orderStatus" resource="order-statuses" destroy-label="order status" :show="false" />
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

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#order-statuses').length) {
      $('#order-statuses').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{ bSortable: false, aTargets: [2] },
      		{ bSearchable: false, aTargets: [2] }
      	],
      	order: [[0, 'asc']],
      	language: {
      		emptyTable: 'No order statuses found.',
      		info: "Show _START_ To _END_ Of _TOTAL_ order statuses",
      		buttons: { pageLength: 'Show %d', colvis: 'Columns' }
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[10, 15, 25, 50, 75, 100], ['10 statuses', '15 statuses', '25 statuses', '50 statuses', '75 statuses', '100 statuses']],
      	buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
      		extend: 'collection', text: 'Export', className: 'btn btn-group',
      		buttons: [
      			{ extend: 'excelHtml5', className: 'dropdown-item' },
      			{ extend: 'csvHtml5', className: 'dropdown-item' },
      			{ extend: 'pdfHtml5', className: 'dropdown-item' }
      		]
      	}, 'colvis'] : ['pageLength', {
      		extend: 'collection', text: 'Export', className: 'btn btn-group',
      		buttons: [
      			{ extend: 'excelHtml5', className: 'dropdown-item' },
      			{ extend: 'csvHtml5', className: 'dropdown-item' },
      			{ extend: 'pdfHtml5', className: 'dropdown-item' }
      		]
      	}, 'colvis']
      });
}
</script>
@endpush
