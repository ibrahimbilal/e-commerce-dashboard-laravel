@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/apexcharts.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="slider-holder">

<div class="swiper-container">
<div class="swiper-wrapper">
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="mauve"><i class="fi-rr-users"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">6998</p>
<p class="text-start m-0">Customers</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="green"><i class="fi-rr-box"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">43.6K</p>
<p class="text-start m-0">Orders</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="red"><i class="fi-rr-dollar"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">958.6K</p>
<p class="text-start m-0">Sales</p>
</div>
</div>
<div class="swiper-slide main-box box-spaces d-flex justify-content-between align-items-center">
<div class="icon-holder"><span class="orange"><i class="fi-rr-paper-plane"> </i></span></div>
<div class="detail-holder">
<p class="text-start m-0">60.7K</p>
<p class="text-start m-0">Subscribers</p>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 col-xxl-8">
<div class="main-box box-spaces">
<div id="chart"></div>
</div>
</div>
<div class="col-12 col-sm-6 col-xxl-4">
<div class="main-box box-spaces">
<h2 class="box-title text-capitalize">Top Selling Products</h2>
<div class="list-holder">
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="product 1" src="{{ asset('assets/images/products/image-1.png') }}"/></div>
<div class="title text-start w-100 ps-4">Apple Watch Series 4 GPS</div>
<div class="price">$399</div>
</div>
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="product 2" src="{{ asset('assets/images/products/image-2.png') }}"/></div>
<div class="title text-start w-100 ps-4">Beats Headphones</div>
<div class="price">$459</div>
</div>
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="product 2" src="{{ asset('assets/images/products/image-3.png') }}"/></div>
<div class="title text-start w-100 ps-4">Apple iPad Pro 64GB</div>
<div class="price">$899</div>
</div>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-xxl-4">
<div class="main-box box-spaces">
<div class="box-header d-flex align-items-center justify-content-between flex-row-reverse">
<div class="select-holder">
<select class="select">
<option value="7">Last 7 Days</option>
<option value="14">Last 14 Days</option>
<option value="30">Last 30 Days</option>
</select>
</div>
<h2 class="box-title text-capitalize">Visitors Referrals</h2>
</div>
<div class="list-holder">
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="facebook" src="{{ asset('assets/images/social/facebook.png') }}"/></div>
<div class="title text-start w-100 ps-4">Facebook - 52%</div>
<div class="percent good">20%<i class="fi-sr-arrow-small-up"> </i>
</div>
</div>
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="google" src="{{ asset('assets/images/social/google.png') }}"/></div>
<div class="title text-start w-100 ps-4">Google - 34.6%</div>
<div class="percent good">14%<i class="fi-sr-arrow-small-up"> </i>
</div>
</div>
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="instagram" src="{{ asset('assets/images/social/instagram.png') }}"/></div>
<div class="title text-start w-100 ps-4">Instagram - 9.7%</div>
<div class="percent good">33%<i class="fi-sr-arrow-small-up"> </i>
</div>
</div>
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="snapchat" src="{{ asset('assets/images/social/snapchat.png') }}"/></div>
<div class="title text-start w-100 ps-4">Snapchat - 2.58%</div>
<div class="percent good">6%<i class="fi-sr-arrow-small-up"> </i>
</div>
</div>
<div class="list-item d-flex align-items-center justify-content-between">
<div class="img"><img alt="Others" src="{{ asset('assets/images/social/random.png') }}"/></div>
<div class="title text-start w-100 ps-4">Others - 1.12%</div>
<div class="percent bad">-50%<i class="fi-sr-arrow-small-down"> </i>
</div>
</div>
</div>
</div>
</div>
<div class="col-12 col-xxl-8">
<div class="main-box box-spaces mb-0">
<h2 class="box-title text-capitalize">Orders Statuses </h2>
<div class="table-holder">
<div class="table-responsive">
<table class="table table-striped" id="example">
<thead>
<tr>
<th class="text-uppercase">Order</th>
<th class="text-uppercase">status</th>
<th class="text-uppercase">customer</th>
<th class="text-uppercase">start date</th>
<th class="text-uppercase">destination</th>
</tr>
</thead>
<tbody>
<tr>
<td>#00001</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00002</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00003</td>
<td class="status danger">Canceled</td>
<td>Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td>Florence, Alabama</td>
</tr>
<tr>
<td>#00004</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00005</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00006</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize">Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Florence, Alabama</td>
</tr>
<tr>
<td>#00007</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00008</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00009</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize">Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Florence, Alabama</td>
</tr>
<tr>
<td>#00010</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00011</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00012</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize">Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Florence, Alabama</td>
</tr>
<tr>
<td>#00013</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00014</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00015</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize">Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Florence, Alabama</td>
</tr>
<tr>
<td>#00016</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00017</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00018</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize">Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Florence, Alabama</td>
</tr>
<tr>
<td>#00019</td>
<td class="status success">Moving</td>
<td class="text-capitalize">Leighton Murray</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Anniston, Alabama</td>
</tr>
<tr>
<td>#00020</td>
<td class="status warning">Pending</td>
<td class="text-capitalize">Harvie Hassan</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Cordova, Alaska</td>
</tr>
<tr>
<td>#00021</td>
<td class="status danger">Canceled</td>
<td class="text-capitalize">Marwan Mcpherson</td>
<td>14:58 26/03/2021</td>
<td class="text-capitalize">Florence, Alabama</td>
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
<script src="{{ asset('assets/js/apexcharts.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/charts.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
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

