@extends('admin.layout')

@section('title', __('admin.menu.customers.title'))


@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">{{ __('admin.menu.customers.title') }}</h1>@can('add customers')
<a class="add-btn btn text-capitalize" href="{{ route('admin.customers.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>{{ __('buttons.add_new') }}</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>{{ __('admin.menu.dashboard.title') }}</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">{{ __('admin.menu.customers.title') }}</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-soft-delete-index-toolbar :showSearch="false" :counts="$counts ?? []" :filters="$filters ?? []" route="admin.customers.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="customers">
<thead>
<tr>
<th></th>
<th class="text-uppercase">{{ __('tables.columns.image') }}</th>
<th class="text-uppercase">{{ __('tables.columns.customer_name') }}</th>
<th class="text-uppercase">{{ __('tables.columns.email') }}</th>
<th class="text-uppercase">{{ __('tables.columns.mobile') }}</th>
<th class="text-uppercase">{{ __('tables.columns.register_date') }}</th>
<th class="text-uppercase">{{ __('tables.columns.action') }}</th>
</tr>
</thead>
<tbody>
@foreach ($customers as $customer)
<tr>
<td></td>
<td class="customer-img">
<div class="img-holder"><img src="{{ $customer->profile_picture ? asset($customer->profile_picture) : asset('images/avatars/' . ($customer->gender === 'female' ? 'female' : 'male') . '-avatar.png') }}" width="70" alt=""/></div>
</td>
<td class="prod-title">{{ trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: '—' }}</td>
<td>{{ $customer->email }}</td>
<td>{{ $customer->mobile ?? '—' }}</td>
<td data-order="{{ $customer->created_at?->getTimestamp() ?? 0 }}">{{ $customer->created_at?->format('H:i d/m/Y') ?? '—' }}</td>
<td>
<x-resource-actions :model="$customer" resource="customers" destroy-label="customer" />
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

@push('stylesheet')
@endpush

@push('scripts')
    @include('components.admin.datatables-assets')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#customers').length) {
      // Data Tables
      let customer_table = $('#customers').DataTable({
      	layout: (window.resolveAdminDataTableLayout && window.resolveAdminDataTableLayout()) || { topStart: 'buttons', topEnd: 'search', bottomStart: 'info', bottomEnd: 'paging' },
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			orderable: false, 
      			targets: [0, 1, 3, 4, 6] 
      		},
      		{ 
      			searchable: false, 
      			targets: [0, 1, 6] 
      		},
      		{
      			targets: 5,
      			type: 'num',
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
      		emptyTable: "{{ __('tables.empty.customers') }}",
      		zeroRecords: "{{ __('tables.zeroRecords') }}",
      		info: "{{ __('tables.words.show') }} _START_ {{ __('tables.words.to') }} _END_ {{ __('tables.words.of') }} _TOTAL_ {{ __('tables.words.customers') }}",
      		search: "{{ __('tables.words.search') }}",
      		buttons: {
      			pageLength: "{{ __('tables.words.show') }} %d {{ __('tables.words.customers') }}",
      			colvis: "{{ __('tables.words.colvis') }}",
      			print: "{{ __('tables.words.print') }}",
      		},
      		paginate: {
      			first: "{{ __('tables.buttons.first') }}",
      			previous: "{{ __('tables.buttons.prev') }}",
      			next: "{{ __('tables.buttons.next') }}",
      			last: "{{ __('tables.buttons.last') }}"
      		},
      		select: {
      			rows: {
      				_: "%d {{ __('tables.words.row_selected') }}"
      			},
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 25, 50, 75, 100 ], ['10 {{ __('tables.words.customers') }}', '25 {{ __('tables.words.customers') }}', '50 {{ __('tables.words.customers') }}', '75 {{ __('tables.words.customers') }}', '100 {{ __('tables.words.customers') }}']],
      	buttons: ($(window).width() > 578) ? ['pageLength', 'print', {
      		extend: 'collection',
      		text: "{{ __('tables.words.export') }}",
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
      		text: "{{ __('tables.words.export') }}",
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
    
}
</script>
@endpush
