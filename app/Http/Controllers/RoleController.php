<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$roles = Role::all();
		return view('admin.roles.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('admin.roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
				'redirect'=> route('roles.index')
			]);

		} catch ( \Exception $ex ) {
			return response()->json([
				'errors' => ['There Is Error!']
			]);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$role = Role::find($id);
		if ( !$role ) {
			return redirect()->route('roles.index')->with(['error' => 'The Role Dose Not Exist!']);
		}
		return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		try {

            $role = Role::find($id);
            if ( !$role ) {
				return redirect()->route('roles.index')->with(['error' => 'The Role Dose Not Exist!']);
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
			return redirect()->route('roles.index')->with(['error' => 'There Is Error!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		try {

            $role = Role::find($id);
			if ( !$role ) {
				return response()->json(['error'=>'The Role Dose Not Exist!']);
			}

			$role->delete();
			return response()->json([
				'success'=>'The Role successfully deleted!',
				'redirect'=> route('roles.index')
			]);

        }catch( \Exception $ex ) {
            return redirect()->route('roles.index')->with( ['error' => 'There Is Error!'] );
        }
    }
}
