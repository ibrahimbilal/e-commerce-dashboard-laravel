<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;

class MultiCurrencies extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
		public string $current
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
		$settings = Setting::where('setting_key', '=', 'main_currency')
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

        return view('components.multi-currencies', compact('sets'));
    }
}
