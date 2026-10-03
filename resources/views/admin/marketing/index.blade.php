@extends('admin.layout')

@section('title', 'Marketing')

@push('styles')
<link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<x-flash-messages />
@php
    $marketingFilterTabs = [
        ['label' => 'All', 'key' => 'all', 'params' => []],
        ['label' => 'Subscribers', 'key' => 'subscribers', 'params' => ['subscribers' => '1']],
        ['label' => 'Not subscribers', 'key' => 'not_subscribers', 'params' => ['subscribers' => '0']],
    ];
    $showActions = auth()->user()?->can('edit marketing') || auth()->user()?->can('delete marketing');
@endphp
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">marketings</h1>
@can('add marketing')
<button class="add-btn btn text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#add-subscriber-panel" aria-expanded="false"><span class="icon"><i class="fi-rr-add"> </i></span>add new</button>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">marketing</span>
</div>
</div>
</div>
</div>
</div>

@can('add marketing')
<div class="collapse mb-3" id="add-subscriber-panel">
<div class="main-box box-spaces">
<form method="POST" action="{{ route('admin.marketing.subscribers.store') }}" class="row g-2 align-items-end">
@csrf
<div class="col-md-6">
<label class="item-title meta-title" for="new-subscriber-email">Email</label>
<input class="form-control" id="new-subscriber-email" name="email" type="email" value="{{ old('email') }}" required maxlength="100"/>
</div>
<div class="col-md-auto">
<button class="btn solid-btn" type="submit">Add subscriber</button>
</div>
</form>
</div>
</div>
@endcan

<div class="row">
<div class="col-12 d-flex align-items-sm-center flex-column flex-sm-row mb-2">
<x-filter-tabs :counts="$counts ?? []" :filters="$filters ?? []" :tabs="$marketingFilterTabs" route="admin.marketing.index"/>
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
@if ($showActions)
<th class="text-uppercase">action</th>
@endif
</tr>
</thead>
<tbody>
@foreach ($subscribers ?? [] as $subscriber)
<tr>
<td></td>
<td class="text-capitalize">{{ trim(($subscriber->first_name ?? '').' '.($subscriber->last_name ?? '')) ?: '—' }}</td>
<td class="text-uppercase">{{ $subscriber->email ?? '—' }}</td>
<td class="text-capitalize">{{ $subscriber->country ?? '—' }}</td>
<td class="text-uppercase">{{ $subscriber->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
@if ($showActions)
<td>
<div class="btn-group">
@can('edit marketing')
<button class="btn btn-warning btn-rounded me-2 py-1" type="button" data-bs-toggle="modal" data-bs-target="#edit-subscriber-{{ $subscriber->id }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</button>
@endcan
@can('delete marketing')
<form method="POST" action="{{ route('admin.marketing.subscribers.destroy', $subscriber) }}" class="d-inline destroy-resource-form">
@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="subscriber"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button>
</form>
@endcan
</div>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

@can('edit marketing')
@foreach ($subscribers ?? [] as $subscriber)
<div class="modal fade" id="edit-subscriber-{{ $subscriber->id }}" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="{{ route('admin.marketing.subscribers.update', $subscriber) }}">
@csrf
@method('PUT')
<div class="modal-header">
<h5 class="modal-title text-capitalize">Edit subscriber</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<label class="item-title meta-title" for="edit-email-{{ $subscriber->id }}">Email</label>
<input class="form-control" id="edit-email-{{ $subscriber->id }}" name="email" type="email" value="{{ old('email', $subscriber->email) }}" required maxlength="100"/>
</div>
<div class="modal-footer">
<button type="button" class="btn trans-btn" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn solid-btn">Save</button>
</div>
</form>
</div>
</div>
</div>
@endforeach
@endcan
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#subscribers').length) {
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
      			aTargets: [0{{ $showActions ? ', 5' : '' }}]
      		},
      		{
      			bSearchable: false,
      			aTargets: [0{{ $showActions ? ', 5' : '' }}]
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[{{ $showActions ? 4 : 3 }}, 'desc']
      	],
      	language: {
      		emptyTable: 'No subscribers found.',
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
      			{ extend: 'excelHtml5', className: 'dropdown-item' },
      			{ extend: 'csvHtml5', className: 'dropdown-item' },
      			{ extend: 'pdfHtml5', className: 'dropdown-item' }
      		]
      	}, 'colvis'] : ['pageLength', {
      		extend: 'collection',
      		text: 'Export',
      		className: 'btn btn-group',
      		buttons: [
      			{ extend: 'excelHtml5', className: 'dropdown-item' },
      			{ extend: 'csvHtml5', className: 'dropdown-item' },
      			{ extend: 'pdfHtml5', className: 'dropdown-item' }
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
      	if (product_table.rows({ selected: true }).count() !== product_table.rows().count()) {
      		$("th.select-checkbox").removeClass("selected");
      	} else {
      		$("th.select-checkbox").addClass("selected");
      	}
      });
}
</script>
@endpush
