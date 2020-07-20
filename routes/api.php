<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/transaction', 'TransactionController@receive');

Route::post('/user', 'UserController@store');
