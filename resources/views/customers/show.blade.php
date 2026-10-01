@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">view customer</h1><a class="add-btn btn text-capitalize" href="{{ route('customers.create') }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit <span class="page">customer<span></span></span></a>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('customers.index') }}">customers</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">view</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<div class="main-box box-spaces">
<div class="row">
<div class="col-sm-12 col-lg-3 d-flex justify-content-center user-holder">
<div class="profile-image text-center"><img src="{{ $customer->profile_picture ? asset($customer->profile_picture) : asset('assets/images/avatar-placeholder.svg') }}" alt=""/></div>
</div>
<div class="col-sm-12 col-lg-9">
<div class="profile-details row mt-3 mt-lg-0">
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>First Name:</b></div><span class="ms-2">Mildred</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Last Name:</b></div><span class="ms-2">Stoddard</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Email Address:</b></div><span class="ms-2">m.stoddard@gmail.com</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Registered At:</b></div><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Updated At:</b></div><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Last Logged In:</b></div><span class="ms-2">26/03/2021 14:58</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Device:</b></div><span class="ms-2">Samsung Galaxy S20</span>
</div>
</div>
<div class="col-sm-6">
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Birth Of Date:</b></div><span class="ms-2">26/03/2021</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Mobile:</b></div><span class="ms-2">516-913-8323</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>Gender:</b></div><span class="ms-2">Female</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>iP Address:</b></div><span class="ms-2">216.58.217.164</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>iP Country:</b></div><span class="ms-2">United State</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<div class="title"><b>iP City:</b></div><span class="ms-2">New York</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-12 col-lg-5">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize mb-3">Addresses </h2>
<div class="repeater-holder">
<div class="repeater">
<div class="repeater-title p-3 d-flex justify-content-between align-items-center">
<h3 class="h6 mb-0">First Address Title</h3>
<div class="icons d-flex align-items-center"><span class="icon active"><i class="fi-rr-angle-small-down"> </i></span></div>
</div>
<div class="repeater-inputs active">
<table class="table mb-0">
<tbody>
<tr>
<td class="text-capitalize">Country:</td>
<td class="text-capitalize">United State</td>
</tr>
<tr>
<td class="text-capitalize">State:</td>
<td class="text-capitalize">New York</td>
</tr>
<tr>
<td class="text-capitalize">City:</td>
<td class="text-capitalize">New York City</td>
</tr>
<tr>
<td class="text-capitalize">Address 1:</td>
<td class="text-capitalize">1881  Rosewood Lane</td>
</tr>
<tr>
<td class="text-capitalize">Address 2:</td>
<td class="text-capitalize"></td>
</tr>
<tr>
<td class="text-capitalize">Postal Code:</td>
<td class="text-capitalize">10011</td>
</tr>
<tr>
<td class="text-capitalize">Mobile:</td>
<td class="text-capitalize">212-915-2541</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="col-12 col-lg-7">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize mb-3">Orders </h2>
<div class="table-holder">
<div class="table-responsive">
<table class="table table-striped" id="example">
<thead>
<tr>
<th class="text-uppercase">Order</th>
<th class="text-uppercase">status</th>
<th class="text-uppercase">Amount</th>
<th class="text-uppercase">destination</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
<tr>
<td>#00001</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00002</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00003</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00004</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00005</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00006</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00007</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00008</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00009</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00010</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00011</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00012</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00013</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00014</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00015</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00016</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00017</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00018</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00019</td>
<td class="status success text-uppercase">moving</td>
<td class="text-capitalize text-center">500$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00020</td>
<td class="status warning">Pending</td>
<td class="text-capitalize text-center">900$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
</td>
</tr>
<tr>
<td>#00021</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize text-center">705$</td>
<td>14:58 26/03/2021</td>
<td>
<div class="btn-group"><a class="btn btn-primary btn-rounded me-2 py-1"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a></div>
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
<script>
      // Data Tables.
      $('#example').DataTable({
      	dom: 'Bfrtip',
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ Orders",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 5, 10, 15, 20 ], ['5 Orders', '10 Orders', '15 Orders', '20 Orders']],
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

