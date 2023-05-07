<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Overview Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Overview for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
	'menu' => [
		'dashboard' => [
			'title' => 'Dashboard'
		],
		'products' => [
			'title' => 'Products'
		],
		'attributes' => [
			'title' => 'Attributes'
		],
		'reviews' => [
			'title' => 'Reviews'
		],
		'categories' => [
			'title' => 'Categories'
		],
		'tags' => [
			'title' => 'Tags'
		],
		'discounts' => [
			'title' => 'Discounts',
		],
		'customers' => [
			'title' => 'Customers',
		],
		'orders' => [
			'title' => 'Orders',
		],
		'invoices' => [
			'title' => 'Invoices',
		],
		'analytics' => [
			'title' => 'Analytics',
			[
				'overview' => 'Overview'
			]
		],
		'marketing' => [
			'title' => 'Marketing',
		],
		'users' => [
			'title' => 'Users',
			'profile' => 'Profile',
			'add' => 'Add User',
			'edit' => 'Edit User',
		],
		'roles' => [
			'title' => 'Roles',
			'add' => 'Add Role',
			'edit' => 'Edit Role',
		],
		'gallery' => [
			'title' => 'Gallery',
		],
		'languages' => [
			'title' => 'Languages',
			'add' => 'Add Language',
			'edit' => 'Edit Language',
		],
		'settings' => [
			'title' => 'Settings',
			[
				'general' => 'General',
				'theme' => 'Theme',
				'store' => 'Store',
				'currencies' => 'Currencies',
				'emails' => 'Emails',
				'payment' => 'Payment',
			]
		],
		'errors' => 'Errors',
		'auth' => [
			'title' => 'Auth',
			[
				'login' => 'Login',
				'register' => 'Register',
				'forgot_password' => 'Forgot password',
				'reset_password' => 'Reset password',
				'2fa_code' => '2fa code',
				'2fa_recovery' => '2fa recovery',
			]
		],
		'collapse' => 'Collapse',
		'imports' => [
			'title' => 'Imports'
		],
		'exports' => [
			'title' => 'Exports'
		],

		'general_settings' => [
			'title' => 'General Settings'
		],
		'theme_settings' => [
			'title' => 'Theme Settings'
		],
		'store_settings' => [
			'title' => 'Store Settings'
		],
		'currencies_settings' => [
			'title' => 'Currencies Settings'
		],
		'emails_settings' => [
			'title' => 'Emails Settings'
		],
		'payment_settings' => [
			'title' => 'Payment Settings'
		],
	],

	"overview" => [
		'customers' => 'Customers',
		"orders" => "Orders",
		"sales" => "Sales",
		"subscribers" => "Subscribers",
		"top_selling" => "Top Selling Products",
		"visitors_referrals" => "Visitors Referrals",
		"orders_statuses" => "Orders Statuses",
	],

	'header' => [
		'search' => [
			'placeholder' => 'Search Here...'
		],
		'profile' => 'My account',
		'logout' => 'Log out',
		'view_all' => 'View all',
		'mark_all_read' => 'Mark all as read',
		'notifications' => [
			'title' => 'Notifications'
		],
		'messages' => [
			'title' => 'Messages'
		],
		'tooltips' => [
			'full_screen' => 'Full Screen',
			'exit_full_screen' => 'Exit Full Screen',
			'dark_mode' => 'Dark Mode',
			'light_mode' => 'Light Mode',
		]
	],

	'pages' => [
		'users' => [
			'two_factor' => [
				'sub_section' => 'Status:',
				'recovery_codes_notify' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.',
				'desciption' => 'When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.',
				'finish' => 'To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code',
				'status' => [
					'enable' => 'You have enabled 2FA',
					'disable' => '2FA Is Disabled',
				],
				'setup_key' => 'Setup Key',
				'buttons' => [
					'enable' => 'Enable',
					'disable' => 'Disable',
					'show' => 'Show Recovery Codes',
					'generate' => 'Regenerate Recovery Codes',
					'cancel' => 'Cancel',
					'confirm' => 'Confirm',
				],
				'enabled' => 'Two factor authentication enabled, please confirm it.',
				'disabled' => 'Two factor authentication disabled.',
				'confirmed' => 'Two factor authentication confirmed.',
			],
			'sessions' => [
				'desc_1' => 'Manage and log out your active sessions on other browsers and devices.',
				'desc_2' => 'If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.',
				'sub_section' => 'Active Sessions:',
				'this_device' => 'This device',
				'last_active' => 'Last active',
			]
		],

		'roles' => [
			'no_permissions' => 'There is no permissions created!'
		]
	],

	'sections' => [
		'user_details' => 'User Details',
		'sessions' => 'Browser Sessions',
		'two_factor' => 'Two Factor Authentication',
		'activities' => 'Activities',
		'password' => 'Change Password',
		'role_name' => 'Role Name',
		'permissions' => 'Permissions',
		'general_settings' => 'General Settings'
	],

	'filters' => [
		'all' => 'All',
		'trashed' => 'Trashed'
	],
	'unknown' => 'Unknown',

	/*
    |--------------------------------------------------------------------------
    | Prefixs
    |--------------------------------------------------------------------------
    */

	'prefix' => [
		'view' => 'View',
		'add' => 'Add',
		'edit' => 'Edit',
		'delete' => 'Delete',
		'permanently_delete' => 'Permanently Delete',
		'restore' => 'Restore',
		'' => '',
	]
];
