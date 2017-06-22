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
            'host' => '31.22.4.254',
            'port' => '3306',
            'database' => 'buianove_acp',
            'username' => 'buianove_root',
            'password' => 'Qq4541201096',
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