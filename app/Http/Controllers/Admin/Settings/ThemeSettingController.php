<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ThemeSettingsRequest;

class ThemeSettingController extends Controller
{
    /**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
    {
        $this->middleware('permission:view theme_settings', ['only' => ['index']]);
        $this->middleware('permission:edit theme_settings', ['only' => ['store']]);
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		$settings = Setting::where('setting_key', '=', 'logo_width')
							->orWhere('setting_key', '=', 'mobile_logo_width')
							->orWhere('setting_key', '=', 'main_color')
							->orWhere('setting_key', '=', 'main_color_hover')
							->orWhere('setting_key', '=', 'box_bg_color')
							->orWhere('setting_key', '=', 'body_background')
							->orWhere('setting_key', '=', 'menu_badge_bg')
							->orWhere('setting_key', '=', 'menu_active_bg')
							->orWhere('setting_key', '=', 'text_color')
							->orWhere('setting_key', '=', 'dark_main_color')
							->orWhere('setting_key', '=', 'dark_main_color_hover')
							->orWhere('setting_key', '=', 'dark_box_bg_color')
							->orWhere('setting_key', '=', 'dark_body_background')
							->orWhere('setting_key', '=', 'dark_menu_badge_bg')
							->orWhere('setting_key', '=', 'dark_menu_active_bg')
							->orWhere('setting_key', '=', 'dark_text_color')
							->get();
		$sets = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$sets[$col->setting_key] = $col->setting_value;
		}
		return view('admin.settings.theme', compact('sets'));
    }


	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThemeSettingsRequest $request)
    {

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
}
