@php
    $rolePermissions = isset($role) && filled($role->permissions ?? null)
        ? array_values(array_filter(array_map('trim', explode(',', (string) $role->permissions))))
        : [];

    $selectedPermissions = old('permissions', $rolePermissions);
    if (! is_array($selectedPermissions)) {
        $selectedPermissions = array_values(array_filter(array_map('trim', explode(',', (string) $selectedPermissions))));
    }

    $permissionCatalog = [
        ['label' => 'Products', 'prefix' => 'prod'],
        ['label' => 'Attributes', 'prefix' => 'attr'],
        ['label' => 'reviews', 'prefix' => 'rev'],
        ['label' => 'Categories', 'prefix' => 'cat'],
        ['label' => 'Tags', 'prefix' => 'tag'],
        ['label' => 'discounts', 'prefix' => 'disc'],
        ['label' => 'Customers', 'prefix' => 'cust'],
        ['label' => 'orders', 'prefix' => 'ord'],
        ['label' => 'invoices', 'prefix' => 'inv'],
        ['label' => 'analytics', 'prefix' => 'anly'],
        ['label' => 'marketing', 'prefix' => 'mkt'],
        ['label' => 'users', 'prefix' => 'usr'],
        ['label' => 'roles', 'prefix' => 'role'],
        ['label' => 'gallary', 'prefix' => 'gal'],
        ['label' => 'languages', 'prefix' => 'lang'],
        ['label' => 'Settings', 'prefix' => 'set'],
    ];

    $actions = [
        'view' => 'view',
        'edit' => 'edit',
        'create' => 'create',
        'delete' => 'del',
    ]; // slug pattern: {prefix}_{suffix}, e.g. prod_view, prod_del
@endphp
<div class="table-responsive">
<table class="table mb-0 border-0">
<tbody>
@foreach ($permissionCatalog as $row)
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>{{ $row['label'] }}</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
@foreach ($actions as $actionLabel => $actionSuffix)
@php($slug = $row['prefix'].'_'.$actionSuffix)
<div class="d-flex ms-2"><span class="text-capitalize me-2">{{ $actionLabel }}</span>
<label class="switch text-start">
<input class="switch role-perm-switch" name="permissions[]" type="checkbox" value="{{ $slug }}" @checked(in_array($slug, $selectedPermissions, true))/><span class="slider"></span>
</label>
</div>
@endforeach
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
