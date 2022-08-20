<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function view_general_page() {
		$settings = Setting::all();
		$datas = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$datas[$col->setting_key] = $col->setting_value;
		}
		return view('admin.settings.general', compact('datas'));
	}

	public function save_general_settings(Request $request) {
		$data = $request->only(['site_title', 'tagline', 'site_description', 'site_url', 'timezone', 'date_formate', 'date_formate_custom', 'time_formate', 'time_formate_custom']);

		$validator = Validator::make($data, [
            'site_title' 			=> 'required|string|min:4',
            'tagline' 				=> 'required|string',
            'site_description' 		=> 'required|string',
            'site_url' 				=> 'required|url',
            'timezone' 				=> 'required|string',
            'date_formate' 			=> 'required|string',
            'date_formate_custom' 	=> 'required_if:date_formate,custom|string',
            'time_formate' 			=> 'required|string',
            'time_formate_custom' 	=> 'required_if:time_formate,custom|string',
        ]);

        if ($validator->fails()) {
			return response()->json(['errors'=> $validator->errors() ]);
        }

		// make 'time_formate_custom' empty if not set
		if ( !$request->has('time_formate_custom') ) {
			$data['time_formate_custom'] = '';
		}

		// make 'date_formate_custom' empty if not set
		if ( !$request->has('date_formate_custom') ) {
			$data['date_formate_custom'] = '';
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
			// update_env('APP_URL', $data['site_url']);
			config(['app.timezone' => $request->get('timezone')]);
		}

		foreach( $data as $key => $value ) {
			Setting::updateOrCreate(
				['setting_key' =>  $key],
				['setting_value' =>  $value],
			);
		}

		// return redirect()->route('general_settings')->with('status', 'Changes Saved Successfuly!');
		return response()->json(['success'=>'Your settings successfully updated!']);
	}

	public function ajax_date_preview(Request $request) {
		$data = $request->only(['format']);

		// get date/time preview
		$preview = date($data['format']);
		return response()->json([ 'preview' => $preview ]);
	}
}
