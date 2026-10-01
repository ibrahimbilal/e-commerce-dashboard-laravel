<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view roles', ['only' => ['index', 'show']]);
        $this->middleware('permission:add roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permanently_delete roles', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::query()
            ->where('guard_name', 'web')
            ->with('permissions')
            ->withCount('users')
            ->orderBy('name')
            ->paginate(20);

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
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::exists('permissions', 'name')->where('guard_name', 'web')],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.edit', $role)->with('status', 'Role created.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::query()->where('guard_name', 'web')->orderBy('name')->get();

        return view('roles.show', compact('role', 'permissions'));
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::query()->where('guard_name', 'web')->orderBy('name')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::exists('permissions', 'name')->where('guard_name', 'web')],
        ]);

        if ($role->name === 'admin' && $validated['name'] !== 'admin') {
            throw ValidationException::withMessages([
                'name' => ['The admin role name cannot be changed.'],
            ]);
        }

        $role->update([
            'name' => $validated['name'],
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('roles.edit', $role)->with('status', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            abort(403, 'The admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role deleted.');
    }
}
