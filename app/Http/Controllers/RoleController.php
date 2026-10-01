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
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'permissions' => ['nullable', 'string', 'max:255'],
        ]);

        $role = Role::create($data);

        return redirect()->route('roles.show', $role)->with('status', 'Role created.');
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
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'permissions' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update($data);

        return redirect()->route('roles.show', $role)->with('status', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role deleted.');
    }
}
