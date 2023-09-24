<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\GeneralSettingsRequest;

class GeneralSettingController extends Controller
{
	/**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
    {
        $this->middleware('permission:view general_settings', ['only' => ['index']]);
        $this->middleware('permission:edit general_settings', ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$settings = Setting::where('setting_key', '=', 'site_title')
							->orWhere('setting_key', '=', 'tagline')
							->orWhere('setting_key', '=', 'site_description')
							->orWhere('setting_key', '=', 'site_url')
							->orWhere('setting_key', '=', 'timezone')
							->orWhere('setting_key', '=', 'date_formate')
							->orWhere('setting_key', '=', 'time_formate')
							->orWhere('setting_key', '=', 'time_formate_custom')
							->orWhere('setting_key', '=', 'date_formate_custom')
							->get();
		$sets = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$sets[$col->setting_key] = $col->setting_value;
		}
		return view('admin.settings.general', compact('sets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralSettingsRequest $request)
    {

		// make fields empty if not set
		$fields = [
			'time_formate_custom',
			'date_formate_custom',
		];

		// set fields empty if not set
		foreach ($fields as $field) {
			if (!$request->has($field)) {
				$request->merge([$field => '']);
			}
		}

		// Change values in .env file
		if ( $request->has('site_title') ) {
			update_env('APP_NAME', $request->get('site_title') );
		}

		// Change values in .env file
		if ( $request->has('site_url') ) {
			update_env('APP_URL', $request->get('site_url') );
		}

		// Change Timezone in Config File
		if ( $request->has('timezone') ) {
			// update app timezone
			update_env('APP_TIMEZONE', $request->get('timezone') );
		}

		foreach( $request->request->all() as $key => $value ) {
			Setting::updateOrCreate(
				['setting_key' =>  $key],
				['setting_value' =>  $value],
			);
		}

		return response()->json([
			'success' => true,
			'title' => __('alerts.settings.response.success')
		]);
    }

	public function ajax_date_preview(Request $request) {
		$data = $request->only(['format']);

		// get date/time preview
		$preview = date($data['format']);
		return response()->json([ 'preview' => $preview ]);
	}
}
