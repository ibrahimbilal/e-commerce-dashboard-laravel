<?php

return [
	// form
	'submit' => 'تنفيذ',
	'option' => [
		'bulk' => 'الاجراءات الجماعية',
		'edit' => 'تعديل',
		'delete' => 'حذف',
		'restore' => 'إستعادة',
		'force_delete' => 'حذف نهائي'
	],

	// alerts
	'no_action' => 'الرجاء اختيار إجراء!',
	'no_items' => 'الرجاء تحديد العناصر!',

	'confirm' => [
		'delete' => [
			'text' => 'هل تريد حقًا حذف هذه العناصر!',
			'yes' => 'نعم احذفها',
		],
		'restore' => [
			'text' => 'هل تريد حقاً استعادة هذه العناصر',
			'yes' => 'نعم, استعدها',
		],
		'title' => 'هل أنت متأكد؟',
		'no' => 'لا ، ألغي!'
	],
	'cancel' => [
		'title' => 'تم الإلغاء',
		'delete' => [
			'text' => 'العناصر الخاصة بك آمنة :)'
		],
		'restore' => [
			'text' => 'لم يتم استعادة العناصر :(',
		],
	],

	// Ajax Response
	'ajax' => [
		'actions' => [
			'delete' => [
				'title' => 'تم الحذف!',
				'text' => 'تم حذف :type',
				'no_items' => 'لا شيء لحذفه!',
			],
			'restore' => [
				'title' => 'تمت الاستعادة!',
				'text' => 'تم استعادة :type',
				'no_items' => 'لا شيء لاستعادته',
			],
		],
		'errors' => [
			'invalid_action' => 'الإجراء المحدد غير صالح'
		],
	]
];
