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

Route::post('/transfers', 'TransferController@create')->name('transfer.create');
Route::post('/users', ['uses' => 'UserController@create',])->name('user.create');
Route::put('/users/{id}', ['uses' => 'UserController@update',])->name('user.update');
