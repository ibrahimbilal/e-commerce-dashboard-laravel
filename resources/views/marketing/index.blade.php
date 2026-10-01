@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pickadate.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">marketings</h1><a class="add-btn btn text-capitalize" href="./add-marketing.html"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">marketing</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center flex-column flex-sm-row mb-2">
<div class="dash-filters"><a class="item text-capitalize" href="#">All (110)</a><a class="item text-capitalize" href="#">Subscribers (90)</a><a class="item text-capitalize" href="#">Not Subscribers (20)</a>
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
<div class="main-box box-spaces">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="subscribers">
<thead>
<tr>
<th></th>
<th class="text-uppercase">name</th>
<th class="text-uppercase">email</th>
<th class="text-uppercase">country</th>
<th class="text-uppercase">created date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
</tr>
<tr>
<td></td>
<td class="text-capitalize">Jayson Hinrichsen</td>
<td class="text-uppercase">email@example.com</td>
<td class="text-capitalize">United State</td>
<td class="text-uppercase">14:58 26/03/2021</td>
<td class="text-muted">—</td>
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
<script src="{{ asset('assets/js/pickadate/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pickadate/picker.date.js') }}" type="text/javascript"></script>
<script>
      // Data Tables
      let product_table = $('#subscribers').DataTable({
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
      		[1, 'desc']
      	],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ subscribers",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 subscribers', '15 subscribers', '25 subscribers', '50 subscribers', '75 subscribers', '100 subscribers']],
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

