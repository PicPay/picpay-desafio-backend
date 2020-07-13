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

$router->get('/', function () {
    return view('welcome');
});

Auth::routes();

// Registration Routes...
$router->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

$router->get('/home', 'HomeController@index')->name('home');
$router->get('/transaction', 'TransactionController@index')->name('transaction');
$router->post('/transaction/store', 'TransactionController@store')->name('transaction.store');