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

Route::get('/personType', 'PersonTypeController@index')->name('person_type_index');
Route::get('personType/{id}', 'PersonTypeController@show')->name('person_type_show');
Route::post('personType', 'PersonTypeController@store')->name('person_type_store');
Route::put('personType/{id}', 'PersonTypeController@update')->name('person_type_update');
Route::delete('personType/{id}', 'PersonTypeController@delete')->name('person_type_delete');

Route::get('/documentType', 'DocumentTypeController@index')->name('document_type_index');
Route::get('documentType/{id}', 'DocumentTypeController@show')->name('document_type_show');
Route::post('documentType', 'DocumentTypeController@store')->name('document_type_store');
Route::put('documentType/{id}', 'DocumentTypeController@update')->name('document_type_update');
Route::delete('documentType/{id}', 'DocumentTypeController@delete')->name('document_type_delete');

Route::get('/person', 'PersonController@index')->name('person_index');
Route::get('person/{id}', 'PersonController@show')->name('person_show');
Route::post('person', 'PersonController@store')->name('person_store');
Route::put('person/{id}', 'PersonController@update')->name('person_update');
Route::delete('person/{id}', 'PersonController@delete')->name('person_delete');

Route::get('/user', 'UserController@index')->name('user_index');
Route::get('user/{id}', 'UserController@show')->name('user_show');
Route::post('user', 'UserController@store')->name('user_store');
Route::put('user/{id}', 'UserController@update')->name('user_update');
Route::delete('user/{id}', 'UserController@delete')->name('user_delete');
