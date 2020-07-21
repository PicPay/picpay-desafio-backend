<?php

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
