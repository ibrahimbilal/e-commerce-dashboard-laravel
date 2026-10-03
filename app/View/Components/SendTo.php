<?php

namespace App\View\Components;

use App\Models\User;
use App\Models\Setting;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;
use App\Support\AdminSettingDefaults;

class SendTo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
		public string $id,
        public string $selName,
        public string $typeName,
	)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

		$users = User::select('id', 'email')->get();
		$roles = Role::select('id', 'name')->get();

		$settings = Setting::where('setting_key', '=', 'new_order_recipients_type')
			->orWhere('setting_key', '=', 'new_order_recipients')

			->orWhere('setting_key', '=', 'out_of_stock_recipients_type')
			->orWhere('setting_key', '=', 'out_of_stock_recipients')

			->orWhere('setting_key', '=', 'order_canceled_recipients_type')
			->orWhere('setting_key', '=', 'order_canceled_recipients')
			->get();

		$sets = [];
		foreach ($settings as $col) {
			// Compact only inputs data
			$sets[$col->setting_key] = $col->setting_value;

			if ( $col->setting_key == 'new_order_recipients' ||
				 $col->setting_key == 'out_of_stock_recipients' ||
				 $col->setting_key == 'order_canceled_recipients'
			) {
				$sets[$col->setting_key] = json_decode($col->setting_value);
			}
		}

		$sets = AdminSettingDefaults::mergeLoaded($sets, AdminSettingDefaults::emailRecipientKeys());

		foreach (AdminSettingDefaults::emailRecipientKeys() as $key) {
			if (! str_ends_with($key, '_recipients')) {
				continue;
			}
			if (isset($sets[$key]) && is_array($sets[$key])) {
				continue;
			}
			$decoded = json_decode($sets[$key] ?? '[]', true);
			$sets[$key] = is_array($decoded) ? $decoded : [];
		}

        return view('components.send-to', compact('sets', 'users', 'roles'));
    }
}
