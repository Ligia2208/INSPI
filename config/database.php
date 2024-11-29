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
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'coreinspi' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
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

        'rhumanos' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_RHU', '127.0.0.1'),
            'port' => env('DB_PORT_RHU', '3306'),
            'database' => env('DB_DATABASE_RHU', 'forge'),
            'username' => env('DB_USERNAME_RHU', 'forge'),
            'password' => env('DB_PASSWORD_RHU', ''),
            'unix_socket' => env('DB_SOCKET_RHU', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'documental' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_DOC', '127.0.0.1'),
            'port' => env('DB_PORT_DOC', '3306'),
            'database' => env('DB_DATABASE_DOC', 'forge'),
            'username' => env('DB_USERNAME_DOC', 'forge'),
            'password' => env('DB_PASSWORD_DOC', ''),
            'unix_socket' => env('DB_SOCKET_DOC', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'inventario' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_INV', '127.0.0.1'),
            'port' => env('DB_PORT_INV', '3306'),
            'database' => env('DB_DATABASE_INV', 'forge'),
            'username' => env('DB_USERNAME_INV', 'forge'),
            'password' => env('DB_PASSWORD_INV', ''),
            'unix_socket' => env('DB_SOCKET_INV', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'intranet' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_INT', '127.0.0.1'),
            'port' => env('DB_PORT_INT', '3306'),
            'database' => env('DB_DATABASE_INT', 'forge'),
            'username' => env('DB_USERNAME_INT', 'forge'),
            'password' => env('DB_PASSWORD_INT', ''),
            'unix_socket' => env('DB_SOCKET_INT', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],


        'plataformas' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PLAT', '127.0.0.1'),
            'port' => env('DB_PORT_PLAT', '3306'),
            'database' => env('DB_DATABASE_PLAT', 'forge'),
            'username' => env('DB_USERNAME_PLAT', 'forge'),
            'password' => env('DB_PASSWORD_PLAT', ''),
            'unix_socket' => env('DB_SOCKET_PLAT', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'crns' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_CRN', '127.0.0.1'),
            'port' => env('DB_PORT_CRN', '3306'),
            'database' => env('DB_DATABASE_CRN', 'forge'),
            'username' => env('DB_USERNAME_CRN', 'forge'),
            'password' => env('DB_PASSWORD_CRN', ''),
            'unix_socket' => env('DB_SOCKET_CRN', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'soporte' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_TSU', '127.0.0.1'),
            'port' => env('DB_PORT_TSU', '3306'),
            'database' => env('DB_DATABASE_TSU', 'forge'),
            'username' => env('DB_USERNAME_TSU', 'forge'),
            'password' => env('DB_PASSWORD_TSU', ''),
            'unix_socket' => env('DB_SOCKET_TSU', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'inventarios' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_INVS', '127.0.0.1'),
            'port' => env('DB_PORT_INVS', '3306'),
            'database' => env('DB_DATABASE_INVS', 'forge'),
            'username' => env('DB_USERNAME_INVS', 'forge'),
            'password' => env('DB_PASSWORD_INVS', ''),
            'unix_socket' => env('DB_SOCKET_INVS', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ],

        'corrida' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_COR', '127.0.0.1'),
            'port' => env('DB_PORT_COR', '3306'),
            'database' => env('DB_DATABASE_COR', 'forge'),
            'username' => env('DB_USERNAME_COR', 'forge'),
            'password' => env('DB_PASSWORD_COR', ''),
            'unix_socket' => env('DP_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => 'InnoDB',
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
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
