<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/** @var Router $router */

$router->middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->group(['middleware' => 'api'], function () use ($router){
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('', 'UserController@index');
        $router->get('{id}', 'UserController@show');
        $router->post('', 'UserController@store');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');
    });

    $router->group(['prefix' => 'wallets'], function () use ($router) {
        $router->get('', 'WalletController@index');
        $router->get('{id}', 'WalletController@show');
        $router->post('', 'WalletController@store');
        $router->put('{id}', 'WalletController@update');
        $router->delete('{id}', 'WalletController@destroy');
    });

    $router->group(['prefix' => 'transactions'], function () use ($router) {
        $router->get('', 'TransactionController@index');
        $router->get('{id}', 'TransactionController@show');
        $router->post('', 'TransactionController@store');
        $router->put('{id}', 'TransactionController@update');
        $router->delete('{id}', 'TransactionController@destroy');
    });
});
