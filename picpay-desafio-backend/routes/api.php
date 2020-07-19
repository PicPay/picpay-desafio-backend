<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/** @var Router $router */

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('', 'UserController@index');
    $router->get('{id}', 'UserController@show');
    $router->post('', 'UserController@store');
    $router->put('{id}', 'UserController@update');
    $router->delete('{id}', 'UserController@destroy');
});
