<?php

return [
	// general words
	'ops' => 'Oops...',
	'btn_text' => 'OK',

	// single action alerts
	'users' => [
		'confirm' => [
			'delete' => [
				'text' => 'Do you really want to delete this item!',
				'yes' => 'Yes, delete it!',
			],
			'restore' => [
				'text' => 'Do you really want to restore this item!',
				'yes' => 'Yes, restore it!',
			],
			'title' => 'Are you sure?',
			'no' => 'No, cancel!'
		],
		'cancel' => [
			'title' => 'Cancelled',
			'delete' => [
				'text' => 'item is safe :)',
			],
			'restore' => [
				'text' => 'item is not restored :(',
			],
		],
		'request' => [
			'before_sent_title' => 'Please Wait',
			'before_sent_text' => 'The data you sent is being processed, please be patient!',
			'image_size' => 'The image size is more than 1 MB! Please choose another picture',
			'image_type' => 'Please select an image in the format: JPEG, JPG, PNG',
		],
		'response' => [
			'create' => 'User successfully Created',
			'update' => 'Data successfully updated!',
			'logout_other_devices' => 'Logged out from other devices successfully',
			'confirm_password' => 'The given password does not match the current password!',
			'delete' => [
				'title' => 'Deleted!',
				'text' => 'User successfully deleted!',
			],
			'restore' => [
				'title' => 'Restored!',
				'text' => 'User successfully restored!',
			],
			'errors' => [
				'not_allowed' => 'You are not allowed to delete your account!',
				'not_exist' => 'The User Dose Not Exist!',
				'unknown' => 'There Is Error!',
			]
		]
	]
];
