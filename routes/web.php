<?php

use App\Http\Middleware\DefaultUser;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'UserController@index')->name('home');
Route::get('/transaction/{id}', 'TransactionController@index')->name('show.transaction');

/** Habilita rotas de contatos, transferência e etc. apenas para usuário padrão (lojistas não tem acesso)  */
Route::middleware(DefaultUser::class)->group(function(){

    Route::get('/contacts', 'ContactController@contacts')->name('contacts');

    Route::get('/new/contact/', 'ContactController@newContact')->name('new.contact');

    Route::get('/send/{contact}', 'TransactionController@send')->name('send');

    Route::post('/send/{payee}', 'TransactionController@call')->name('call');

    Route::post('/transaction', 'TransactionController@transaction')->name('transaction');
});





