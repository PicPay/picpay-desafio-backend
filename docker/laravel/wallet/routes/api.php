<?php

use Illuminate\Http\Request;

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

Route::get('/account', 'AccountController@index')->name('account_index');
Route::get('account/{id}', 'AccountController@show')->name('account_show');
Route::post('account', 'AccountController@store')->name('account_store');
Route::put('account/{id}', 'AccountController@update')->name('account_update');
Route::delete('account/{id}', 'AccountController@delete')->name('account_delete');
