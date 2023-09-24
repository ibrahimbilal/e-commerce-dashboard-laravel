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
			'title' => 'لوحة التحكم'
		],
		'products' => [
			'title' => 'المنتجات'
		],
		'attributes' => [
			'title' => 'الخواص'
		],
		'reviews' => [
			'title' => 'المراجعات'
		],
		'categories' => [
			'title' => 'التصنيفات'
		],
		'tags' => [
			'title' => 'الوسوم'
		],
		'discounts' => [
			'title' => 'الحسومات'
		],
		'customers' => [
			'title' => 'العملاء'
		],
		'orders' => [
			'title' => 'الطلبات'
		],
		'invoices' => [
			'title' => 'الفواتير'
		],
		'analytics' => [
			'title' => 'التحليلات',
			[
				'overview' => 'نظرة عامة'
			]
		],
		'marketing' => [
			'title' => 'التسويق'
		],
		'users' => [
			'title' => 'المستخدمون',
			'profile' => 'حسابي',
			'add' => 'اضافة مستخدم',
			'edit' => 'تعديل المستخدم',
		],
		'roles' => [
			'title' => 'الأدوار',
			'add' => 'اضافة دور',
			'edit' => 'تعديل الدور',
		],
		'gallery' => [
			'title' => 'المعرض'
		],
		'languages' => [
			'title' => 'اللغات',
			'add' => 'إضافة لغة',
			'edit' => 'تعديل اللغة',
		],
		'settings' => [
			'title' => 'الإعدادات',
			[
				'general' => 'العامة',
				'theme' => 'القالب',
				'store' => 'المتجر',
				'currencies' => 'العملات',
				'emails' => 'البريد الالكتروني',
				'payment' => 'الدفع',
			]
		],
		'errors' => 'الأخطاء',
		'auth' => [
			'title' => 'المصادقة',
			[
				'login' => 'تسجيل الدخول',
				'register' => 'التسجيل',
				'forgot_password' => 'ن. كلمة المرور',
				'reset_password' => 'تعيين كلمة المرور',
				'2fa_code' => 'المصادقة الثنائية',
				'2fa_recovery' => 'المصادقة الثنائية',
			]
		],
		'collapse' => 'ت. القائمة',
		'imports' => [
			'title' => 'الاستيراد'
		],
		'exports' => [
			'title' => 'التصدير'
		],
		'general_settings' => [
			'title' => 'الإعدادات العامة'
		],
		'theme_settings' => [
			'title' => 'الإعدادات القالب'
		],
		'store_settings' => [
			'title' => 'الإعدادات المتجر'
		],
		'currencies_settings' => [
			'title' => 'إعدادات العملات'
		],
		'emails_settings' => [
			'title' => 'الإعدادات البريد الالكتروني'
		],
		'payment_settings' => [
			'title' => 'الإعدادات الدفع'
		],
	],

	"overview" => [
		'customers' => 'العملاء',
		"orders" => "الطلبات",
		"sales" => "المبيعات",
		"subscribers" => "المشتركين",
		"top_selling" => "المنتجات الأكثر مبيعًا",
		"visitors_referrals" => "إحالات الزوار",
		"orders_statuses" => "حالات الطلبات",
	],

	'header' => [
		'search' => [
			'placeholder' => 'ابحث هنا...'
		],
		'profile' => 'حسابي',
		'logout' => 'تسجيل الخروج',
		'view_all' => 'مشاهدة الكل',
		'mark_all_read' => 'تحديد الكل كمقروء',
		'notifications' => [
			'title' => 'الإشعارات'
		],
		'messages' => [
			'title' => 'الرسائل'
		],
		'tooltips' => [
			'full_screen' => 'الشاشة الكاملة',
			'exit_full_screen' => 'إنهاء الشاشة الكاملة',
			'dark_mode' => 'الوضع المظلم',
			'light_mode' => 'الوضع المضيء',
		]
	],

	'pages' => [
		'users' => [
			'two_factor' => [
				'sub_section' => 'الحالة:',
				'recovery_codes_notify' => 'قم بتخزين رموز الاسترداد هذه في مدير كلمات مرور آمن. يمكن استخدامها لاستعادة الوصول إلى حسابك في حالة فقد جهاز المصادقة الثنائية الخاص بك.',
				'desciption' => 'عند تمكين المصادقة الثنائية ، ستتم مطالبتك برمز مميز آمن وعشوائي أثناء المصادقة. يمكنك استرداد هذا الرمز المميز من تطبيق Google Authenticator بهاتفك.',
				'finish' => 'لإنهاء تمكين المصادقة الثنائية ، امسح رمز الاستجابة السريعة التالي باستخدام تطبيق المصادقة على هاتفك أو أدخل مفتاح الإعداد وقدم رمز OTP الذي تم إنشاؤه',
				'status' => [
					'enable' => 'قمت بتفعيل المصادقة الثنائية',
					'disable' => 'المصادقة الثنائية معطلة',
				],
				'setup_key' => 'مفتاح الإعداد',
				'buttons' => [
					'enable' => 'تفعيل',
					'disable' => 'تعطيل',
					'show' => 'إظهار رموز الاسترداد',
					'generate' => 'إعادة إنشاء رموز الاسترداد',
					'cancel' => 'إلغاء',
					'confirm' => 'تأكيد',
				],
				'enabled' => 'تم تفعيل المصادقة الثنائية, يرجى التأكيد.',
				'disabled' => 'تم تعطيل المصادقة الثنائية.',
				'confirmed' => 'تم تأكيد المصادقة الثنائية.',
			],
			'sessions' => [
				'desc_1' => 'إدارة جلساتك النشطة وتسجيل الخروج منها على متصفحات وأجهزة أخرى.',
				'desc_2' => 'إذا لزم الأمر ، يمكنك تسجيل الخروج من جميع جلسات المتصفح الأخرى عبر جميع أجهزتك. بعض جلساتك الأخيرة مذكورة أدناه ؛ ومع ذلك ، قد لا تكون هذه القائمة شاملة. إذا شعرت أنه تم اختراق حسابك ، يجب عليك أيضًا تحديث كلمة المرور الخاصة بك.',
				'sub_section' => 'الجلسات النشطة:',
				'this_device' => 'هذا الجهاز',
				'last_active' => 'آخر نشاط',
			]
		],

		'roles' => [
			'no_permissions' => 'لا توجد أذونات تم إنشاؤها!'
		],

		'gallery' => [
			'no_images' => 'لا توجد صور تم تحميلها!'
		]
	],

	'filters' => [
		'all' => 'الكل',
		'trashed' => 'المحذوف'
	],

	'sections' => [
		'user_details' => 'تفاصيل المستخدم',
		'sessions' => 'جلسات التصفح',
		'two_factor' => 'المصادقة الثنائية',
		'activities' => 'النشاطات',
		'password' => 'تغيير كلمة المرور',
		'role_name' => 'اسم الدور',
		'permissions' => 'الأذونات',
		'general_settings' => 'الإعدادات العامة',
		'theme_settings' => 'إعدادات الموضوع',
		'store_address' => 'عنوان المتجر',
		'store_settings' => 'إعدادات المتجر',
		'store_sections_settings' => 'إعدادات أقسام المتجر',
		'currencies_settings' => 'إعدادات العملات',
		'multi_currencies' => 'عملات متعددة',
		'emails_settings' => 'إعدادات البريد الإلكتروني',
		'emails_notification_settings' => 'إعدادات إشعارات البريد الإلكتروني',
	],

	'unknown' => 'غير معروف',


	/*
    |--------------------------------------------------------------------------
    | Prefixs
    |--------------------------------------------------------------------------
    */

	'prefix' => [
		'view' => 'عرض',
		'add' => 'إضافة',
		'edit' => 'تعديل',
		'delete' => 'حذف',
		'permanently_delete' => 'حذف بشكل نهائي',
		'restore' => 'إستعادة',
		'' => '',
	]
];
