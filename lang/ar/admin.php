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
		'dashboard' => 'لوحة التحكم',
		'products' => 'المنتجات',
		'attributes' => 'الخواص',
		'reviews' => 'المراجعات',
		'categories' => 'التصنيفات',
		'tags' => 'الوسوم',
		'discounts' => 'الحسومات',
		'customers' => 'العملاء',
		'orders' => 'الطلبات',
		'invoices' => 'الفواتير',
		'analytics' => 'التحليلات',
		'analytics' => [
			'title' => 'التحليلات',
			[
				'overview' => 'نظرة عامة'
			]
		],
		'marketing' => 'التسويق',
		'users' => [
			'title' => 'المستخدمون',
			'profile' => 'حسابي',
			'add' => 'اضافة مستخدم',
			'edit' => 'تعديل المستخدم',
		],
		'roles' => 'الأدوار',
		'gallery' => 'المعرض',
		'languages' => 'اللغات',
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
		'collapse' => 'ت. القائمة'
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
			'dark_mode' => 'الوضع الليلي',
			'light_mode' => 'الوضع النهاري',
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
	],

	'unknown' => 'غير معروف',
];
