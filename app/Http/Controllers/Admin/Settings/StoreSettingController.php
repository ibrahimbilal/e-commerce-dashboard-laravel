<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreSettingsRequest;

class StoreSettingController extends Controller
{
	/**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
	{
		$this->middleware('permission:view store_settings', ['only' => ['index']]);
		$this->middleware('permission:edit store_settings', ['only' => ['store']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$settings = Setting::where('setting_key', '=', 'country')
			->orWhere('setting_key', '=', 'state')
			->orWhere('setting_key', '=', 'city')
			->orWhere('setting_key', '=', 'address_1')
			->orWhere('setting_key', '=', 'address_2')
			->orWhere('setting_key', '=', 'postcode')
			->orWhere('setting_key', '=', 'reviews')
			->orWhere('setting_key', '=', 'guest_reviews')
			->orWhere('setting_key', '=', 'guest_checkout')
			->orWhere('setting_key', '=', 'wishlist')
			->orWhere('setting_key', '=', 'compare')
			->orWhere('setting_key', '=', 'out_of_stock_products')
			->orWhere('setting_key', '=', 'social_share')
			->orWhere('setting_key', '=', 'share_on')
			->orWhere('setting_key', '=', 'recently_viewed')
			->orWhere('setting_key', '=', 'recommend')
			->get();
		$sets = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$sets[$col->setting_key] = $col->setting_value;
		}
		return view('admin.settings.store', compact('sets'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreSettingsRequest $request)
	{

		// make fields empty if not set
		$fields = [
			'address_2',
			'reviews',
			'guest_reviews',
			'guest_checkout',
			'wishlist',
			'compare',
			'out_of_stock_products',
			'social_share',
			'recently_viewed',
			'recommend',
		];

		// set fields empty if not set
		foreach ($fields as $field) {
			if (!$request->has($field)) {
				$request->merge([$field => '']);
			}
		}

		foreach ($request->request->all() as $key => $value) {

			if ($key == 'share_on') {
				$value = json_encode($request->share_on);
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
}
