<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('transfer', 'Transfer\TransferController')->name('transfer');
