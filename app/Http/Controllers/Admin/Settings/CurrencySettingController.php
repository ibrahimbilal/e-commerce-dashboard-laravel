<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Settings\CurrencySettingsRequest;

class CurrencySettingController extends Controller
{
    /**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
    {
        $this->middleware('permission:view currencies_settings', ['only' => ['index']]);
        $this->middleware('permission:edit currencies_settings', ['only' => ['store']]);
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$settings = Setting::where('setting_key', '=', 'main_currency')
							->orWhere('setting_key', '=', 'currency_position')
							->orWhere('setting_key', '=', 'thousand_sep')
							->orWhere('setting_key', '=', 'decimal_sep')
							->orWhere('setting_key', '=', 'num_decimals')
							->orWhere('setting_key', '=', 'enable_multi_currencies')
							->orWhere('setting_key', '=', 'currencies_display')
							->orWhere('setting_key', '=', 'multi_currencies')
							->get();
		$sets = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$sets[$col->setting_key] = $col->setting_value;

			if ( $col->setting_key == 'multi_currencies' ) {
				$sets[$col->setting_key] = json_decode($col->setting_value);
			}
		}
		return view('admin.settings.currencies', compact('sets'));
    }


	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencySettingsRequest $request)
    {
		// make fields empty if not set
		$fields = [
			'enable_multi_currencies',
			'multi_currencies',
		];

		// set fields empty if not set
		foreach ($fields as $field) {
			if (!$request->has($field)) {
				$request->merge([$field => '']);
			}
		}

		foreach ($request->request->all() as $key => $value) {

			if ($key == 'multi_currencies') {
				$value = json_encode($request->multi_currencies);
			}

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

	// get multi currencies component
	function multi_currencies(Request $request) {

		$main_curr = $request->has('mainCurrency') ? $request->mainCurrency : '';
		$multi_curr = $request->has('multiCurrency') ? $request->multiCurrency : [];

		// return $request->all();
		$output = View::make("components.multi-currencies")
						->with("sets", [
							'main_currency' => $main_curr,
							'multi_currencies' => $multi_curr
						])->render();

		return $output;
	}
}
