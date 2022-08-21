<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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

	public function create(Request $request) {
		try {
			$data = $request->only(
				'first_name',
				'last_name',
				'email',
				'password',
				'mobile',
				'birth_date',
				'gender',
				'user_role',
				'user_status',
				'user_language',
			);

			$validator = Validator::make($data, [
				'first_name' 	=> 'required|string|max:255',
				'last_name' 	=> 'required|string|max:255',
				'email' 		=> 'required|max:255|email|unique:users,email',
				'password' 		=> 'required|min:8',
				'mobile' 		=> 'numeric|digits_between:9,15|nullable',
				'birth_date' 	=> 'nullable|date|date_format:Y-m-d|before_or_equal:' . date("Y-m-d", strtotime('-18 years')),
				'gender' 		=> 'required|in:male,female',
				'user_role' 	=> 'required|numeric|exists:roles,id',
				'user_status' 	=> 'required|string|in:not_verified,verified,blocked',
				'user_language' => 'required|string',
			]);

			if ($validator->fails()) {
				return response()->json(['errors'=> $validator->errors() ]);
			}

			$user = new User;
			$user->first_name = $data['first_name'];
			$user->last_name = $data['last_name'];
			$user->email = $data['email'];
			$user->password = Hash::make($data['password']);
			$user->mobile = $data['mobile'];
			$user->birth_date = $data['birth_date'];
			$user->gender = $data['gender'];
			$user->role_id = $data['user_role'];
			$user->status = $data['user_status'];
			$user->language = $data['user_language'];

			$user->save();

			return response()->json([
				'success'=>'user successfully Created',
				'redirect'=> route('users.list')
			]);

		} catch ( \Exception $ex ) {
			return response()->json([
				'errors' => ['There Is Error!']
			]);
		}
	}

    public function edit($id) {
		$roles = Role::all();
		$user = User::find($id);
		if ( !$user ) {
			return redirect()->route('users.list')->with(['error' => 'The User Dose Not Exist!']);
		}
		return view('admin.users.edit', compact('user', 'roles'));
	}

	public function update(Request $request, $id) {

        try {

			// redirect if user dose not exist
            $user = User::find($id);
            if ( !$user ) {
				return response()->json([
					'errors' => ['The User Dose Not Exist!']
				]);
            }

			// receive only this fields
			$data = $request->only(
				'first_name',
				'last_name',
				'email',
				'current_password',
				'password',
				'password_confirmation',
				'mobile',
				'birth_date',
				'gender',
				'user_role',
				'user_status',
				'user_language',
			);

			// if ( isset( $data['birth_date'] ) ) {
			// 	dd($data['birth_date']);
			// 	$data['birth_date'] = date("Y-m-d", strtotime($data['birth_date']));
			// }

			$validator = Validator::make($data, [
				'first_name' 		=> 'required|string|max:255',
				'last_name' 		=> 'required|string|max:255',
				'email' 			=> 'required|max:255|email|unique:users,email,' . $id . ',id',
				// 'current_password' 	=> 'sometimes|current_password:web',
				// 'password' 			=> 'sometimes|required_with:current_password|confirmed|min:8',
				'mobile' 			=> 'numeric|digits_between:9,15|nullable',
				'birth_date' 		=> 'nullable|date|date_format:Y-m-d|before_or_equal:' . date("Y-m-d", strtotime('-18 years')),
				'gender' 			=> 'required|in:male,female',
				'user_role' 		=> 'required|numeric|exists:roles,id',
				'user_status' 		=> 'required|string|in:not_verified,verified,blocked',
				'user_language' 	=> 'required|string',
			]);

			if ($validator->fails()) {
				return response()->json(['errors'=> $validator->errors() ]);
			}

			$user->first_name = $data['first_name'];
			$user->last_name = $data['last_name'];
			$user->email = $data['email'];
			// $user->password = Hash::make($data['password']);
			$user->mobile = $data['mobile'];
			$user->birth_date = $data['birth_date'];
			$user->gender = $data['gender'];
			$user->role_id = $data['user_role'];
			$user->status = $data['user_status'];
			$user->language = $data['user_language'];
			$user->update();

			return response()->json(['success'=>'Data successfully updated!']);

        } catch ( \Exception $ex ) {
			return response()->json([
				'errors' => ['There Is Error!']
			]);
        }
    }

	public function delete($id) {
		try {

            $user = User::find($id);
			if ( !$user ) {
				return response()->json(['error'=>'The User Dose Not Exist!']);
			}

			$user->delete();
			return response()->json([
				'success'=>'The User successfully deleted!',
				'redirect'=> route('users.list')
			]);

        }catch( \Exception $ex ) {
            return redirect()->route('users.list')->with( ['error' => 'There Is Error!'] );
        }
	}

	public function show_codes($id) {
		$user = User::find($id);
		if ( !$user ) {
			return redirect()->route('users.list')->with(['error' => 'The User Dose Not Exist!']);
		}

		$notify = __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.');
		$recovery_codes = json_decode(decrypt($user->two_factor_recovery_codes, true ));

		return response()->json([
			'notify' => $notify,
			'codes' =>  $recovery_codes
		]);
	}
}
