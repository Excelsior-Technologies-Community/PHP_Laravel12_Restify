<?php

use Binaryk\LaravelRestify\Repositories\ActionLogRepository;

return [

    /*
    |--------------------------------------------------------------------------
    | Auth Configuration
    |--------------------------------------------------------------------------
    */

    'auth' => [

        'table' => 'users',

        'provider' => 'sanctum',

        'frontend_app_url' => env('FRONTEND_APP_URL', env('APP_URL')),

        'password_reset_url' => env('FRONTEND_APP_URL').'/password/reset?token={token}&email={email}',

        'user_verify_url' => env('FRONTEND_APP_URL').'/verify/{id}/{emailHash}',

        'user_model' => \App\Models\User::class,

        'token_ttl' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | RestifyJS
    |--------------------------------------------------------------------------
    */

    'restifyjs' => [

        'token' => env('RESTIFYJS_TOKEN', 'testing'),

        'api_url' => env('API_URL', env('APP_URL')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Base Route
    |--------------------------------------------------------------------------
    */

    'base' => '/api/restify',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    | IMPORTANT: Empty to avoid 403 error
    */

    'middleware' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Logs
    |--------------------------------------------------------------------------
    */

    'logs' => [

        'repository' => ActionLogRepository::class,

        'enable' => true,

        'all' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    'search' => [

        'case_sensitive' => false,

        'use_joins_for_belongs_to' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Register Repositories HERE (IMPORTANT)
    |--------------------------------------------------------------------------
    */

    'repositories' => [

        'collectors' => [

            App\Restify\PostRepository::class,

        ],

        'serialize_index_meta' => false,

        'serialize_show_meta' => true,

        'cache' => [

            'enabled' => false,

            'ttl' => 300,

            'store' => null,

            'skip_authenticated' => false,

            'enable_in_tests' => false,

            'tags' => ['restify'],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */

    'cache' => [

        'policies' => [

            'enabled' => false,

            'ttl' => 300,
        ],
    ],

];