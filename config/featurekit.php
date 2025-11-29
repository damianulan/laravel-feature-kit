<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel Feature Kit Configuration file v1.0
    |--------------------------------------------------------------------------
    |
    | These are package's default configuration options.
    |
    */

    'connection' => env('FEATUREKIT_CONNECTION', 'database'),

    'drivers' => [
        'database' => [
            'table_name' => 'features',
        ],
        'json' => [
            'storage_path' => storage_path('features'),
        ],
    ],

    'cache' => [
        'enabled' => true,
        // in minutes
        'ttl' => 300,
    ],
];
