@extends('layouts.app')

@section('title', 'E-Commerce Project')

@section('content')
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">Reviews</h1>
@can('add reviews')
<a class="add-btn btn text-capitalize" href="{{ route('reviews.create') }}"><span class="icon"><i class="fi-rr-plus"> </i></span>add review</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">reviews</span>
</div>
</div>
</div>
</div>
</div>
@php
    $reviewFilters = is_array($filters ?? null) ? $filters : [];
    $activeRating = $reviewFilters['rating'] ?? null;
    $reviewQueryBase = static function (array $overrides = []) use ($reviewFilters): array {
        $query = [];
        foreach (['search', 'trashed'] as $key) {
            if (array_key_exists($key, $overrides)) {
                if ($overrides[$key] !== null && $overrides[$key] !== '') {
                    $query[$key] = $overrides[$key];
                }
            } elseif (! empty($reviewFilters[$key])) {
                $query[$key] = $reviewFilters[$key];
            }
        }
        if (array_key_exists('rating', $overrides)) {
            if ($overrides['rating'] !== null && $overrides['rating'] !== '') {
                $query['rating'] = $overrides['rating'];
            }
        }

        return $query;
    };
    $reviewCounts = is_array($counts ?? null) ? $counts : [];
@endphp
<div class="row">
<div class="col-12 d-flex align-items-sm-center flex-column flex-sm-row mb-2">
<div class="dash-filters">
<a class="item text-capitalize @if($activeRating === null || $activeRating === '') active @endif" href="{{ route('reviews.index', $reviewQueryBase(['rating' => null])) }}">All{{ array_key_exists('all', $reviewCounts) ? ' ('.$reviewCounts['all'].')' : '' }}</a>
@for ($star = 1; $star <= 5; $star++)
<a class="item text-capitalize @if((string) $activeRating === (string) $star) active @endif" href="{{ route('reviews.index', $reviewQueryBase(['rating' => (string) $star])) }}">{{ $star }} Star{{ array_key_exists('star_'.$star, $reviewCounts) ? ' ('.$reviewCounts['star_'.$star].')' : '' }}</a>
@endfor
</div>
</div>
<x-soft-delete-index-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" route="reviews.index"/>
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
@foreach ($reviews as $review)
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
<x-resource-actions :model="$review" resource="reviews" destroy-label="review" />
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

@push('styles')
<link href="{{ asset('assets/css/uicons-solid-rounded.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#reviews').length) {
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
      		emptyTable: 'No reviews found.',
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
    
}
</script>
@endpush
