<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
    Route::post('auth/token', 'AuthController@auth');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('auth/me', 'AuthController@me');
        Route::post('auth/logout', 'AuthController@logout');

        Route::resource('users', 'UserController')->except([
            'create', 'edit'
        ]);

        Route::resource('transactions', 'TransactionController')->only([
            'store'
        ]);
    });
});
