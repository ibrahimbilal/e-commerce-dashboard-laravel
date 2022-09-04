<?php

return [
	// form
	'submit' => 'apply',
	'option' => [
		'bulk' => 'Bulk Action',
		'delete' => 'Delete',
		'restore' => 'Restore',
		'force_delete' => 'Permanently Delete'
	],

	// alerts
	'no_action' => 'Please choose a action!',
	'no_items' => 'Please select items!',
	'confirm' => [
		'delete' => [
			'text' => 'Do you really want to delete this items!',
			'yes' => 'Yes, delete it!',
		],
		'restore' => [
			'text' => 'Do you really want to restore this items!',
			'yes' => 'Yes, restore it!',
		],
		'title' => 'Are you sure?',
		'no' => 'No, cancel!'
	],
	'cancel' => [
		'title' => 'Cancelled',
		'delete' => [
			'text' => 'items is safe :)',
		],
		'restore' => [
			'text' => 'items is not restored :(',
		],
	],

	// Ajax Response
	'ajax' => [
		'actions' => [
			'delete' => [
				'title' => 'Deleted!',
				'text' => 'The :type has been deleted!',
				'no_items' => 'Nothing to delete!',
			],
			'restore' => [
				'title' => 'Restored!',
				'text' => 'The :type has been restored!',
				'no_items' => 'Nothing to restore!',
			],
		],
		'errors' => [
			'invalid_action' => 'The selected action is invalid'
		],
	]
];
