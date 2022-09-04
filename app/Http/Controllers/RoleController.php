<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RolesPermissionsRequest;

class RoleController extends Controller
{

	/**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
    {
        $this->middleware('permission:view roles', ['only' => ['index']]);
        $this->middleware('permission:add roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permanently_delete roles', ['only' => ['destroy']]);
    }

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
		// get permissions grouped by sections
		$grouped = grouping_sections_premissions();
		return view('admin.roles.add', compact('grouped'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesPermissionsRequest $request)
    {
		// the request will validated by 'RolesPermissionsRequest' class
        try {

			$role = Role::create(['name' => $request->input('role_title')]);
			$role->syncPermissions($request->input('permissions'));

			return response()->json([
				'success' => true,
				'text' => __('alerts.roles.response.create'),
				'redirect' => route('roles.index')
			]);

		} catch ( \Exception $ex ) {
			return response()->json([
				'errors' => [__('alerts.response.errors.unknown')]
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
			return redirect()
					->route('roles.index')
					->with([
						'errors' => __('alerts.roles.response.errors.not_exist')
					]);
		}

		// get permissions grouped by sections
		$grouped = grouping_sections_premissions();

		// get this role permissions
		$role_permissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

		return view('admin.roles.edit', compact('role', 'grouped', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesPermissionsRequest $request, $id)
    {
		// the request will validated by 'RolesPermissionsRequest' class
		try {

            $role = Role::find($id);
            if ( !$role ) {
				return redirect()
						->route('roles.index')
						->with([
							'errors' => __('alerts.roles.response.errors.not_exist')
						]);
            }

			$role->name = $request->input('role_title');
			$role->save();
			$role->syncPermissions($request->input('permissions'));

			return response()->json([
				'success' => true,
				'text' => __('alerts.roles.response.update')
			]);

        }catch( \Exception $ex ) {
			return redirect()
					->route('roles.index')
					->with(['errors' => [__('alerts.response.errors.unknown')]]);
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
				return redirect()
						->route('roles.index')
						->with([
							'errors' => [__('alerts.roles.response.errors.not_exist')]
						]);
			}

			$role->delete();
			return response()->json([
				'success' => true,
				'title' => __('alerts.roles.response.delete.title'),
				'text' => __('alerts.roles.response.delete.text'),
				'redirect' => route('roles.index')
			]);

        }catch( \Exception $ex ) {
			return redirect()
					->route('roles.index')
					->with(['errors' => [__('alerts.response.errors.unknown')]]);
        }
    }
}
