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
<x-index-list-toolbar :counts="$counts ?? []" :filters="$filters ?? []" :tabs="[['label' => 'All', 'key' => 'all', 'params' => []]]" route="roles.index"/>
<div class="col-12">
<div class="main-box box-spaces mb-0">
<div class="table-holder mt-0">
<div class="table-responsive">
<table class="table table-striped" id="roles">
<thead>
<tr>
<th class="text-uppercase">Role name</th>
<th class="text-uppercase text-center">Permissions</th>
<th class="text-uppercase text-center">Users</th>
<th class="text-uppercase">action</th>
</tr>
</thead>
<tbody>
@forelse ($roles as $role)
<tr>
<td class="prod-title">{{ $role->name }}</td>
<td class="text-center">{{ $role->permissions->count() }}</td>
<td class="text-center">{{ $role->users_count }}</td>
<td>
<div class="btn-group">
<a class="btn btn-primary btn-rounded me-2 py-1" href="{{ route('roles.show', $role) }}"><span class="icon"><i class="fi-rr-eye"> </i></span>view</a>
<a class="btn btn-warning btn-rounded me-2 py-1" href="{{ route('roles.edit', $role) }}"><span class="icon"><i class="fi-rr-edit"> </i></span>edit</a>
<form method="POST" action="{{ route('roles.destroy', $role) }}" class="d-inline destroy-resource-form">@csrf
@method('DELETE')
<button type="button" class="btn btn-danger btn-rounded me-2 py-1 js-destroy-submit" data-confirm-label="role"><span class="icon"><i class="fi-rr-trash"> </i></span>trash</button></form>
</div>
</td>
</tr>
@empty
<tr><td colspan="4" class="text-center text-muted py-4">No roles found.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<x-pagination :paginator="$roles" />
</div>
</div>
@endsection

@push('scripts')
<script async="" src="{{ asset('assets/js/async.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
<script>
      let product_table = $('#roles').DataTable({
      	dom: 'Bfrtip',
      	columnDefs: [
      		{ bSortable: false, aTargets: [3] },
      		{ bSearchable: false, aTargets: [3] }
      	],
      	order: [[0, 'asc']],
      	language: {
      		info: "Show _START_ To _END_ Of _TOTAL_ Roles",
      		buttons: { pageLength: 'Show %d', colvis: 'Columns' }
      	},
      	stateSave: true,
      	paging: false,
      	searching: true,
      });
    </script>
@endpush
