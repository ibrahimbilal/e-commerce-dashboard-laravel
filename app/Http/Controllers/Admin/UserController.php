<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NewUserRequest;
use App\Http\Traits\UploadFilesTraits;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\BulkActionRequest;
use App\Http\Requests\UpdateUserRequest;
use Stevebauman\Location\Facades\Location;
use App\Http\Requests\UpdateProfileRequest;
use App\Support\UserStatusToggle;
use Laravel\Fortify\Actions\ConfirmPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

class UserController extends Controller
{
	use UploadFilesTraits;

	/**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
    {
        $this->middleware('permission:view users', ['only' => ['index']]);
        $this->middleware('permission:add users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit users', ['only' => ['edit', 'update', 'toggle']]);
        $this->middleware('permission:delete users', ['only' => ['destroy', 'bulk_destroy']]);
        $this->middleware('permission:restore users', ['only' => ['restore', 'bulk_restore']]);
        $this->middleware('permission:permanently_delete users', ['only' => ['force_delete', 'bulk_force_delete']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		// get all users
		$users = User::all();
		// get deleted users
		$trashed = User::onlyTrashed()->get();
		// get roles names
		$roles = Role::all()->sortBy('name');
		// using for loop
		$results = $users;

		if ( isset($request->role) ) {
			$results = User::role($request->role)->get();
		}

		if ( isset($request->trashed) ) {
			$results = $trashed;
		}

		return view('admin.users.list', compact('users', 'trashed', 'results', 'roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$roles = Role::all()->sortBy('name');
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
		try {

			// upload image and return path if upload success
			if ( $request->hasFile('profile_picture') ) {
				$file_path = $this->uploadFile($request, 'profile_picture', 'users', 'public');
				$request->request->remove('profile_picture');
				$request->merge(['profile_picture' => 'storage/' . $file_path->getData()->path]);
			} else {
				$request->merge(['profile_picture' => null]);
			}

			if (! $request->has('is_active')) {
				$request->merge(['is_active' => true]);
			}

			// send data to 'Fortify' Register method
			$user = $creator->create($request->request->all());
			$user->assignRole($request->input('role_name'));

			// send verify email
			event(new Registered($user));

			return response()->json([
				'success' => true,
				'text' => __('alerts.users.response.create'),
				'redirect' => route('users.index')
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
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
		$roles = Role::all()->sortBy('name');
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
		$roles = Role::all()->sortBy('name');
		$user = User::find($id);
		$sessions = array_to_object($this->sessions($request, $id)->all());

		if (!$user) {
			return redirect()
					->route('users.index')
					->with([
						'errors' => __('alerts.users.response.errors.not_exist')
					]);
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
	public function toggle(Request $request, $id)
	{
		$user = User::query()->findOrFail($id);

		return UserStatusToggle::apply($request, $user);
	}

	public function update(UpdateUserRequest $request, $id)
	{
		// the request will validated by 'UpdateUserRequest' class
		try {

			// redirect if user dose not exist
			$user = User::find($id);
			if (!$user) {
				return response()->json([
					'errors' => __('alerts.users.response.errors.not_exist')
				]);
			}

			// make accoount unverified when change it's status to not_verified
			if ( $request->has('status') ) {
				if (($user->status !== $request->get('status')) && $request->get('status') == 'not_verified') {
					$user->forceFill([
						'email_verified_at' => null
					])->save();
				}
			}

			// send verify email if email changed
			if ($request->get('email') !== $user->email &&
				$user instanceof MustVerifyEmail) {
				$this->updateVerifiedUser($user, $request->get('email'));
				$request->merge(['status' => 'not_verified']);
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

			// change user role
			DB::table('model_has_roles')->where('model_id', $id)->delete();
			$user->assignRole($request->input('role_name'));

			// don't update password if user didn't change it
			// profile picture has updated currently
			if (is_null($request->get('password'))) {
				$user->update(
					$request->except([
						'password',
						'password_confirmation',
						'profile_picture'
					])
				);
			} else {
				// except this fields from update
				// this fields doesn't exist in database
				// profile picture has updated currently

				// hash the password
				$request->merge(['password' => Hash::make( $request->input('password') )]);

				$user->update(
					$request->except([
						'password_confirmation',
						'profile_picture'
					])
				);
			}

			return response()->json([
				'success' => true,
				'text' => __('alerts.users.response.update')
			]);

		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\UpdateProfileRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function update_profile(UpdateProfileRequest $request)
	{
		// the request will validated by 'UpdateUserRequest' class
		try {
			$logged_in_user_id = Auth::user()->id;

			// redirect if user dose not exist
			$user = User::find($logged_in_user_id);
			if (!$user) {
				return response()->json([
					'errors' => __('alerts.users.response.errors.not_exist')
				]);
			}

			// change application language
			if ( $request->has('language') ) {
				$locale = $request->get('language');
				session()->put('locale', $locale);
				app()->setLocale($locale);
			}

			// send verify email if email changed
			if ($request->get('email') !== $user->email &&
				$user instanceof MustVerifyEmail) {
				$this->updateVerifiedUser($user, $request->get('email'));
				$request->merge(['status' => 'not_verified']);
			}

			// upload profile picture
			// store file path to database
			if ( $request->hasFile('profile_picture') ) {
				$file_path = $this->uploadFile($request, 'profile_picture', 'users', 'public');
				$user->profile_picture = 'storage/' . $file_path->getData()->path;
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

				// hash the password
				$request->merge(['password' => Hash::make( $request->input('password') )]);

				$user->update(
					$request->except([
						'current_password',
						'password_confirmation',
						'profile_picture'
					])
				);
			}

			return response()->json([
				'success' => true,
				'text' => __('alerts.users.response.update')
			]);

		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \Illuminate\Http\BulkActionRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulk_destroy(BulkActionRequest $request) {
		try {
			$logged_in_user_id = Auth::user()->id;

			if ( in_array($logged_in_user_id, $request->get('items')) ) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_allowed')]]);
			}

			$users = User::whereIn('id', $request->get('items'));
			$rows = $users->delete();

			if ($rows > 0) {
				$status = true;
				$title = __('bulk_action.ajax.actions.delete.title');
				$text = __('bulk_action.ajax.actions.delete.text', ['type' => __('admin.menu.users.title')]);
			} else {
				$status = false;
				$title = __('bulk_action.ajax.actions.delete.no_items');
				$text = __('');
			}

			return response()->json([
				'success' => $status,
				'title' => $title,
				'text' => $text
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}


	/**
	 * Restore the specified resource from trash.
	 *
	 * @param \Illuminate\Http\BulkActionRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulk_restore(BulkActionRequest $request) {
		try {
			$users = User::onlyTrashed()->whereIn('id', $request->get('items'));

			if (!$users) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_exist')]]);
			}

			$rows = $users->restore();
			if ($rows > 0) {
				$status = true;
				$title = __('bulk_action.ajax.actions.restore.title');
				$text = __('bulk_action.ajax.actions.restore.text', ['type' => __('admin.menu.users.title')]);
			} else {
				$status = false;
				$title = __('bulk_action.ajax.actions.restore.no_items');
				$text = __('');
			}

			return response()->json([
				'success' => $status,
				'title' => $title,
				'text' => $text
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \Illuminate\Http\BulkActionRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulk_force_delete(BulkActionRequest $request) {
		try {
			$logged_in_user_id = Auth::user()->id;

			if ( in_array($logged_in_user_id, $request->get('items')) ) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_allowed')]]);
			}

			$users = User::onlyTrashed()->whereIn('id', $request->get('items'));
			if (!$users) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_exist')]]);
			}

			$rows = $users->forceDelete();
			if ($rows > 0) {
				$status = true;
				$title = __('bulk_action.ajax.actions.delete.title');
				$text = __('bulk_action.ajax.actions.delete.text', ['type' => __('admin.menu.users.title')]);
			} else {
				$status = false;
				$title = __('bulk_action.ajax.actions.delete.no_items');
				$text = __('');
			}

			return response()->json([
				'success' => $status,
				'title' => $title,
				'text' => $text
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		try {
			$logged_in_user_id = Auth::user()->id;

			if ( $logged_in_user_id == $id ) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_allowed')]]);
			}

			$user = User::find($id);
			if (!$user) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_exist')]]);
			}

			$user->delete();
			return response()->json([
				'success' => true,
				'title' => __('alerts.users.response.delete.title'),
				'text' => __('alerts.users.response.delete.text'),
				'redirect' => route('users.index')
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}


	/**
	 * Restore the specified resource from trash.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function restore($id) {
		try {
			$user = User::onlyTrashed()->where('id', $id);

			if (!$user) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_exist')]]);
			}

			$user->restore();
			return response()->json([
				'success' => true,
				'title' => __('alerts.users.response.restore.title'),
				'text' => __('alerts.users.response.restore.text'),
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function force_delete($id) {
		try {
			$logged_in_user_id = Auth::user()->id;

			if ( $logged_in_user_id == $id ) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_allowed')]]);
			}

			$user = User::onlyTrashed()->where('id', $id);
			if (!$user) {
				return response()->json(['errors' => [__('alerts.users.response.errors.not_exist')]]);
			}

			$user->forceDelete();
			return response()->json([
				'success' => true,
				'title' => __('alerts.users.response.force_delete.title'),
				'text' => __('alerts.users.response.force_delete.text'),
				'redirect' => route('users.index')
			]);
		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}

	/**
	 * show recovery codes
	 * @param int $user_id
	 */
	public function show_codes(Request $request)
	{
		$user = $request->user();
		$notify = __('admin.pages.users.two_factor.recovery_codes_notify');
		$recovery_codes = json_decode(decrypt($user->two_factor_recovery_codes, true));

		return response()->json([
			'notify' => $notify,
			'codes' =>  $recovery_codes
		]);
	}


	/**
	 * regenerate recovery codes
	 * @param int $user_id
	 */
	public function regenerate_codes(Request $request, GenerateNewRecoveryCodes $generate)
	{
		// regenerate recovery codes
		$generate($request->user());

		// get new recovery codes
		$recovery_codes = json_decode(decrypt($request->user()->two_factor_recovery_codes, true));

		return response()->json([
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
	public function sessions(Request $request, $id = null) {
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
				'country' => $location && !is_null($location->countryName) ? $location->countryName : __('admin.unknown'),
				'city' => $location && !is_null($location->cityName) ? $location->cityName : __('admin.unknown'),
			];
		});

		if ($data->isEmpty()) {
			$data = collect(
				[
					[
						'agent' => [
							'is_desktop' => __('admin.unknown'),
							'platform' => __('admin.unknown'),
							'browser' => __('admin.unknown'),
							'device' => __('admin.unknown'),
						],
						'ip_address' => __('admin.unknown'),
						'is_current_device' => false,
						'last_active' => __('admin.unknown'),
						'last_active_formated' => __('admin.unknown'),
						'country' => __('admin.unknown'),
						'city' => __('admin.unknown'),
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
	public function logoutSessions(Request $request) {
		// check if password is currect
		$confirmed = app(ConfirmPassword::class)(
			Auth::guard('web'),
			$request->user(),
			$request->password
		);

		if (!$confirmed) {
			return redirect()->back()->with(['error' => __('alerts.users.response.confirm_password')]);
		}

		// logout from other devices
		Auth::logoutOtherDevices($request->password);

		// delete other sessions from database
		$this->deleteOtherSessionRecords($request);

		// redirect
		return back(303)->with(['success' => __('alerts.users.response.logout_other_devices')]);
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


	/**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, $input)
    {
        $user->forceFill([
            'email' => $input,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
