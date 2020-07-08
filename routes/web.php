<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UserController@index');
    Route::get('/{id}', 'UserController@show');
});

Route::group(['prefix' => 'transactions'], function() {
    Route::get('/', 'TransactionController@index');
    Route::get('/{id}', 'TransactionController@show');
    Route::post('/', 'TransactionController@transfer');
});
