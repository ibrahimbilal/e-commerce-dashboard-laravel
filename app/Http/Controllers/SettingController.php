<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\SaveSettingsRequest;

class SettingController extends Controller
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
		$settings = Setting::all();
		$datas = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$datas[$col->setting_key] = $col->setting_value;
		}
		return view('admin.settings.general', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveSettingsRequest $request)
    {


		// make 'time_formate_custom' empty if not set
		if ( !$request->has('time_formate_custom') ) {
			// $data['time_formate_custom'] = '';
			$request->merge(['time_formate_custom' => '']);
		}

		// make 'date_formate_custom' empty if not set
		if ( !$request->has('date_formate_custom') ) {
			$request->merge(['date_formate_custom' => '']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	public function ajax_date_preview(Request $request) {
		$data = $request->only(['format']);

		// get date/time preview
		$preview = date($data['format']);
		return response()->json([ 'preview' => $preview ]);
	}
}
