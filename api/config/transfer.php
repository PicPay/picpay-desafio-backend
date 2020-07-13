<?php

return [
    'authorization' => [
        'class' => App\Services\Authorization\MockyAuthorizationService::class,
        'args' => [
            env('MOCKY_AUTHORIZATION_URL')
        ]
    ]
];
