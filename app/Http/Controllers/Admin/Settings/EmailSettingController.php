<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\EmailSettingsRequest;
use App\Models\User;
use App\Support\AdminSettingDefaults;

class EmailSettingController extends Controller
{
	/**
	 * protect controllers, by setting desired middleware in the constructor
	 */
	function __construct()
	{
		$this->middleware('permission:view emails_settings', ['only' => ['index']]);
		$this->middleware('permission:edit emails_settings', ['only' => ['store']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$settings = Setting::where('setting_key', '=', 'email_from_name')
			->orWhere('setting_key', '=', 'email_from_address')
			->orWhere('setting_key', '=', 'email_main_color')
			->orWhere('setting_key', '=', 'email_bg_color')
			->orWhere('setting_key', '=', 'email_body_bg_color')
			->orWhere('setting_key', '=', 'email_text_color')
			->orWhere('setting_key', '=', 'email_new_order')
			->orWhere('setting_key', '=', 'email_out_of_stock')
			->orWhere('setting_key', '=', 'email_order_canceled')
			->orWhere('setting_key', '=', 'email_order_confirmed')
			->orWhere('setting_key', '=', 'email_order_shipped')
			->orWhere('setting_key', '=', 'email_order_completed')
			->orWhere('setting_key', '=', 'email_order_refunded')
			->get();

		$sets = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$sets[$col->setting_key] = $col->setting_value;
		}
		$sets = AdminSettingDefaults::mergeLoaded($sets, AdminSettingDefaults::emailPageKeys());

		return view('admin.settings.email', compact('sets'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(EmailSettingsRequest $request)
	{
		// make fields empty if not set
		$fields = [
			'email_new_order',
			'new_order_recipients_type',
			'new_order_recipients',
			'email_out_of_stock',
			'out_of_stock_recipients_type',
			'out_of_stock_recipients',
			'out_of_stock_products',
			'email_order_canceled',
			'order_canceled_recipients_type',
			'order_canceled_recipients',
			'email_order_confirmed',
			'email_order_shipped',
			'email_order_completed',
			'email_order_refunded',
		];

		// set fields empty if not set
		foreach ($fields as $field) {
			if (!$request->has($field)) {
				$request->merge([$field => '']);
			}
		}

		foreach ($request->request->all() as $key => $value) {

			if (
				$key == 'new_order_recipients' ||
				$key == 'out_of_stock_recipients' ||
				$key == 'order_canceled_recipients'
				) {
					if ( !empty($value) ) {
						$value = json_encode($value);
					}
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


	function recipients_type(Request $request) {

		$type = $request->get('rec_type');

		switch ($type) {
			case 'custom':
				$res = User::select('id', 'email')->get();
				break;
			case 'recipients-role':
				$res = Role::select('id', 'name')->get();
				break;

			default:
				$res = '';
				break;
		}

		return $res;
	}
}
