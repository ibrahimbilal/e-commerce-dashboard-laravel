<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewUserRequest;
use App\Http\Traits\UploadFilesTraits;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\UpdateUserRequest;
use Stevebauman\Location\Facades\Location;
use Laravel\Fortify\Actions\ConfirmPassword;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class UserController extends Controller
{
	use UploadFilesTraits;

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
	 * @param  \Illuminate\Http\NewUserRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(NewUserRequest $request, CreatesNewUsers $creator)
	{
		// the request will validated by 'NewUserRequest' class
		// try {

			if ( $request->hasFile('profile_picture') ) {
				$file_path = $this->uploadFile($request, 'profile_picture', 'users', 'public');
				$request->request->remove('profile_picture');
				$request->merge(['profile_picture' => 'storage/' . $file_path]);
			} else {
				$request->merge(['profile_picture' => null]);
			}

			// dd($file_path);
			// dd($request->validated());
			// dd($request->request->all());

			$user = $creator->create($request->request->all());

			event(new Registered($user));

			return response()->json([
				'success' => 'user successfully Created',
				'redirect' => route('users.index')
			]);
		// } catch (\Exception $ex) {
		// 	return response()->json([
		// 		'errors' => ['There Is Error!']
		// 	]);
		// }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request)
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function profile(Request $request)
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
	public function edit(Request $request, $id)
	{
		$logged_in_user_id = Auth::user()->id;
		$roles = Role::all();
		$user = User::find($id);
		$sessions = array_to_object($this->sessions($request, $id)->all());

		if (!$user) {
			return redirect()->route('users.index')->with(['error' => 'The User Dose Not Exist!']);
		}

		// redirect to profile page if logged in user need to edit his account
		if ($logged_in_user_id == $id) {
			return redirect()->route('users.profile');
		}

		return view('admin.users.edit', compact('user', 'roles', 'sessions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\UpdateUserRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateUserRequest $request, $id)
	{
		// the request will validated by 'UpdateUserRequest' class
		try {
			// redirect if user dose not exist
			$user = User::find($id);
			if (!$user) {
				return response()->json([
					'errors' => ['The User Dose Not Exist!']
				]);
			}

			// change application language
			if ( $request->has('language') ) {
				$locale = $request->input('language');
				session()->put('locale', $locale);
				app()->setLocale($locale);
			}

			// make accoount unverified when change it's status to not_verified
			if ( $request->has('status') ) {
				if (($user->status !== $request->get('status')) && $request->get('status') == 'not_verified') {
					$user->forceFill([
						'email_verified_at' => null
					])->save();
				}
			}

			// upload profile picture
			// store file path to database
			if ( $request->hasFile('profile_picture') ) {
				$file_path = $this->uploadFile($request, 'profile_picture', 'users', 'public');
				$user->profile_picture = 'storage/' . $file_path;
				$user->save();
			}

			// remove profile picture
			if ( $request->has('remove_pp') && $request->get('remove_pp') ) {
				$user->profile_picture = null;
				$user->save();
			}

			// don't update password if user didn't change it
			// profile picture has updated currently
			if (is_null($request->get('current_password')) && is_null($request->get('password'))) {
				$user->update(
					$request->except([
						'password',
						'current_password',
						'password_confirmation',
						'profile_picture'
					])
				);
			} else {
				// except this fields from update
				// this fields doesn't exist in database
				// profile picture has updated currently
				$user->update(
					$request->except([
						'current_password',
						'password_confirmation',
						'profile_picture'
					])
				);
			}

			return response()->json(['success' => 'Data successfully updated!']);

		} catch (\Exception $ex) {
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
			if (!$user) {
				return response()->json(['error' => 'The User Dose Not Exist!']);
			}

			$user->delete();
			return response()->json([
				'success' => 'The User successfully deleted!',
				'redirect' => route('users.index')
			]);
		} catch (\Exception $ex) {
			return redirect()->route('users.index')->with(['error' => 'There Is Error!']);
		}
	}


	/**
	 * show recovery codes
	 * @param int $user_id
	 */
	public function show_codes($user_id)
	{
		$user = User::find($user_id);
		if (!$user) {
			return redirect()->route('users.index')->with(['error' => 'The User Dose Not Exist!']);
		}

		$notify = __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.');
		$recovery_codes = json_decode(decrypt($user->two_factor_recovery_codes, true));

		return response()->json([
			'notify' => $notify,
			'codes' =>  $recovery_codes
		]);
	}


	/**
	 * Get the current sessions.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param int $id
	 * @return \Illuminate\Support\Collection
	 */
	public function sessions(Request $request, $id = null)
	{
		if (config('session.driver') !== 'database') {
			return collect();
		}

		$data = collect(
			DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
				->where('user_id', !$id ? ($request->user()->getAuthIdentifier() ? $request->user()->getAuthIdentifier() : $id) : $id)
				->orderBy('last_activity', 'desc')
				->get()
		)->map(function ($session) use ($request, $id) {
			$agent = $this->createAgent($session);
			$location = Location::get($session->ip_address);
			return (object) [
				'agent' => [
					'is_desktop' => $agent->isDesktop(),
					'platform' => $agent->platform(),
					'browser' => $agent->browser(),
					'device' => $agent->deviceType(),
				],
				'ip_address' => $session->ip_address,
				'is_current_device' => !$id ? ($session->id === $request->session()->getId()) : false,
				'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
				'last_active_formated' => Carbon::createFromTimestamp($session->last_activity)->format('d/m/Y H:i'),
				'country' => $location && !is_null($location->countryName) ? $location->countryName : __('Unknown'),
				'city' => $location && !is_null($location->cityName) ? $location->cityName : __('Unknown'),
			];
		});

		if ($data->isEmpty()) {
			$data = collect(
				[
					[
						'agent' => [
							'is_desktop' => __('Unknown'),
							'platform' => __('Unknown'),
							'browser' => __('Unknown'),
							'device' => __('Unknown'),
						],
						'ip_address' => __('Unknown'),
						'is_current_device' => false,
						'last_active' => __('Unknown'),
						'last_active_formated' => __('Unknown'),
						'country' => __('Unknown'),
						'city' => __('Unknown'),
					]
				]
			);
		}

		return $data;
	}

	/**
	 * Log out from other browser sessions.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logoutSessions(Request $request)
	{
		// check if password is currect
		$confirmed = app(ConfirmPassword::class)(
			Auth::guard('web'),
			$request->user(),
			$request->password
		);

		if (!$confirmed) {
			return redirect()->back()->with(['error' => __('The given password does not match the current password!')]);
		}

		// logout from other devices
		Auth::logoutOtherDevices($request->password);

		// delete other sessions from database
		$this->deleteOtherSessionRecords($request);

		// redirect
		return back(303)->with(['success' => __('Logged out from other devices successfuly')]);
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

	/**
	 * Delete the other browser session records from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	protected function deleteOtherSessionRecords(Request $request)
	{
		if (config('session.driver') !== 'database') {
			return;
		}

		DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
			->where('user_id', $request->user()->getAuthIdentifier())
			->where('id', '!=', $request->session()->getId())
			->delete();
	}
}
