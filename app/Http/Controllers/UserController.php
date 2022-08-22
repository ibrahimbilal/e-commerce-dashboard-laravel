<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::all();
		return view('admin.users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
		return view('admin.users.add', compact('roles'));
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
				'redirect'=> route('users.index')
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
		$user = Auth::user();
		$roles = Role::all();
		$sessions = array_to_object($this->sessions($request)->all());

		return view('admin.users.profile', compact('user', 'roles', 'sessions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$logged_in_user_id = Auth::user()->id;
		$roles = Role::all();
		$user = User::find($id);

		if ( !$user ) {
			return redirect()->route('users.index')->with(['error' => 'The User Dose Not Exist!']);
		}

		// redirect to profile page if logged in user need to edit his account
		if ( $logged_in_user_id == $id ) {
			return redirect()->route('users.profile');
		}

		return view('admin.users.edit', compact('user', 'roles'));
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

			$validator = Validator::make($data, [
				'first_name' 		=> 'required|string|max:255',
				'last_name' 		=> 'required|string|max:255',
				'email' 			=> 'required|max:255|email|unique:users,email,' . $id . ',id',
				'current_password' 	=> 'nullable|current_password:web',
				'password' 			=> 'confirmed|nullable|different:current_password|required_with:current_password|min:8',
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
			$user->password = Hash::make($data['password']);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = User::find($id);
			if ( !$user ) {
				return response()->json(['error'=>'The User Dose Not Exist!']);
			}

			$user->delete();
			return response()->json([
				'success'=>'The User successfully deleted!',
				'redirect'=> route('users.index')
			]);

        }catch( \Exception $ex ) {
            return redirect()->route('users.index')->with( ['error' => 'There Is Error!'] );
        }
    }


	public function show_codes($id) {
		$user = User::find($id);
		if ( !$user ) {
			return redirect()->route('users.index')->with(['error' => 'The User Dose Not Exist!']);
		}

		$notify = __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.');
		$recovery_codes = json_decode(decrypt($user->two_factor_recovery_codes, true ));

		return response()->json([
			'notify' => $notify,
			'codes' =>  $recovery_codes
		]);
	}


	/**
     * Get the current sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                    'device' => $agent->device(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'last_active_formated' => Carbon::createFromTimestamp($session->last_activity)->format('d/m/Y H:i'),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
