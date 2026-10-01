<?php

namespace App\Http\Controllers;

use App\Support\StorefrontPermissionMap;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::query()
            ->where('guard_name', 'web')
            ->withCount('users')
            ->orderBy('name')
            ->paginate(20);

        $roles->getCollection()->transform(fn (Role $role) => $this->presentRole($role));

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::query()->where('guard_name', 'web')->orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required_without:title', 'string', 'max:255'],
            'title' => ['required_without:name', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $role = Role::create([
            'name' => $validated['name'] ?? $validated['title'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions(
            StorefrontPermissionMap::toPermissionNames($validated['permissions'] ?? [])
        );

        return redirect()->route('roles.edit', $role)->with('status', 'Role created.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('roles.show', [
            'role' => $this->presentRole($role),
        ]);
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::query()->where('guard_name', 'web')->orderBy('name')->get();

        return view('roles.edit', [
            'role' => $this->presentRole($role),
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required_without:title', 'string', 'max:255'],
            'title' => ['required_without:name', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $role->update([
            'name' => $validated['name'] ?? $validated['title'],
        ]);

        $role->syncPermissions(
            StorefrontPermissionMap::toPermissionNames($validated['permissions'] ?? [])
        );

        return redirect()->route('roles.edit', $role)->with('status', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role deleted.');
    }

    private function presentRole(Role $role): Role
    {
        $role->setAttribute('title', $role->name);
        $slugList = StorefrontPermissionMap::toSlugs(
            $role->relationLoaded('permissions')
                ? $role->permissions->pluck('name')->all()
                : $role->permissions()->pluck('name')->all()
        );
        $role->setAttribute('permissions', implode(',', $slugList));

        return $role;
    }
}
