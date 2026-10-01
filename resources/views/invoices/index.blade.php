@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex align-items-sm-center">
<h1 class="page-title">invoices</h1>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">invoices</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2">
<div class="dash-filters"><a class="item text-capitalize" href="#">All (50)</a><a class="item text-capitalize" href="#">Trashed (99)</a>
</div>
<div class="bulk-action align-self-end">
<form class="bulk-form">
<select class="bulk-select text-capitalize">
<option value="">bulk action</option>
<option value="edit">edit</option>
<option value="delete">delete</option>
</select>
<button class="btn bulk-submit text-capitalize" type="submit">apply</button>
</form>
</div>
</div>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="invoices">
<thead>
<tr>
<th></th>
<th class="text-uppercase">invoice no</th>
<th class="text-uppercase">customer</th>
<th class="text-uppercase">total Cost</th>
<th class="text-uppercase">created date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
<tr>
<td></td>
<td>#123</td>
<td class="prod-title">Jayson Hinrichsen</td>
<td class="text-center">123$</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('invoices.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('invoices.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('invoices.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="invoice"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td>#1234</td>
<td class="prod-title">Jayson Hinrichsen</td>
<td class="text-center">123$</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('invoices.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('invoices.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('invoices.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="invoice"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td>#12345</td>
<td class="prod-title">Jayson Hinrichsen</td>
<td class="text-center">123$</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('invoices.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('invoices.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('invoices.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="invoice"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
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
      let product_table = $('#invoices').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [ 0, 5] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [ 0, 5] 
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
      		info: "Show _START_ To _END_ Of _TOTAL_ invoices",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 invoices', '15 invoices', '25 invoices', '50 invoices', '75 invoices', '100 invoices']],
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

