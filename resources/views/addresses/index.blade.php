@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">
<h1 class="page-title text-capitalize">addresses</h1>
@can('add addresses')
<a class="add-btn btn text-capitalize" href="{{ route('addresses.create') }}"><span class="icon"><i class="fi-rr-plus"> </i></span>add</a>
@endcan
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" route="addresses.index"/>
<div class="col-12">
<div class="main-box box-spaces">
<div class="table-responsive">
<table class="table table-striped" id="addresses">
<thead>
<tr>
<th class="text-uppercase">customer</th>
<th class="text-uppercase">title</th>
<th class="text-uppercase">city</th>
<th class="text-uppercase">country</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($addresses as $address)
@php
    $cust = $address->customer;
    $custLabel = $cust ? trim(($cust->first_name ?? '').' '.($cust->last_name ?? '')) : '—';
@endphp
<tr>
<td>{{ $custLabel ?: '—' }}</td>
<td>{{ $address->address_title ?? '—' }}</td>
<td>{{ $address->city ?? '—' }}</td>
<td>{{ $address->country ?? '—' }}</td>
<td>
<a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('addresses.show', $address) }}">view</a>
<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('addresses.edit', $address) }}">edit</a>
<form method="POST" action="{{ route('addresses.destroy', $address) }}" class="d-inline destroy-resource-form">@csrf @method('DELETE')
<button type="button" class="btn btn-danger btn-rounded py-1 js-destroy-submit" data-confirm-label="address">trash</button></form>
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No addresses found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#addresses').length) {
      $('#addresses').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{ bSortable: false, aTargets: [4] },
      		{ bSearchable: false, aTargets: [4] }
      	],
      	order: [[0, 'asc']],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ addresses",
      		buttons: { pageLength: 'Show %d', colvis: 'Columns' }
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[10, 15, 25, 50, 75, 100], ['10 addresses', '15 addresses', '25 addresses', '50 addresses', '75 addresses', '100 addresses']],
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
