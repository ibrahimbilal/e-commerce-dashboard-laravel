<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list() {
		$users = User::all();
		return view('admin.users.list', compact('users'));
	}

    public function add() {
		$roles = Role::all();
		return view('admin.users.add', compact('roles'));
	}

    public function edit($id) {
		$user = User::find($id);
		if ( !$user ) {
			return redirect()->route('users.list')->with(['error' => 'The User Dose Not Exist!']);
		}
		return view('admin.users.edit', compact('user'));
	}

	public function update(Request $request, $id) {

        try {

            $user = User::find($id);
            if ( !$user ) {
				return redirect()->route('users.list')->with(['error' => 'The User Dose Not Exist!']);
            }

            if ( $request->has('user_language') ) {
				$locale = $request->input('user_language');
				session()->put('locale', $locale);
				$user->locale = $locale;
				$user->update();
            }

			return response()->json(['success'=>'Data successfully updated!']);

        }catch( \Exception $ex ) {
			return redirect()->route('users.list')->with(['error' => 'There Is Error!']);
        }
    }

}
