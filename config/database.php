<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

		'tenant_db' => [
			'driver' => 'mysql',
			'host' => env('DB_HOST', '127.0.0.1'),
			'port' => env('DB_PORT', '3306'),
			'database' => '', // this will be filled in dynamically based on the tenant subdomain.
			'username' => env('DB_USERNAME', 'forge'),
			'password' => env('DB_PASSWORD', ''),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '', // this can be changed and represents a database prefix e.g. 'business_acme'
			'strict' => true,
			'engine' => null,
		],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

		'GR_mysql' => [
			'driver' => 'mysql',
			'host' => env('GR_DB_HOST', '127.0.0.1'),
			'port' => env('GR_DB_PORT', '3306'),
			'database' => env('GR_DB_DATABASE', 'forge'),
			'username' => env('GR_DB_USERNAME', 'forge'),
			'password' => env('GR_DB_PASSWORD', ''),
			'unix_socket' => env('GR_DB_SOCKET', ''),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
			'strict' => true,
			'engine' => null,
		],

		'UK_mysql' => [
			'driver' => 'mysql',
			'host' => env('UK_DB_HOST', '127.0.0.1'),
			'port' => env('UK_DB_PORT', '3306'),
			'database' => env('UK_DB_DATABASE', 'forge'),
			'username' => env('UK_DB_USERNAME', 'forge'),
			'password' => env('UK_DB_PASSWORD', ''),
			'unix_socket' => env('UK_DB_SOCKET', ''),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
			'strict' => true,
			'engine' => null,
		],

		'US_mysql' => [
			'driver' => 'mysql',
			'host' => env('US_DB_HOST', '127.0.0.1'),
			'port' => env('US_DB_PORT', '3306'),
			'database' => env('US_DB_DATABASE', 'forge'),
			'username' => env('US_DB_USERNAME', 'forge'),
			'password' => env('US_DB_PASSWORD', ''),
			'unix_socket' => env('US_DB_SOCKET', ''),
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
			'strict' => true,
			'engine' => null,
		],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
