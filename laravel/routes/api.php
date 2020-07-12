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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
    Route::get("users", "UserController@index");
    Route::group(['prefix' => 'user'], function () {
        Route::get("{user}", "UserController@show");
        Route::post("", "UserController@store");
        Route::post("{user}", "UserController@update");
        Route::delete("{user}", "UserController@destroy");

        Route::get("{user}/wallet", "WalletController@show");
        Route::post("{user}/wallet", "WalletController@update");
    });

    Route::get("transactions", "TransactionController@index");
    Route::group(['prefix' => 'transaction'], function () {
        Route::get("{transaction}", "TransactionController@show");
        Route::post("", "TransactionController@store");
        Route::delete("{transaction}", "TransactionController@destroy");
    });
});
