<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('meu-perfil', 'ProfileController@edit')->name('profile.edit')->middleware('auth');
Route::post('meu-perfil', 'ProfileController@update')->name('profile.update')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {

    Route::get('balance', 'BalanceController@index')->name('balance.index');
    Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');
    Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');

    Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
    Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

    Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');
    Route::post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');
    Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');

    Route::get('transactions', 'TransactionController@index')->name('transaction.index');
    Route::any('transactions-search', 'TransactionController@search')->name('transaction.search');
});