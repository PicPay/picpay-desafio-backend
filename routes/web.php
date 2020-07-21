<?php

$router->get('/', function () use ($router) {
    return [
        'application' => config('app.name'),
        'version' => $router->app->version(),
        'documentation' =>  'https://app.swaggerhub.com/apis/leandrodaf/PicpayDesafioBackendLeandroFerreira/1.0.0'
    ];
});

$router->group(['prefix' => 'v1'], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AccountController@create');

    $router->group(['middleware' => 'auth'], function ($router) {
        $router->group(['prefix' => 'accounts'], function ($router) {
            $router->post('logout', 'AuthController@logout');
            $router->post('refresh', 'AuthController@refresh');
            $router->get('context', 'AuthController@context');
        });

        $router->group(['prefix' => 'transactions'], function ($router) {
            $router->get('/', 'TransactionController@list');
            $router->post('/', 'TransactionController@create');
            $router->get('/{id}', 'TransactionController@single');
        });

        $router->group(['prefix' => 'wallets'], function ($router) {
            $router->post('/', 'WalletController@directWithdraw');
        });
    });
});
