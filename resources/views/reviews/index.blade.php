@extends('layouts.app')

@section('title', 'E-Commerce Project')

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">Reviews</h1>
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">reviews</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 d-flex align-items-sm-center flex-column flex-sm-row mb-2">
<div class="dash-filters"><a class="item text-capitalize" href="#">All (110)</a><a class="item text-capitalize" href="#">1 Star (20)</a><a class="item text-capitalize" href="#">2 Star (20)</a><a class="item text-capitalize" href="#">3 Star (20)</a><a class="item text-capitalize" href="#">4 Star (20)</a><a class="item text-capitalize" href="#">5 Star (20)</a><a class="item text-capitalize" href="#">Trashed (10)</a>
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
<table class="table table-striped" id="reviews">
<thead>
<tr>
<th></th>
<th class="text-uppercase">customer name</th>
<th class="text-uppercase">rate stars</th>
<th class="text-uppercase">comment</th>
<th class="text-uppercase">product</th>
<th class="text-uppercase">created date</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($reviews as $review)
@php
    $customerName = trim(($review->customer->first_name ?? '') . ' ' . ($review->customer->last_name ?? '')) ?: '—';
    $productName = $review->product?->locales->first()?->name ?? '—';
@endphp
<tr>
<td></td>
<td class="text-capitalize">{{ $customerName }}</td>
<td class="stars-wrapper">
<div class="main-stars">@for ($i = 1; $i <= 5; $i++)<span class="star"><i class="fi-rr-star"> </i></span>@endfor</div>
<div class="cust-stars">@for ($i = 1; $i <= ($review->rate ?? 0); $i++)<span class="star"><i class="fi-sr-star"> </i></span>@endfor</div>
</td>
<td class="text-capitalize comment">{{ \Illuminate\Support\Str::limit($review->comment ?? '—', 80) }}</td>
<td class="text-capitalize">{{ $productName }}</td>
<td class="text-uppercase">{{ $review->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<div class="btn-group">
<a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('reviews.show', $review) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a>
<form method="POST" action="{{ route('reviews.destroy', $review) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="review"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form>
</div>
</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">No reviews found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<x-pagination :paginator="$reviews" />
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
      // Data Tables
      let product_table = $('#reviews').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [0, 2, 6] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [0, 2, 6] 
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
      		info: "Show _START_ To _END_ Of _TOTAL_ reviews",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 reviews', '15 reviews', '25 reviews', '50 reviews', '75 reviews', '100 reviews']],
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

