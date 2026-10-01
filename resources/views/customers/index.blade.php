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
<h1 class="page-title">customers</h1><a class="add-btn btn text-capitalize" href="{{ route('customers.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">customers</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-between flex-column flex-sm-row mb-2">
<div class="dash-filters"><a class="item text-capitalize" href="#">Registered (50)</a><a class="item text-capitalize" href="#">Trashed (99)</a>
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
<table class="table table-striped" id="customers">
<thead>
<tr>
<th></th>
<th class="text-uppercase">image</th>
<th class="text-uppercase">customer name</th>
<th class="text-uppercase">email</th>
<th class="text-uppercase">mobile</th>
<th class="text-uppercase">registered date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Jayson Hinrichsen</td>
<td>example1@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Arezou Firouzeh</td>
<td>example2@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Hossein Roghayeh</td>
<td>example3@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Soraya Siavash</td>
<td>example4@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-5.png') }}" width="70"/></div>
</td>
<td class="prod-title">Gemma Chua-Tran</td>
<td>example5@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Jayson Hinrichsen</td>
<td>example1@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Arezou Firouzeh</td>
<td>example2@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Hossein Roghayeh</td>
<td>example3@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Soraya Siavash</td>
<td>example4@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-5.png') }}" width="70"/></div>
</td>
<td class="prod-title">Gemma Chua-Tran</td>
<td>example5@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-1.png') }}" width="70"/></div>
</td>
<td class="prod-title">Jayson Hinrichsen</td>
<td>example1@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-2.png') }}" width="70"/></div>
</td>
<td class="prod-title">Arezou Firouzeh</td>
<td>example2@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-3.png') }}" width="70"/></div>
</td>
<td class="prod-title">Hossein Roghayeh</td>
<td>example3@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-4.png') }}" width="70"/></div>
</td>
<td class="prod-title">Soraya Siavash</td>
<td>example4@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
</td>
</tr>
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ asset('assets/images/customers/image-5.png') }}" width="70"/></div>
</td>
<td class="prod-title">Gemma Chua-Tran</td>
<td>example5@email.com</td>
<td>09212 34 343455</td>
<td>14:58 26/03/2022</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('customers.show', 1) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a><a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('customers.edit', 1) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a><form method="POST" action="{{ route('customers.destroy', 1) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="customer"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form></div>
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
      let customer_table = $('#customers').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [0, 1, 3, 4, 6] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [0, 1, 6] 
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[5, 'desc']
      	],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ customers",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 25, 50, 75, 100 ], ['10 customers', '25 customers', '50 customers', '75 customers', '100 customers']],
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
      customer_table.on("click", "th.select-checkbox", function() {
      	if ($("th.select-checkbox").hasClass("selected")) {
      		customer_table.rows().deselect();
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		customer_table.rows().select();
      		$("th.select-checkbox").addClass("selected");
      	}
      }).on("select deselect", function() {
      	("Some selection or deselection going on")
      	if (customer_table.rows({
      			selected: true
      		}).count() !== customer_table.rows().count()) {
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		$("th.select-checkbox").addClass("selected");
      	}
      });
    </script>
@endpush

