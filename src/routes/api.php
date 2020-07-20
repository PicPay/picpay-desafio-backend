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
Route::get('users', 'Api\UserController@index');
// Route::post('user', 'Api\UserController@show');

Route::post('login', 'Api\AuthController@login');
Route::post('register',  'Api\UserController@store');

Route::post('wallet', 'Api\WalletController@show');
Route::post('addfunds', 'Api\WalletController@addFunds');


Route::post('exchange', ['as' => 'exchange', 'uses' => 'Api\TransactionController@exchange']);