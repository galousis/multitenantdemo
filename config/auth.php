<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

	/*
   |--------------------------------------------------------------------------
   | User Signup Fields
   |--------------------------------------------------------------------------
   |
   | Here, you can specify what fields you want to store for your user. The
   | AuthController@signup method will automatically search for current
   | request data fields using names that are contained in this array.
   |
   */
	'signup_fields' => [
		'name', 'email', 'password'
	],
	/*
	|--------------------------------------------------------------------------
	| Signup Fields Rules
	|--------------------------------------------------------------------------
	|
	| Here you can put the rules you want to use for the validator instance
	| in the signup method.
	|
	*/
	'signup_fields_rules' => [
		'name' => 'required',
		'email' => 'required|email',
		'password' => 'required|min:6'
	],
	/*
	|--------------------------------------------------------------------------
	| Signup Token Release
	|--------------------------------------------------------------------------
	|
	| If this field is "true", an authentication token will be automatically
	| released after signup. Otherwise, the signup method will return a simple
	| success message.
	|
	*/
	'signup_token_release' => env('API_SIGNUP_TOKEN_RELEASE', true),
	/*
	|--------------------------------------------------------------------------
	| Password Reset Token Release
	|--------------------------------------------------------------------------
	|
	| If this field is "true", an authentication token will be automatically
	| released after password reset. Otherwise, the signup method will return a
	| simple success message.
	|
	*/
	'reset_token_release' => env('API_RESET_TOKEN_RELEASE', true),
	/*
	|--------------------------------------------------------------------------
	| Recovery Email Subject
	|--------------------------------------------------------------------------
	|
	| The email address you want use to send the recovery email.
	|
	*/
	'recovery_email_subject' => env('API_RECOVERY_EMAIL_SUBJECT', true),

];
