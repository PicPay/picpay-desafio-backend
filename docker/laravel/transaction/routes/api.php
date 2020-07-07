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

Route::get('/transfer', 'TransferController@index')->name('transfer_index');
Route::get('transfer/{id}', 'TransferController@show')->name('transfer_show');
Route::post('transfer', 'TransferController@store')->name('transfer_store');
Route::put('transfer/{id}', 'TransferController@update')->name('transfer_update');
Route::delete('transfer/{id}', 'TransferController@delete')->name('transfer_delete');
