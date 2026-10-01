@php
    /** @var \Illuminate\Support\Collection<int, \Spatie\Permission\Models\Permission> $permissions */
    $actionColumns = ['view', 'add', 'edit', 'delete', 'restore', 'permanently_delete'];
    $selectedNames = old('permissions', isset($role) ? $role->permissions->pluck('name')->all() : []);

    $matrix = [];
    $standaloneRows = [];

    foreach ($permissions as $permission) {
        $name = $permission->name;
        if (! str_contains($name, ' ')) {
            $standaloneRows[] = $name;

            continue;
        }
        [$action, $section] = explode(' ', $name, 2);
        if (! isset($matrix[$section])) {
            $matrix[$section] = [];
        }
        $matrix[$section][$action] = $name;
    }

    sort($standaloneRows);

    $preferredSectionOrder = [
        'dashboard', 'products', 'attributes', 'reviews', 'categories', 'tags', 'discounts',
        'customers', 'orders', 'invoices', 'analytics', 'marketing', 'users', 'roles',
        'gallery', 'languages', 'general_settings', 'theme_settings', 'store_settings',
        'currencies_settings', 'emails_settings', 'payment_settings',
    ];
    $orderedSections = array_values(array_unique(array_merge(
        array_intersect($preferredSectionOrder, array_keys($matrix)),
        collect(array_keys($matrix))->diff($preferredSectionOrder)->sort()->values()->all()
    )));

    $sectionLabel = fn (string $section) => str($section)->replace('_', ' ')->title()->toString();
@endphp
<div class="table-responsive">
<table class="table mb-0 border-0 spatie-permissions-matrix">
<thead>
<tr class="bg-active">
<td class="border-0 p-3"><strong class="text-capitalize">Section</strong></td>
@foreach ($actionColumns as $action)
<td class="border-0 p-3 text-center">
<div class="text-capitalize small">{{ str_replace('_', ' ', $action) }}</div>
<a class="btn btn-link btn-sm py-0 js-spatie-select-col" data-action="{{ $action }}" href="javascript:void(0)">all</a>
</td>
@endforeach
</tr>
</thead>
<tbody>
@foreach ($orderedSections as $section)
<tr class="bg-active spatie-perm-section-row" data-section="{{ $section }}">
<td class="border-0 p-4">
<div class="d-flex align-items-center justify-content-between gap-2">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>{{ $sectionLabel($section) }}</strong></h3>
<a class="btn btn-link btn-sm py-0 js-spatie-select-row" href="javascript:void(0)">select row</a>
</div>
</td>
@foreach ($actionColumns as $action)
@php($permName = $matrix[$section][$action] ?? null)
<td class="border-0 p-4 text-center">
@if ($permName)
<label class="switch text-start d-inline-block">
<input class="switch role-perm-switch spatie-perm-checkbox" data-action="{{ $action }}" name="permissions[]" type="checkbox" value="{{ $permName }}" @checked(in_array($permName, $selectedNames, true))/><span class="slider"></span>
</label>
@else
<span class="text-muted">—</span>
@endif
</td>
@endforeach
</tr>
@endforeach
@foreach ($standaloneRows as $standalone)
<tr class="bg-active spatie-perm-standalone-row">
<td class="border-0 p-4" colspan="{{ count($actionColumns) + 1 }}">
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
<h3 class="h6 text-capitalize mb-0"><strong>{{ $sectionLabel($standalone) }}</strong></h3>
<label class="switch text-start mb-0">
<input class="switch role-perm-switch" name="permissions[]" type="checkbox" value="{{ $standalone }}" @checked(in_array($standalone, $selectedNames, true))/><span class="slider"></span>
</label>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@once
@push('scripts')
<script>
$(function () {
    $(document).on('click', '.js-spatie-select-row', function (e) {
        e.preventDefault();
        $(this).closest('tr').find('.spatie-perm-checkbox').prop('checked', true);
    });
    $(document).on('click', '.js-spatie-select-col', function (e) {
        e.preventDefault();
        var action = $(this).data('action');
        $('.spatie-perm-checkbox[data-action="' + action + '"]').prop('checked', true);
    });
    $('#role-perms-select-all')?.on('click', function (e) {
        e.preventDefault();
        $('.role-perm-switch').prop('checked', true);
    });
});
</script>
@endpush
@endonce
