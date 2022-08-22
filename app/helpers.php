<?php

// Create Dashboard Menu
if (!function_exists('get_dashboard_menu')) {
	/**
	 * Get Dashboard Menu items
	 * @return array
	 */
	function get_dashboard_menu()
	{
		return [
			[
				[
					"route_name" => 'index',
					"active_if" => ['index'],
					"icon" => 'apps',
					"title" => 'dashboard',
					"has_submeu" => false,
					"badge" => '',
				]
			],
			[
				[
					"route_name" => '',
					"active_if" => ['products'],
					"icon" => 'shopping-bag',
					"title" => 'products',
					"has_submeu" => true,
					"badge" => '',
					"submenu_items" => [
						[
							"route_name" => '',
							"active_if" => ['products', 'attributes'],
							"title" => 'attributes',
						],
						[
							"route_name" => '',
							"active_if" => ['products', 'reviews'],
							"title" => 'reviews',
						],
					]
				],
				[
					"route_name" => '',
					"active_if" => ['categories'],
					"icon" => 'folder',
					"title" => 'categories',
					"has_submeu" => false,
					"badge" => '',
				],
				[
					"route_name" => '',
					"active_if" => ['tags'],
					"icon" => 'label',
					"title" => 'tags',
					"has_submeu" => false,
					"badge" => '',
				],
				[
					"route_name" => '',
					"active_if" => ['discounts'],
					"icon" => 'badge-percent',
					"title" => 'discounts',
					"has_submeu" => false,
					"badge" => '',
				],
			],
			[
				[
					"route_name" => '',
					"active_if" => ['customers'],
					"icon" => 'users',
					"title" => 'customers',
					"has_submeu" => false,
					"badge" => '',
				],
				[
					"route_name" => '',
					"active_if" => ['orders'],
					"icon" => 'box',
					"title" => 'orders',
					"has_submeu" => false,
					"badge" => '35',
				],
				[
					"route_name" => '',
					"active_if" => ['invoices'],
					"icon" => 'document',
					"title" => 'invoices',
					"has_submeu" => false,
					"badge" => '',
				]
			],
			[
				[
					"route_name" => '',
					"active_if" => ['analytics'],
					"icon" => 'stats',
					"title" => 'analytics',
					"has_submeu" => true,
					"badge" => '',
					"submenu_items" => [
						[
							"route_name" => '',
							"active_if" => ['analytics', 'overview'],
							"title" => 'overview',
						]
					]
				],
				[
					"route_name" => '',
					"active_if" => ['marketing'],
					"icon" => 'megaphone',
					"title" => 'marketing',
					"has_submeu" => false,
					"badge" => '',
				]
			],
			[
				[
					"route_name" => 'users.index',
					"active_if" => ['users.index', 'users.create', 'users.edit', 'users.profile'],
					"icon" => 'user',
					"title" => 'users',
					"has_submeu" => false,
					"badge" => '',
				],
				[
					"route_name" => 'roles.index',
					"active_if" => ['roles.index', 'roles.create', 'roles.edit'],
					"icon" => 'key',
					"title" => 'roles',
					"has_submeu" => false,
					"badge" => '',
				]
			],
			[
				[
					"route_name" => '',
					"active_if" => ['gallery'],
					"icon" => 'picture',
					"title" => 'gallery',
					"has_submeu" => false,
					"badge" => '',
				],
				[
					"route_name" => '',
					"active_if" => ['languages'],
					"icon" => 'world',
					"title" => 'languages',
					"has_submeu" => false,
					"badge" => '',
				],
				[
					"route_name" => '',
					"active_if" => ['general-settings.index', 'theme_settings', 'store_settings', 'currencies_settings', 'emails_settings', 'payment_settings'],
					"icon" => 'settings',
					"title" => 'settings',
					"has_submeu" => true,
					"badge" => '',
					"submenu_items" => [
						[
							"route_name" => 'general-settings.index',
							"active_if" => ['general-settings.index'],
							"title" => 'general',
						],
						[
							"route_name" => '',
							"active_if" => ['theme_settings'],
							"title" => 'theme',
						],
						[
							"route_name" => '',
							"active_if" => ['store_settings'],
							"title" => 'store',
						],
						[
							"route_name" => '',
							"active_if" => ['currencies_settings'],
							"title" => 'currencies',
						],
						[
							"route_name" => '',
							"active_if" => ['emails_settings'],
							"title" => 'emails',
						],
						[
							"route_name" => '',
							"active_if" => ['payment_settings'],
							"title" => 'payment',
						]
					]
				]
			],
			[
				[
					"route_name" => '',
					"active_if" => ['errors'],
					"icon" => 'browser',
					"title" => 'errors',
					"has_submeu" => true,
					"badge" => '',
					"submenu_items" => [
						[
							"route_name" => '',
							"active_if" => ['400'],
							"title" => '400',
						],
						[
							"route_name" => '',
							"active_if" => ['401'],
							"title" => '401',
						],
						[
							"route_name" => '',
							"active_if" => ['403'],
							"title" => '403',
						],
						[
							"route_name" => '',
							"active_if" => ['404'],
							"title" => '404',
						],
						[
							"route_name" => '',
							"active_if" => ['500'],
							"title" => '500',
						],
						[
							"route_name" => '',
							"active_if" => ['503'],
							"title" => '503',
						]
					]
				],
				[
					"route_name" => '',
					"active_if" => ['errors'],
					"icon" => 'browser',
					"title" => 'auth pages',
					"has_submeu" => true,
					"badge" => '',
					"submenu_items" => [
						[
							"route_name" => '',
							"active_if" => ['login'],
							"title" => 'login',
						],
						[
							"route_name" => '',
							"active_if" => ['register'],
							"title" => 'register',
						],
						[
							"route_name" => '',
							"active_if" => ['forgot-password'],
							"title" => 'forgot password',
						],
						[
							"route_name" => '',
							"active_if" => ['reset-password'],
							"title" => 'reset password',
						],
						[
							"route_name" => '',
							"active_if" => ['2fa-code'],
							"title" => '2fa code',
						],
						[
							"route_name" => '',
							"active_if" => ['2fa-recovery'],
							"title" => '2fa recovery',
						]
					]
				]
			],
		];
	}
}

if (!function_exists('list_of_timezons')) {
	/**
	 * Get GMT time From timezone
	 * @param string $timezone
	 * @return string
	 */
	function toGmtOffset($timezone){
		$userTimeZone = new DateTimeZone($timezone);
		$offset = $userTimeZone->getOffset(new DateTime("now",new DateTimeZone('GMT'))); // Offset in seconds
		$seconds = abs($offset);
		$sign = $offset > 0 ? '+' : '-';
		$hours = floor($seconds / 3600);
		$mins = floor($seconds / 60 % 60);
		$secs = floor($seconds % 60);
		return sprintf("(GMT$sign%02d:%02d)", $hours, $mins, $secs);
	}
}

if (!function_exists('list_of_timezons')) {
	/**
	 * list Of Timezons
	 */
	function list_of_timezons() {
		return [
			''                     => 'No Timezone',
			'Pacific/Midway'       => toGmtOffset('Pacific/Midway'       ). " Midway Island",
            'US/Samoa'             => toGmtOffset('US/Samoa'             ). " Samoa",
            'US/Hawaii'            => toGmtOffset('US/Hawaii'            ). " Hawaii",
            'US/Alaska'            => toGmtOffset('US/Alaska'            ). " Alaska",
            'US/Pacific'           => toGmtOffset('US/Pacific'           ). " Pacific Time (US & Canada)",
            'America/Tijuana'      => toGmtOffset('America/Tijuana'      ). " Tijuana",
            'US/Arizona'           => toGmtOffset('US/Arizona'           ). " Arizona",
            'US/Mountain'          => toGmtOffset('US/Mountain'          ). " Mountain Time (US & Canada)",
            'America/Chihuahua'    => toGmtOffset('America/Chihuahua'    ). " Chihuahua",
            'America/Mazatlan'     => toGmtOffset('America/Mazatlan'     ). " Mazatlan",
            'Canada/Saskatchewan'  => toGmtOffset('Canada/Saskatchewan'  ). " Saskatchewan",
            'America/Mexico_City'  => toGmtOffset('America/Mexico_City'  ). " Mexico City",
            'America/Monterrey'    => toGmtOffset('America/Monterrey'    ). " Monterrey",
            'US/Central'           => toGmtOffset('US/Central'           ). " Central Time (US & Canada)",
            'America/Bogota'       => toGmtOffset('America/Bogota'       ). " Bogota",
            'America/Lima'         => toGmtOffset('America/Lima'         ). " Lima",
            'US/Eastern'           => toGmtOffset('US/Eastern'           ). " Eastern Time (US & Canada)",
            'US/East-Indiana'      => toGmtOffset('US/East-Indiana'      ). " Indiana (East)",
            'America/Caracas'      => toGmtOffset('America/Caracas'      ). " Caracas",
            'America/La_Paz'       => toGmtOffset('America/La_Paz'       ). " La Paz",
            'America/Santiago'     => toGmtOffset('America/Santiago'     ). " Santiago",
            'Canada/Atlantic'      => toGmtOffset('Canada/Atlantic'      ). " Atlantic Time (Canada)",
            'America/Buenos_Aires' => toGmtOffset('America/Buenos_Aires' ). " Buenos Aires",
            'Atlantic/Stanley'     => toGmtOffset('Atlantic/Stanley'     ). " Stanley",
            'Canada/Newfoundland'  => toGmtOffset('Canada/Newfoundland'  ). " Newfoundland",
            'Atlantic/Cape_Verde'  => toGmtOffset('Atlantic/Cape_Verde'  ). " Cape Verde Is.",
            'Atlantic/Azores'      => toGmtOffset('Atlantic/Azores'      ). " Azores",
            'Africa/Monrovia'      => toGmtOffset('Africa/Monrovia'      ). " Monrovia",
            'Africa/Casablanca'    => toGmtOffset('Africa/Casablanca'    ). " Casablanca",
            'Europe/Dublin'        => toGmtOffset('Europe/Dublin'        ). " Dublin",
            'Europe/Lisbon'        => toGmtOffset('Europe/Lisbon'        ). " Lisbon",
            'Europe/London'        => toGmtOffset('Europe/London'        ). " London",
            'Europe/Amsterdam'     => toGmtOffset('Europe/Amsterdam'     ). " Amsterdam",
            'Europe/Belgrade'      => toGmtOffset('Europe/Belgrade'      ). " Belgrade",
            'Europe/Berlin'        => toGmtOffset('Europe/Berlin'        ). " Berlin",
            'Europe/Bratislava'    => toGmtOffset('Europe/Bratislava'    ). " Bratislava",
            'Europe/Brussels'      => toGmtOffset('Europe/Brussels'      ). " Brussels",
            'Europe/Budapest'      => toGmtOffset('Europe/Budapest'      ). " Budapest",
            'Europe/Copenhagen'    => toGmtOffset('Europe/Copenhagen'    ). " Copenhagen",
            'Europe/Ljubljana'     => toGmtOffset('Europe/Ljubljana'     ). " Ljubljana",
            'Europe/Madrid'        => toGmtOffset('Europe/Madrid'        ). " Madrid",
            'Europe/Paris'         => toGmtOffset('Europe/Paris'         ). " Paris",
            'Europe/Prague'        => toGmtOffset('Europe/Prague'        ). " Prague",
            'Europe/Rome'          => toGmtOffset('Europe/Rome'          ). " Rome",
            'Europe/Sarajevo'      => toGmtOffset('Europe/Sarajevo'      ). " Sarajevo",
            'Europe/Skopje'        => toGmtOffset('Europe/Skopje'        ). " Skopje",
            'Europe/Stockholm'     => toGmtOffset('Europe/Stockholm'     ). " Stockholm",
            'Europe/Vienna'        => toGmtOffset('Europe/Vienna'        ). " Vienna",
            'Europe/Warsaw'        => toGmtOffset('Europe/Warsaw'        ). " Warsaw",
            'Europe/Zagreb'        => toGmtOffset('Europe/Zagreb'        ). " Zagreb",
            'Africa/Cairo'         => toGmtOffset('Africa/Cairo'         ). " Cairo",
            'Africa/Harare'        => toGmtOffset('Africa/Harare'        ). " Harare",
            'Europe/Athens'        => toGmtOffset('Europe/Athens'        ). " Athens",
            'Europe/Bucharest'     => toGmtOffset('Europe/Bucharest'     ). " Bucharest",
            'Europe/Helsinki'      => toGmtOffset('Europe/Helsinki'      ). " Helsinki",
            'Europe/Istanbul'      => toGmtOffset('Europe/Istanbul'      ). " Istanbul",
            'Asia/Jerusalem'       => toGmtOffset('Asia/Jerusalem'       ). " Jerusalem",
            'Europe/Kiev'          => toGmtOffset('Europe/Kiev'          ). " Kyiv",
            'Europe/Minsk'         => toGmtOffset('Europe/Minsk'         ). " Minsk",
            'Europe/Riga'          => toGmtOffset('Europe/Riga'          ). " Riga",
            'Europe/Sofia'         => toGmtOffset('Europe/Sofia'         ). " Sofia",
            'Europe/Tallinn'       => toGmtOffset('Europe/Tallinn'       ). " Tallinn",
            'Europe/Vilnius'       => toGmtOffset('Europe/Vilnius'       ). " Vilnius",
            'Asia/Baghdad'         => toGmtOffset('Asia/Baghdad'         ). " Baghdad",
            'Asia/Kuwait'          => toGmtOffset('Asia/Kuwait'          ). " Kuwait",
            'Africa/Nairobi'       => toGmtOffset('Africa/Nairobi'       ). " Nairobi",
            'Asia/Riyadh'          => toGmtOffset('Asia/Riyadh'          ). " Riyadh",
            'Europe/Moscow'        => toGmtOffset('Europe/Moscow'        ). " Moscow",
            'Europe/Volgograd'     => toGmtOffset('Europe/Volgograd'     ). " Volgograd",
            'Asia/Baku'            => toGmtOffset('Asia/Baku'            ). " Baku",
            'Asia/Muscat'          => toGmtOffset('Asia/Muscat'          ). " Muscat",
            'Asia/Tbilisi'         => toGmtOffset('Asia/Tbilisi'         ). " Tbilisi",
            'Asia/Yerevan'         => toGmtOffset('Asia/Yerevan'         ). " Yerevan",
            'Asia/Tehran'          => toGmtOffset('Asia/Tehran'          ). " Tehran",
            'Asia/Kabul'           => toGmtOffset('Asia/Kabul'           ). " Kabul",
            'Asia/Karachi'         => toGmtOffset('Asia/Karachi'         ). " Karachi",
            'Asia/Tashkent'        => toGmtOffset('Asia/Tashkent'        ). " Tashkent",
            'Asia/Yekaterinburg'   => toGmtOffset('Asia/Yekaterinburg'   ). " Ekaterinburg",
            'Asia/Kolkata'         => toGmtOffset('Asia/Kolkata'         ). " Kolkata",
            'Asia/Kathmandu'       => toGmtOffset('Asia/Kathmandu'       ). " Kathmandu",
            'Asia/Almaty'          => toGmtOffset('Asia/Almaty'          ). " Almaty",
            'Asia/Dhaka'           => toGmtOffset('Asia/Dhaka'           ). " Dhaka",
            'Asia/Urumqi'          => toGmtOffset('Asia/Urumqi'          ). " Urumqi",
            'Asia/Novosibirsk'     => toGmtOffset('Asia/Novosibirsk'     ). " Novosibirsk",
            'Asia/Bangkok'         => toGmtOffset('Asia/Bangkok'         ). " Bangkok",
            'Asia/Jakarta'         => toGmtOffset('Asia/Jakarta'         ). " Jakarta",
            'Asia/Krasnoyarsk'     => toGmtOffset('Asia/Krasnoyarsk'     ). " Krasnoyarsk",
            'Asia/Chongqing'       => toGmtOffset('Asia/Chongqing'       ). " Chongqing",
            'Asia/Hong_Kong'       => toGmtOffset('Asia/Hong_Kong'       ). " Hong Kong",
            'Asia/Kuala_Lumpur'    => toGmtOffset('Asia/Kuala_Lumpur'    ). " Kuala Lumpur",
            'Australia/Perth'      => toGmtOffset('Australia/Perth'      ). " Perth",
            'Asia/Singapore'       => toGmtOffset('Asia/Singapore'       ). " Singapore",
            'Asia/Taipei'          => toGmtOffset('Asia/Taipei'          ). " Taipei",
            'Asia/Ulaanbaatar'     => toGmtOffset('Asia/Ulaanbaatar'     ). " Ulaan Bataar",
            'Asia/Irkutsk'         => toGmtOffset('Asia/Irkutsk'         ). " Irkutsk",
            'Asia/Seoul'           => toGmtOffset('Asia/Seoul'           ). " Seoul",
            'Asia/Tokyo'           => toGmtOffset('Asia/Tokyo'           ). " Tokyo",
            'Asia/Yakutsk'         => toGmtOffset('Asia/Yakutsk'         ). " Yakutsk",
            'Australia/Adelaide'   => toGmtOffset('Australia/Adelaide'   ). " Adelaide",
            'Australia/Darwin'     => toGmtOffset('Australia/Darwin'     ). " Darwin",
            'Australia/Brisbane'   => toGmtOffset('Australia/Brisbane'   ). " Brisbane",
            'Australia/Canberra'   => toGmtOffset('Australia/Canberra'   ). " Canberra",
            'Pacific/Guam'         => toGmtOffset('Pacific/Guam'         ). " Guam",
            'Australia/Hobart'     => toGmtOffset('Australia/Hobart'     ). " Hobart",
            'Australia/Melbourne'  => toGmtOffset('Australia/Melbourne'  ). " Melbourne",
            'Pacific/Port_Moresby' => toGmtOffset('Pacific/Port_Moresby' ). " Port Moresby",
            'Australia/Sydney'     => toGmtOffset('Australia/Sydney'     ). " Sydney",
            'Asia/Vladivostok'     => toGmtOffset('Asia/Vladivostok'     ). " Vladivostok",
            'Asia/Magadan'         => toGmtOffset('Asia/Magadan'         ). " Magadan",
            'Pacific/Auckland'     => toGmtOffset('Pacific/Auckland'     ). " Auckland",
            'Pacific/Fiji'         => toGmtOffset('Pacific/Fiji'         ). " Fiji",
		];
	}
}

if (!function_exists('array_to_object')) {
	/**
	 * Convert array to object
	 * @param array $data
	 * @return object
	 */
	function array_to_object($data = [])
	{
		return json_decode(json_encode($data));
	}
}

if (!function_exists('special_char')) {
	/**
	 * Check if string has a special character
	 * @param string $text
	 * @return int|null
	 */
	function special_char($text) {
		return preg_match('/[@_!#$%^&*()<>?\/|}{~:\s]/', $text);
	}
}


if (!function_exists('update_env')) {
	/**
	 * Update .env File Values
	 * @param string $key
	 * @param string $value
	 * @param string $delim
	 */
	function update_env($key, $newValue): void
	{

		$path = base_path('.env');

		// get old value from current env
		$oldValue = env($key);

		// was there any change?
		if ($oldValue === $newValue) {
			return;
		}

		// check if a value has a special character
		$oldValue_sc = special_char($oldValue);
		$newValue_sc = special_char($newValue);

		// add double quotes before and after value if it has special character
		$old_dub_qut = $oldValue_sc > 0 ? '"' : '';
		$new_dub_qut = $newValue_sc > 0 ? '"' : '';

		// URLs don't need to double quotes
		if ( filter_var($oldValue, FILTER_VALIDATE_URL) && filter_var($newValue, FILTER_VALIDATE_URL) ) {
			$old_dub_qut = $new_dub_qut = '';
		}

		// rewrite file content with changed data
		if (file_exists($path)) {
			// replace current value with new value
			file_put_contents(
				$path, str_replace(
					$key . '=' . $old_dub_qut . $oldValue . $old_dub_qut,
					$key . '=' . $new_dub_qut . $newValue . $new_dub_qut,
					file_get_contents($path)
				)
			);
		}
	}
}

if ( !function_exists('selected') ) {
	/**
	 * check if list item is selected item
	 * @param string $db_value
	 * @param string $list_value
	 * @param string $input_type
	 * @return string
	 */
	function selected($db_value, $list_value, $input_type) {

		switch ($input_type) {
			case 'select':
				$sel = 'selected';
				break;
			case 'checkbox':
			case 'radio':
				$sel = 'checked';
				break;
			default:
				$sel = 'selected';
				break;
		}
		return $db_value == $list_value ? $sel : '';
	}
}

if ( !function_exists('format_date') ) {
	/**
	 * change Database date Format
	 * @param datetime $date
	 * @return string
	 */
	function format_date($date) {
		return date_format($date, 'd/m/Y H:i');
	}
}

if ( !function_exists('user_full_name') ) {
	/**
	 * User full name
	 * @return string
	 */
	function user_full_name() {
		if ( !auth()->user() ) {
			return;
		}

		return auth()->user()->first_name . ' ' . auth()->user()->last_name;
	}
}
