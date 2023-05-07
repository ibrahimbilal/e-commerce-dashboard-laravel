<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;

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
				'allow_to' => ['view dashboard'],
				'group_items' => [
					[
						"route_name" => 'admin.index',
						"active_if" => ['admin.index'],
						"icon" => 'apps',
						"title" => __('admin.menu.dashboard.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view dashboard'],
					]
				]
			],
			[
				'allow_to' => ['view products', 'view attributes', 'view reviews', 'view categories', 'view tags', 'view discounts'],
				'group_items' => [
					[
						"route_name" => '',
						"active_if" => ['products'],
						"icon" => 'shopping-bag',
						"title" => __('admin.menu.products.title'),
						"has_submeu" => true,
						"badge" => '',
						'permission' => ['view products'],
						"submenu_items" => [
							[
								"route_name" => '',
								"active_if" => ['products', 'attributes'],
								"title" => __('admin.menu.attributes.title'),
								'permission' => ['view attributes'],
							],
							[
								"route_name" => '',
								"active_if" => ['products', 'reviews'],
								"title" => __('admin.menu.reviews.title'),
								'permission' => ['view reviews'],
							],
						]
					],
					[
						"route_name" => '',
						"active_if" => ['categories'],
						"icon" => 'folder',
						"title" => __('admin.menu.categories.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view categories'],
					],
					[
						"route_name" => '',
						"active_if" => ['tags'],
						"icon" => 'label',
						"title" => __('admin.menu.tags.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view tags'],
					],
					[
						"route_name" => '',
						"active_if" => ['discounts'],
						"icon" => 'badge-percent',
						"title" => __('admin.menu.discounts.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view discounts'],
					]
				]
			],
			[
				'allow_to' => ['view customers', 'view orders', 'view invoices'],
				'group_items' => [
					[
						"route_name" => '',
						"active_if" => ['customers'],
						"icon" => 'users',
						"title" => __('admin.menu.customers.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view customers'],
					],
					[
						"route_name" => '',
						"active_if" => ['orders'],
						"icon" => 'box',
						"title" => __('admin.menu.orders.title'),
						"has_submeu" => false,
						"badge" => '35',
						'permission' => ['view orders'],
					],
					[
						"route_name" => '',
						"active_if" => ['invoices'],
						"icon" => 'document',
						"title" => __('admin.menu.invoices.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view invoices'],
					]
				]
			],
			[
				'allow_to' => ['view analytics', 'view marketing'],
				'group_items' => [
					[
						"route_name" => '',
						"active_if" => ['analytics'],
						"icon" => 'stats',
						"title" => __('admin.menu.analytics.title'),
						"has_submeu" => true,
						"badge" => '',
						'permission' => ['view analytics'],
						"submenu_items" => [
							[
								"route_name" => '',
								"active_if" => ['analytics', 'overview'],
								"title" => __('admin.menu.analytics.0.overview'),
								'permission' => ['view overview'],
							]
						]
					],
					[
						"route_name" => '',
						"active_if" => ['marketing'],
						"icon" => 'megaphone',
						"title" => __('admin.menu.marketing.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view marketing'],
					]
				]
			],
			[
				'allow_to' => ['view users', 'view roles'],
				'group_items' => [
					[
						"route_name" => 'users.index',
						"active_if" => ['users.index', 'users.create', 'users.edit', 'users.profile'],
						"icon" => 'user',
						"title" => __('admin.menu.users.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view users'],
					],
					[
						"route_name" => 'roles.index',
						"active_if" => ['roles.index', 'roles.create', 'roles.edit'],
						"icon" => 'key',
						"title" => __('admin.menu.roles.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view roles'],
					]
				]
			],
			[
				'allow_to' => [
					'view gallery',
					'view languages',
					'view general_settings',
					'view theme_settings',
					'view store_settings',
					'view currencies_settings',
					'view emails_settings',
					'view payment_settings',
				],
				'group_items' => [
					[
						"route_name" => '',
						"active_if" => ['gallery'],
						"icon" => 'picture',
						"title" => __('admin.menu.gallery.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view gallery'],
					],
					[
						"route_name" => 'langs.index',
						"active_if" => ['languages'],
						"icon" => 'world',
						"title" => __('admin.menu.languages.title'),
						"has_submeu" => false,
						"badge" => '',
						'permission' => ['view languages'],
					],
					[
						"route_name" => '',
						"active_if" => ['general-settings.index', 'theme_settings', 'store_settings', 'currencies_settings', 'emails_settings', 'payment_settings'],
						"icon" => 'settings',
						"title" => __('admin.menu.settings.title'),
						"has_submeu" => true,
						"badge" => '',
						'permission' => [
							'view general_settings',
							'view theme_settings',
							'view store_settings',
							'view currencies_settings',
							'view emails_settings',
							'view payment_settings',
						],
						"submenu_items" => [
							[
								"route_name" => 'general-settings.index',
								"active_if" => ['general-settings.index'],
								"title" => __('admin.menu.settings.0.general'),
								'permission' => ['view general_settings'],
							],
							[
								"route_name" => '',
								"active_if" => ['theme_settings'],
								"title" => __('admin.menu.settings.0.theme'),
								'permission' => ['view theme_settings'],
							],
							[
								"route_name" => '',
								"active_if" => ['store_settings'],
								"title" => __('admin.menu.settings.0.store'),
								'permission' => ['view store_settings'],
							],
							[
								"route_name" => '',
								"active_if" => ['currencies_settings'],
								"title" => __('admin.menu.settings.0.currencies'),
								'permission' => ['view currencies_settings'],
							],
							[
								"route_name" => '',
								"active_if" => ['emails_settings'],
								"title" => __('admin.menu.settings.0.emails'),
								'permission' => ['view emails_settings'],
							],
							[
								"route_name" => '',
								"active_if" => ['payment_settings'],
								"title" => __('admin.menu.settings.0.payment'),
								'permission' => ['view payment_settings'],
							]
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
	function toGmtOffset($timezone)
	{
		$userTimeZone = new DateTimeZone($timezone);
		$offset = $userTimeZone->getOffset(new DateTime("now", new DateTimeZone('GMT'))); // Offset in seconds
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
	function list_of_timezons()
	{
		return [
			''                     => 'No Timezone',
			'Pacific/Midway'       => toGmtOffset('Pacific/Midway') . " Midway Island",
			'US/Samoa'             => toGmtOffset('US/Samoa') . " Samoa",
			'US/Hawaii'            => toGmtOffset('US/Hawaii') . " Hawaii",
			'US/Alaska'            => toGmtOffset('US/Alaska') . " Alaska",
			'US/Pacific'           => toGmtOffset('US/Pacific') . " Pacific Time (US & Canada)",
			'America/Tijuana'      => toGmtOffset('America/Tijuana') . " Tijuana",
			'US/Arizona'           => toGmtOffset('US/Arizona') . " Arizona",
			'US/Mountain'          => toGmtOffset('US/Mountain') . " Mountain Time (US & Canada)",
			'America/Chihuahua'    => toGmtOffset('America/Chihuahua') . " Chihuahua",
			'America/Mazatlan'     => toGmtOffset('America/Mazatlan') . " Mazatlan",
			'Canada/Saskatchewan'  => toGmtOffset('Canada/Saskatchewan') . " Saskatchewan",
			'America/Mexico_City'  => toGmtOffset('America/Mexico_City') . " Mexico City",
			'America/Monterrey'    => toGmtOffset('America/Monterrey') . " Monterrey",
			'US/Central'           => toGmtOffset('US/Central') . " Central Time (US & Canada)",
			'America/Bogota'       => toGmtOffset('America/Bogota') . " Bogota",
			'America/Lima'         => toGmtOffset('America/Lima') . " Lima",
			'US/Eastern'           => toGmtOffset('US/Eastern') . " Eastern Time (US & Canada)",
			'US/East-Indiana'      => toGmtOffset('US/East-Indiana') . " Indiana (East)",
			'America/Caracas'      => toGmtOffset('America/Caracas') . " Caracas",
			'America/La_Paz'       => toGmtOffset('America/La_Paz') . " La Paz",
			'America/Santiago'     => toGmtOffset('America/Santiago') . " Santiago",
			'Canada/Atlantic'      => toGmtOffset('Canada/Atlantic') . " Atlantic Time (Canada)",
			'America/Buenos_Aires' => toGmtOffset('America/Buenos_Aires') . " Buenos Aires",
			'Atlantic/Stanley'     => toGmtOffset('Atlantic/Stanley') . " Stanley",
			'Canada/Newfoundland'  => toGmtOffset('Canada/Newfoundland') . " Newfoundland",
			'Atlantic/Cape_Verde'  => toGmtOffset('Atlantic/Cape_Verde') . " Cape Verde Is.",
			'Atlantic/Azores'      => toGmtOffset('Atlantic/Azores') . " Azores",
			'Africa/Monrovia'      => toGmtOffset('Africa/Monrovia') . " Monrovia",
			'Africa/Casablanca'    => toGmtOffset('Africa/Casablanca') . " Casablanca",
			'Europe/Dublin'        => toGmtOffset('Europe/Dublin') . " Dublin",
			'Europe/Lisbon'        => toGmtOffset('Europe/Lisbon') . " Lisbon",
			'Europe/London'        => toGmtOffset('Europe/London') . " London",
			'Europe/Amsterdam'     => toGmtOffset('Europe/Amsterdam') . " Amsterdam",
			'Europe/Belgrade'      => toGmtOffset('Europe/Belgrade') . " Belgrade",
			'Europe/Berlin'        => toGmtOffset('Europe/Berlin') . " Berlin",
			'Europe/Bratislava'    => toGmtOffset('Europe/Bratislava') . " Bratislava",
			'Europe/Brussels'      => toGmtOffset('Europe/Brussels') . " Brussels",
			'Europe/Budapest'      => toGmtOffset('Europe/Budapest') . " Budapest",
			'Europe/Copenhagen'    => toGmtOffset('Europe/Copenhagen') . " Copenhagen",
			'Europe/Ljubljana'     => toGmtOffset('Europe/Ljubljana') . " Ljubljana",
			'Europe/Madrid'        => toGmtOffset('Europe/Madrid') . " Madrid",
			'Europe/Paris'         => toGmtOffset('Europe/Paris') . " Paris",
			'Europe/Prague'        => toGmtOffset('Europe/Prague') . " Prague",
			'Europe/Rome'          => toGmtOffset('Europe/Rome') . " Rome",
			'Europe/Sarajevo'      => toGmtOffset('Europe/Sarajevo') . " Sarajevo",
			'Europe/Skopje'        => toGmtOffset('Europe/Skopje') . " Skopje",
			'Europe/Stockholm'     => toGmtOffset('Europe/Stockholm') . " Stockholm",
			'Europe/Vienna'        => toGmtOffset('Europe/Vienna') . " Vienna",
			'Europe/Warsaw'        => toGmtOffset('Europe/Warsaw') . " Warsaw",
			'Europe/Zagreb'        => toGmtOffset('Europe/Zagreb') . " Zagreb",
			'Africa/Cairo'         => toGmtOffset('Africa/Cairo') . " Cairo",
			'Africa/Harare'        => toGmtOffset('Africa/Harare') . " Harare",
			'Europe/Athens'        => toGmtOffset('Europe/Athens') . " Athens",
			'Europe/Bucharest'     => toGmtOffset('Europe/Bucharest') . " Bucharest",
			'Europe/Helsinki'      => toGmtOffset('Europe/Helsinki') . " Helsinki",
			'Europe/Istanbul'      => toGmtOffset('Europe/Istanbul') . " Istanbul",
			'Asia/Jerusalem'       => toGmtOffset('Asia/Jerusalem') . " Jerusalem",
			'Europe/Kiev'          => toGmtOffset('Europe/Kiev') . " Kyiv",
			'Europe/Minsk'         => toGmtOffset('Europe/Minsk') . " Minsk",
			'Europe/Riga'          => toGmtOffset('Europe/Riga') . " Riga",
			'Europe/Sofia'         => toGmtOffset('Europe/Sofia') . " Sofia",
			'Europe/Tallinn'       => toGmtOffset('Europe/Tallinn') . " Tallinn",
			'Europe/Vilnius'       => toGmtOffset('Europe/Vilnius') . " Vilnius",
			'Asia/Baghdad'         => toGmtOffset('Asia/Baghdad') . " Baghdad",
			'Asia/Kuwait'          => toGmtOffset('Asia/Kuwait') . " Kuwait",
			'Africa/Nairobi'       => toGmtOffset('Africa/Nairobi') . " Nairobi",
			'Asia/Riyadh'          => toGmtOffset('Asia/Riyadh') . " Riyadh",
			'Europe/Moscow'        => toGmtOffset('Europe/Moscow') . " Moscow",
			'Europe/Volgograd'     => toGmtOffset('Europe/Volgograd') . " Volgograd",
			'Asia/Baku'            => toGmtOffset('Asia/Baku') . " Baku",
			'Asia/Muscat'          => toGmtOffset('Asia/Muscat') . " Muscat",
			'Asia/Tbilisi'         => toGmtOffset('Asia/Tbilisi') . " Tbilisi",
			'Asia/Yerevan'         => toGmtOffset('Asia/Yerevan') . " Yerevan",
			'Asia/Tehran'          => toGmtOffset('Asia/Tehran') . " Tehran",
			'Asia/Kabul'           => toGmtOffset('Asia/Kabul') . " Kabul",
			'Asia/Karachi'         => toGmtOffset('Asia/Karachi') . " Karachi",
			'Asia/Tashkent'        => toGmtOffset('Asia/Tashkent') . " Tashkent",
			'Asia/Yekaterinburg'   => toGmtOffset('Asia/Yekaterinburg') . " Ekaterinburg",
			'Asia/Kolkata'         => toGmtOffset('Asia/Kolkata') . " Kolkata",
			'Asia/Kathmandu'       => toGmtOffset('Asia/Kathmandu') . " Kathmandu",
			'Asia/Almaty'          => toGmtOffset('Asia/Almaty') . " Almaty",
			'Asia/Dhaka'           => toGmtOffset('Asia/Dhaka') . " Dhaka",
			'Asia/Urumqi'          => toGmtOffset('Asia/Urumqi') . " Urumqi",
			'Asia/Novosibirsk'     => toGmtOffset('Asia/Novosibirsk') . " Novosibirsk",
			'Asia/Bangkok'         => toGmtOffset('Asia/Bangkok') . " Bangkok",
			'Asia/Jakarta'         => toGmtOffset('Asia/Jakarta') . " Jakarta",
			'Asia/Krasnoyarsk'     => toGmtOffset('Asia/Krasnoyarsk') . " Krasnoyarsk",
			'Asia/Chongqing'       => toGmtOffset('Asia/Chongqing') . " Chongqing",
			'Asia/Hong_Kong'       => toGmtOffset('Asia/Hong_Kong') . " Hong Kong",
			'Asia/Kuala_Lumpur'    => toGmtOffset('Asia/Kuala_Lumpur') . " Kuala Lumpur",
			'Australia/Perth'      => toGmtOffset('Australia/Perth') . " Perth",
			'Asia/Singapore'       => toGmtOffset('Asia/Singapore') . " Singapore",
			'Asia/Taipei'          => toGmtOffset('Asia/Taipei') . " Taipei",
			'Asia/Ulaanbaatar'     => toGmtOffset('Asia/Ulaanbaatar') . " Ulaan Bataar",
			'Asia/Irkutsk'         => toGmtOffset('Asia/Irkutsk') . " Irkutsk",
			'Asia/Seoul'           => toGmtOffset('Asia/Seoul') . " Seoul",
			'Asia/Tokyo'           => toGmtOffset('Asia/Tokyo') . " Tokyo",
			'Asia/Yakutsk'         => toGmtOffset('Asia/Yakutsk') . " Yakutsk",
			'Australia/Adelaide'   => toGmtOffset('Australia/Adelaide') . " Adelaide",
			'Australia/Darwin'     => toGmtOffset('Australia/Darwin') . " Darwin",
			'Australia/Brisbane'   => toGmtOffset('Australia/Brisbane') . " Brisbane",
			'Australia/Canberra'   => toGmtOffset('Australia/Canberra') . " Canberra",
			'Pacific/Guam'         => toGmtOffset('Pacific/Guam') . " Guam",
			'Australia/Hobart'     => toGmtOffset('Australia/Hobart') . " Hobart",
			'Australia/Melbourne'  => toGmtOffset('Australia/Melbourne') . " Melbourne",
			'Pacific/Port_Moresby' => toGmtOffset('Pacific/Port_Moresby') . " Port Moresby",
			'Australia/Sydney'     => toGmtOffset('Australia/Sydney') . " Sydney",
			'Asia/Vladivostok'     => toGmtOffset('Asia/Vladivostok') . " Vladivostok",
			'Asia/Magadan'         => toGmtOffset('Asia/Magadan') . " Magadan",
			'Pacific/Auckland'     => toGmtOffset('Pacific/Auckland') . " Auckland",
			'Pacific/Fiji'         => toGmtOffset('Pacific/Fiji') . " Fiji",
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
	function special_char($text)
	{
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
		if (filter_var($oldValue, FILTER_VALIDATE_URL) && filter_var($newValue, FILTER_VALIDATE_URL)) {
			$old_dub_qut = $new_dub_qut = '';
		}

		// rewrite file content with changed data
		if (file_exists($path)) {
			// replace current value with new value
			file_put_contents(
				$path,
				str_replace(
					$key . '=' . $old_dub_qut . $oldValue . $old_dub_qut,
					$key . '=' . $new_dub_qut . $newValue . $new_dub_qut,
					file_get_contents($path)
				)
			);
		}
	}
}

if (!function_exists('format_date')) {
	/**
	 * change Database date Format
	 * @param datetime $date
	 * @return string
	 */
	function format_date($date)
	{
		return date_format($date, 'd/m/Y H:i');
	}
}

if (!function_exists('user_full_name')) {
	/**
	 * User full name
	 * @return string
	 */
	function user_full_name()
	{
		if (!auth()->user()) {
			return 'Unknown';
		}

		return auth()->user()->first_name . ' ' . auth()->user()->last_name;
	}
}

if (!function_exists('is_rtl')) {
	/**
	 * Determines whether the current locale is right-to-left (RTL).
	 * @return bool Whether locale is RTL.
	 */
	function is_rtl()
	{
		$app_lang = app()->getLocale();
		$rtl_locales = ['ar', 'arc', 'dv', 'fa', 'ha', 'he', 'khw', 'ks', 'ku', 'ps', 'ur', 'yi'];

		return in_array($app_lang, $rtl_locales);
	}
}

if (!function_exists('permissions_name')) {

	/**
	 * Permissions Name
	 * @param string $perm_name
	 * @param string $field
	 * @return string
	 */
	function permissions_name($perm_name, $field = 'name')
	{
		if (!$perm_name) {
			return;
		}

		switch (count(explode(' ', $perm_name))) {
			case 1:
				$perm_prefix = '';
				$perm_text = $perm_name;
				break;
			case 2:
				$perm_prefix = explode(' ', $perm_name)[0];
				$perm_text = explode(' ', $perm_name)[1];
				break;
			case 3:
				$perm_prefix = explode(' ', $perm_name)[0];
				$perm_text = explode(' ', $perm_name)[1] . ' ' . explode(' ', $perm_name)[2];
				break;
			default:
				$perm_prefix = '';
				$perm_text = '';
				break;
		}

		switch ($field) {
			case 'name':
				return $perm_text;
				break;

			case 'prefix':
				return $perm_prefix;
				break;

			default:
				return 'Please Select name or prefix!';
				break;
		}
	}
}

if (!function_exists('grouping_sections_premissions')) {

	/**
	 * get permissions grouped by sections
	 * @return collection
	 */
	function grouping_sections_premissions()
	{
		// our app sections
		$sections = [
			'dashboard',
			'products',
			'attributes',
			'reviews',
			'categories',
			'tags',
			'discounts',
			'customers',
			'orders',
			'invoices',
			'analytics',
			'marketing',
			'users',
			'roles',
			'gallery',
			'languages',
			'settings',
			'imports',
			'exports'
		];

		// get all premissions
		$permissions = Permission::all();

		// new collection
		$collection = collect();
		foreach ($sections as $section) {
			// put every section permissions in one collect
			$collection->push($permissions->filter(function ($perm) use ($section) {
				if (Str::contains($perm->name, $section)) {
					return $perm->name;
				}
			}));
		}

		// grouping (sections permissions) by section name
		// return = 'section' => [permissions]
		$grouped = $collection->groupBy(function ($item, $key) {
			$name = explode(' ', $item->value('name'));
			return substr($item->value('name'), -strlen(end($name)));
		});

		return $grouped;
	}
}

if ( !function_exists('available_languages') ) {

	/**
	 * Get Available languages in the system
	 * @return Array
	 */
	function available_languages() {
		$filtered = ['.', '..'];

        $langs = [];
        $d = dir(App::langPath());
        while (($entry = $d->read()) !== false) {
            if (is_dir(App::langPath() . '/' . $entry) && !in_array($entry, $filtered)) {
                $langs[] = [
					"code" => $entry,
					"name" => langs_list($entry)
				];
            }
        }

		return $langs;
	}
}

if (!function_exists('langs_list')) {

	/**
	 * Get Language Name by code
	 * @return String
	 */
	function langs_list($code = '') {
		// count 142
		$languages_list = array(
			"af" => "Afrikaans",
			"sq" => "Albanian - shqip",
			"am" => "Amharic - አማርኛ",
			"ar" => "Arabic - العربية",
			"an" => "Aragonese - aragonés",
			"hy" => "Armenian - հայերեն",
			"ast" => "Asturian - asturianu",
			"az" => "Azerbaijani - azərbaycan dili",
			"eu" => "Basque - euskara",
			"be" => "Belarusian - беларуская",
			"bn" => "Bengali - বাংলা",
			"bs" => "Bosnian - bosanski",
			"br" => "Breton - brezhoneg",
			"bg" => "Bulgarian - български",
			"ca" => "Catalan - català",
			"ckb" => "Central Kurdish - کوردی (دەستنوسی عەرەبی)",
			"zh" => "Chinese - 中文",
			"zh-HK" => "Chinese (Hong Kong) - 中文（香港）",
			"zh-CN" => "Chinese (Simplified) - 中文（简体）",
			"zh-TW" => "Chinese (Traditional) - 中文（繁體）",
			"co" => "Corsican",
			"hr" => "Croatian - hrvatski",
			"cs" => "Czech - čeština",
			"da" => "Danish - dansk",
			"nl" => "Dutch - Nederlands",
			"en" => "English",
			"en-AU" => "English (Australia)",
			"en-CA" => "English (Canada)",
			"en-IN" => "English (India)",
			"en-NZ" => "English (New Zealand)",
			"en-ZA" => "English (South Africa)",
			"en-GB" => "English (United Kingdom)",
			"en-US" => "English (United States)",
			"eo" => "Esperanto - esperanto",
			"et" => "Estonian - eesti",
			"fo" => "Faroese - føroyskt",
			"fil" => "Filipino",
			"fi" => "Finnish - suomi",
			"fr" => "French - français",
			"fr-CA" => "French (Canada) - français (Canada)",
			"fr-FR" => "French (France) - français (France)",
			"fr-CH" => "French (Switzerland) - français (Suisse)",
			"gl" => "Galician - galego",
			"ka" => "Georgian - ქართული",
			"de" => "German - Deutsch",
			"de-AT" => "German (Austria) - Deutsch (Österreich)",
			"de-DE" => "German (Germany) - Deutsch (Deutschland)",
			"de-LI" => "German (Liechtenstein) - Deutsch (Liechtenstein)",
			"de-CH" => "German (Switzerland) - Deutsch (Schweiz)",
			"el" => "Greek - Ελληνικά",
			"gn" => "Guarani",
			"gu" => "Gujarati - ગુજરાતી",
			"ha" => "Hausa",
			"haw" => "Hawaiian - ʻŌlelo Hawaiʻi",
			"he" => "Hebrew - עברית",
			"hi" => "Hindi - हिन्दी",
			"hu" => "Hungarian - magyar",
			"is" => "Icelandic - íslenska",
			"id" => "Indonesian - Indonesia",
			"ia" => "Interlingua",
			"ga" => "Irish - Gaeilge",
			"it" => "Italian - italiano",
			"it-IT" => "Italian (Italy) - italiano (Italia)",
			"it-CH" => "Italian (Switzerland) - italiano (Svizzera)",
			"ja" => "Japanese - 日本語",
			"kn" => "Kannada - ಕನ್ನಡ",
			"kk" => "Kazakh - қазақ тілі",
			"km" => "Khmer - ខ្មែរ",
			"ko" => "Korean - 한국어",
			"ku" => "Kurdish - Kurdî",
			"ky" => "Kyrgyz - кыргызча",
			"lo" => "Lao - ລາວ",
			"la" => "Latin",
			"lv" => "Latvian - latviešu",
			"ln" => "Lingala - lingála",
			"lt" => "Lithuanian - lietuvių",
			"mk" => "Macedonian - македонски",
			"ms" => "Malay - Bahasa Melayu",
			"ml" => "Malayalam - മലയാളം",
			"mt" => "Maltese - Malti",
			"mr" => "Marathi - मराठी",
			"mn" => "Mongolian - монгол",
			"ne" => "Nepali - नेपाली",
			"no" => "Norwegian - norsk",
			"nb" => "Norwegian Bokmål - norsk bokmål",
			"nn" => "Norwegian Nynorsk - nynorsk",
			"oc" => "Occitan",
			"or" => "Oriya - ଓଡ଼ିଆ",
			"om" => "Oromo - Oromoo",
			"ps" => "Pashto - پښتو",
			"fa" => "Persian - فارسی",
			"pl" => "Polish - polski",
			"pt" => "Portuguese - português",
			"pt-BR" => "Portuguese (Brazil) - português (Brasil)",
			"pt-PT" => "Portuguese (Portugal) - português (Portugal)",
			"pa" => "Punjabi - ਪੰਜਾਬੀ",
			"qu" => "Quechua",
			"ro" => "Romanian - română",
			"mo" => "Romanian (Moldova) - română (Moldova)",
			"rm" => "Romansh - rumantsch",
			"ru" => "Russian - русский",
			"gd" => "Scottish Gaelic",
			"sr" => "Serbian - српски",
			"sh" => "Serbo - Croatian",
			"sn" => "Shona - chiShona",
			"sd" => "Sindhi",
			"si" => "Sinhala - සිංහල",
			"sk" => "Slovak - slovenčina",
			"sl" => "Slovenian - slovenščina",
			"so" => "Somali - Soomaali",
			"st" => "Southern Sotho",
			"es" => "Spanish - español",
			"es-AR" => "Spanish (Argentina) - español (Argentina)",
			"es-419" => "Spanish (Latin America) - español (Latinoamérica)",
			"es-MX" => "Spanish (Mexico) - español (México)",
			"es-ES" => "Spanish (Spain) - español (España)",
			"es-US" => "Spanish (United States) - español (Estados Unidos)",
			"su" => "Sundanese",
			"sw" => "Swahili - Kiswahili",
			"sv" => "Swedish - svenska",
			"tg" => "Tajik - тоҷикӣ",
			"ta" => "Tamil - தமிழ்",
			"tt" => "Tatar",
			"te" => "Telugu - తెలుగు",
			"th" => "Thai - ไทย",
			"ti" => "Tigrinya - ትግርኛ",
			"to" => "Tongan - lea fakatonga",
			"tr" => "Turkish - Türkçe",
			"tk" => "Turkmen",
			"tw" => "Twi",
			"uk" => "Ukrainian - українська",
			"ur" => "Urdu - اردو",
			"ug" => "Uyghur",
			"uz" => "Uzbek - o‘zbek",
			"vi" => "Vietnamese - Tiếng Việt",
			"wa" => "Walloon - wa",
			"cy" => "Welsh - Cymraeg",
			"fy" => "Western Frisian",
			"xh" => "Xhosa",
			"yi" => "Yiddish",
			"yo" => "Yoruba - Èdè Yorùbá",
			"zu" => "Zulu - isiZulu"
		);

		if ( !empty($code) ) {
			return array_key_exists($code, $languages_list) ? $languages_list[$code] : 'Unknown';
		} else {
			return $languages_list;
		}

	}
}
