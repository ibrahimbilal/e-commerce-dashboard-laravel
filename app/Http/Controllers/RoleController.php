<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function list() {
		$roles = Role::all();
		return view('admin.roles.list', compact('roles'));
	}

    public function add() {
		return view('admin.roles.add');
	}

    public function create(Request $request) {

		try {
			$data = $request->only('role_title', 'permissions');

			$validator = Validator::make($data, [
				'role_title' => 'required|string',
				"permissions"    => "array",
				"permissions.*"  => "array",
				"permissions.*.*"  => Rule::in(['on', 'off']),
			]);

			if ($validator->fails()) {
				return response()->json(['errors'=> $validator->errors() ]);
			}

			$role = new Role;
			$role->title = $request->get('role_title');
			$role->permissions = json_encode($request->get('permissions'));

			$role->save();

			return response()->json([
				'success'=>'Role successfully Created',
				'redirect'=> route('roles.list')
			]);

		} catch ( \Exception $ex ) {
			return response()->json([
				'errors' => ['There Is Error!']
			]);
		}
	}

    public function edit($id) {
		$role = Role::find($id);
		if ( !$role ) {
			return redirect()->route('roles.list')->with(['error' => 'The Role Dose Not Exist!']);
		}
		return view('admin.roles.edit', compact('role'));
	}

	public function update(Request $request, $id) {

        try {

            $role = Role::find($id);
            if ( !$role ) {
				return redirect()->route('roles.list')->with(['error' => 'The Role Dose Not Exist!']);
            }

            $data = $request->only('role_title', 'permissions');

			$validator = Validator::make($data, [
				'role_title' => 'required|string',
				"permissions"    => "array",
				"permissions.*"  => "array",
				"permissions.*.*"  => Rule::in(['on', 'off']),
			]);

			if ($validator->fails()) {
				return response()->json(['errors'=> $validator->errors() ]);
			}

			$role->title = $request->get('role_title');
			$role->permissions = json_encode($request->get('permissions'));

			$role->save();

			return response()->json(['success'=>'Data successfully updated!']);

        }catch( \Exception $ex ) {
			return redirect()->route('roles.list')->with(['error' => 'There Is Error!']);
        }
    }

	public function delete($id) {
		try {

            $role = Role::find($id);
			if ( !$role ) {
				return response()->json(['error'=>'The Role Dose Not Exist!']);
			}

			$role->delete();
			return response()->json([
				'success'=>'The Role successfully deleted!',
				'redirect'=> route('roles.list')
			]);

        }catch( \Exception $ex ) {
            return redirect()->route('roles.list')->with( ['error' => 'There Is Error!'] );
        }
	}

}
