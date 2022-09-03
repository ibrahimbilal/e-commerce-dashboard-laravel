<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'verification-link-sent' => 'Verification link sent, please check your email.',

	'pages' => [
		'login' => [
			'intro' => 'Welcome Back',
			'title' => 'Login',
			'sub_title' => 'Welcome back! Please login to your account and continue growing your store.',
		],
		'forget' => [
			'intro' => 'Restore Account',
			'title' => 'Forgot Password?',
			'sub_title' => 'Enter your email and we\'ll send you instructions to reset your password.',
		],
		'restore' => [
			'intro' => 'Restore Account',
			'title' => 'Reset Password',
			'sub_title' => 'Your new password must be different from previously used passwords.',
		],
		'two_factor_auth' => [
			'intro' => 'Welcome Back',
			'title' => 'Two Step Verification',
			'code' => [
				'sub_title' => 'Please confirm access to your account by entering the authentication code provided by your authenticator application.',
			],
			'recovery' => [
				'sub_title' => 'Please confirm access to your account by entering one of your emergency recovery codes.',
			],
		],
		'confirm' => [
			'intro' => 'Account Security',
			'title' => 'Confirm Password',
			'sub_title' => 'For security reasons please confirm your password.',
		],
		'verify' => [
			'intro' => 'Activate Account',
			'title' => 'Verify Email',
			'sub_title' => 'You must verify your email address, please check your email for a verification link.',
		],
	]
];
