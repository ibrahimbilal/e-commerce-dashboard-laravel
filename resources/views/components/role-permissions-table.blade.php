@php
    $rolePermissions = isset($role) && filled($role->permissions ?? null)
        ? array_values(array_filter(array_map('trim', explode(',', (string) $role->permissions))))
        : [];

    $selectedPermissions = old('permissions', $rolePermissions);
    if (! is_array($selectedPermissions)) {
        $selectedPermissions = array_values(array_filter(array_map('trim', explode(',', (string) $selectedPermissions))));
    }

    $permissionRows = [
        ['label' => 'Products', 'view' => 'prod_view', 'edit' => 'prod_edit'],
        ['label' => 'Attributes', 'view' => 'attr_view'],
        ['label' => 'reviews', 'view' => 'rev_view'],
        ['label' => 'Categories', 'view' => 'cat_view'],
        ['label' => 'Tags', 'view' => 'tag_view'],
        ['label' => 'discounts', 'view' => 'disc_view'],
        ['label' => 'Customers', 'view' => 'cust_view'],
        ['label' => 'orders', 'view' => 'ord_view', 'edit' => 'ord_edit'],
        ['label' => 'invoices', 'view' => 'inv_view'],
        ['label' => 'analytics', 'view' => 'anly_view'],
        ['label' => 'marketing', 'view' => 'mkt_view'],
        ['label' => 'users', 'view' => 'usr_view', 'edit' => 'usr_edit'],
        ['label' => 'roles', 'view' => 'role_view', 'edit' => 'role_edit'],
        ['label' => 'gallary', 'view' => 'gal_view'],
        ['label' => 'languages', 'view' => 'lang_view'],
        ['label' => 'Settings', 'view' => 'set_view'],
    ];
@endphp
<div class="table-responsive">
<table class="table mb-0 border-0">
<tbody>
@foreach ($permissionRows as $row)
@php
    $viewSlug = $row['view'];
    $editSlug = $row['edit'] ?? null;
@endphp
<tr class="bg-active">
<td class="border-0 p-4">
<h3 class="h6 text-capitalize text-nowrap mb-0"><strong>{{ $row['label'] }}</strong></h3>
</td>
<td class="border-0 p-4">
<div class="d-flex justify-content-between align-items-center w-100">
<div class="d-flex ms-2"><span class="text-capitalize me-2">view</span>
<label class="switch text-start">
<input class="switch role-perm-switch" name="permissions[]" type="checkbox" value="{{ $viewSlug }}" @checked(in_array($viewSlug, $selectedPermissions, true))/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">edit</span>
<label class="switch text-start">
@if ($editSlug)
<input class="switch role-perm-switch" name="permissions[]" type="checkbox" value="{{ $editSlug }}" @checked(in_array($editSlug, $selectedPermissions, true))/><span class="slider"></span>
@else
<input class="switch" type="checkbox"/><span class="slider"></span>
@endif
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">create</span>
<label class="switch text-start">
<input class="switch" type="checkbox"/><span class="slider"></span>
</label>
</div>
<div class="d-flex ms-2"><span class="text-capitalize me-2">delete</span>
<label class="switch text-start">
<input class="switch" type="checkbox"/><span class="slider"></span>
</label>
</div>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
