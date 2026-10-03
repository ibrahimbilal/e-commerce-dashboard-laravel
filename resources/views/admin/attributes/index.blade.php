@extends('admin.layout')

@section('title', 'E-Commerce Project')


@section('content')
<x-flash-messages />
<div class="page-header">
<div class="row">
<div class="col-12 d-flex align-items-sm-center justify-content-sm-between flex-column flex-sm-row">

<div class="text-capitalize mb-2 mb-sm-0 d-flex justify-content-between align-items-center">
<h1 class="page-title">attributes</h1>@can('add attributes')
<a class="add-btn btn text-capitalize" href="{{ route('admin.attributes.create') }}"><span class="icon"><i class="fi-rr-add"> </i></span>add new</a>
@endcan
</div>

<div class="page-breadcrumbs d-flex align-items-sm-center justify-content-start justify-content-sm-end">
<div class="breadcrumbs d-flex justify-content-between align-items-center"><a class="item text-capitalize d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}"><span class="icon"><i class="fi-rr-apps"> </i></span>dashboard</a><span class="angle"><span class="icon"><i class="fi-rr-angle-double-right"> </i></span></span><span class="item text-capitalize d-flex justify-content-between align-items-center">attributes</span>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<x-index-list-toolbar :showSearch="false"
    :counts="$counts ?? []"
    :filters="$filters ?? []"
    :tabs="[['label' => 'All', 'key' => 'all', 'params' => []]]"
    route="admin.attributes.index"
/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="attributes">
<thead>
<tr>
<th></th>
<th class="text-uppercase">the title</th>
<th class="text-uppercase">slug</th>
<th class="text-uppercase">term</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@foreach ($attributeList as $attribute)
<tr>
<td></td>
<td class="prod-title">{{ $attribute->attribute_key }}</td>
<td>{{ \Illuminate\Support\Str::slug($attribute->attribute_key) }}</td>
<td>{{ $attribute->attribute_value }}</td>
<td>
<x-resource-actions :model="$attribute" resource="attributes" destroy-label="attribute" :show="false" />
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
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"/>
@endpush

@push('scripts')
<script async="" src="{{ asset('js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
<script>
if ($.fn.DataTable && $('#attributes').length) {
      // Data Tables
      let product_table = $('#attributes').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{
      			orderable: false,
      			className: 'select-checkbox',
      			targets: 0
      		},
      		{ 
      			bSortable: false, 
      			aTargets: [ 0, 4] 
      		},
      		{ 
      			bSearchable: false, 
      			aTargets: [ 0, 3, 4] 
      		}
      	],
      	select: {
      		style: 'os',
      		selector: 'td:first-child'
      	},
      	order: [
      		[1, 'asc']
      	],
      	language: {
      		emptyTable: 'No attributes found.',
      		info: "Show _START_ To _END_ Of _TOTAL_ Attributes",
      		buttons: {
      			pageLength: 'Show %d',
      			colvis: 'Columns'
      		}
      	},
      	stateSave: true,
      	paging: true,
      	searching: true,
      	lengthMenu: [[ 10, 15, 25, 50, 75, 100 ], ['10 Attributes', '15 Attributes', '25 Attributes', '50 Attributes', '75 Attributes', '100 Attributes']],
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
