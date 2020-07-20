<?php

return [

    'name' => env('APP_NAME', 'Lumen'),

    'env' => env('APP_ENV', 'production'),

    'debug' => env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'UTC',

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'enable_query_log' => env('ENABLE_QUERY_LOG', false),

    'queue_listener' => env('QUEUE_LISTENER', 'listeners'),

    'url_transaction_authorization' => env('URL_TRANSACTION_AUTHORIZATION', 'https://run.mocky.io/v3'),

];
