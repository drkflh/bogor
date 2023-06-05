<?php

use Illuminate\Support\Str;

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

    'default' => env('DB_CONNECTION', 'mongodb'),

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

        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('MODB_HOST', 'localhost'),
            'port'     => env('MODB_PORT', 27017),
            'database' => env('MODB_DATABASE'),
            'username' => env('MODB_USERNAME'),
            'password' => env('MODB_PASSWORD'),
            'options'  => [
                'database' => env('MODB_DATABASE') // sets the authentication database required by mongo 3
            ]
        ],

        'mongoref' => [
            'driver'   => 'mongodb',
            'host'     => env('MOREF_HOST', 'localhost'),
            'port'     => env('MOREF_PORT', 27017),
            'database' => env('MOREF_DATABASE'),
            'username' => env('MOREF_USERNAME'),
            'password' => env('MOREF_PASSWORD'),
            'options'  => [
                'database' => env('MOREF_DATABASE') // sets the authentication database required by mongo 3
            ]
        ],

        'mongodir' => [
            'driver'   => 'mongodb',
            'host'     => env('MODIR_HOST', 'localhost'),
            'port'     => env('MODIR_PORT', 27017),
            'database' => env('MODIR_DATABASE'),
            'username' => env('MODIR_USERNAME'),
            'password' => env('MODIR_PASSWORD'),
            'options'  => [
                'database' => env('MODIR_DATABASE') // sets the authentication database required by mongo 3
            ]
        ],

        'mongousr' => [
            'driver'   => 'mongodb',
            'host'     => env('MOUSR_HOST', 'localhost'),
            'port'     => env('MOUSR_PORT', 27017),
            'database' => env('MOUSR_DATABASE'),
            'username' => env('MOUSR_USERNAME'),
            'password' => env('MOUSR_PASSWORD'),
            'options'  => [
                'database' => env('MOUSR_DATABASE') // sets the authentication database required by mongo 3
            ]
        ],

        'mongolog' => [
            'driver'   => 'mongodb',
            'host'     => env('MOLOG_HOST', 'localhost'),
            'port'     => env('MOLOG_PORT', 27017),
            'database' => env('MOLOG_DATABASE'),
            'username' => env('MOLOG_USERNAME'),
            'password' => env('MOLOG_PASSWORD'),
            'options'  => [
                'database' => env('MOLOG_DATABASE') // sets the authentication database required by mongo 3
            ]
        ],

        'mongodms' => [
            'driver'   => 'mongodb',
            'host'     => env('MODMS_HOST', 'localhost'),
            'port'     => env('MODMS_PORT', 27017),
            'database' => env('MODMS_DATABASE'),
            'username' => env('MODMS_USERNAME'),
            'password' => env('MODMS_PASSWORD'),
            'options'  => [
                'database' => env('MODMS_DATABASE') // sets the authentication database required by mongo 3
            ]
        ],


        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('MYDB_HOST', '127.0.0.1'),
            'port' => env('MYDB_PORT', '3306'),
            'database' => env('MYDB_DATABASE', 'forge'),
            'username' => env('MYDB_USERNAME', 'forge'),
            'password' => env('MYDB_PASSWORD', ''),
            'unix_socket' => env('MYDB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
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
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
