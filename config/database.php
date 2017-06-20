<?php 
 return [
    'migrations' => 'migrations',
    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],
    'connections'=>[
'DB0'=>[
'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'acp',
            'username' => 'user',
            'password' => '123456',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null
],

],
'default' => 'DB0'
];