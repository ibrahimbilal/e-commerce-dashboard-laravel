<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('title')->paginate(20);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedRole($request);

        $role = Role::create($data);

        return redirect()->route('roles.edit', $role)->with('status', 'Role created.');
    }

    public function show(Role $role)
    {
        $role->load('users');

        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update($this->validatedRole($request));

        return redirect()->route('roles.edit', $role)->with('status', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedRole(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required_without:role_name', 'string', 'max:50'],
            'role_name' => ['required_without:title', 'string', 'max:50'],
            'permissions' => ['nullable'],
        ]);

        $permissions = $validated['permissions'] ?? null;

        if (is_array($permissions)) {
            $permissions = implode(',', array_values(array_filter($permissions)));
        }

        return [
            'title' => $validated['title'] ?? $validated['role_name'],
            'permissions' => $permissions,
        ];
    }
}
