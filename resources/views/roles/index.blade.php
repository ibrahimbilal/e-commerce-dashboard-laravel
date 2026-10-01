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
<h1 class="page-title">roles</h1><a class="add-btn btn text-capitalize" href="{{ route('roles.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">roles</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="roles">
<thead>
<tr>
<th class="text-uppercase">Role title</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
<tr>
<td class="prod-title">Administrator</td>
<td>
<div class="btn-group"><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('roles.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('roles.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="role"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td class="prod-title">Store Manager</td>
<td>
<div class="btn-group"><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('roles.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('roles.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="role"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td class="prod-title">Accountment</td>
<td>
<div class="btn-group"><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('roles.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('roles.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="role"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
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
      let product_table = $('#roles').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{ 
      			bSortable: false, 
      			aTargets: [ 1] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [ 1] 
      		}
      	],
      	order: [
      		[0, 'asc']
      	],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ Roles",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 Roles', '15 Roles', '25 Roles', '50 Roles', '75 Roles', '100 Roles']],
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
    </script>
@endpush

