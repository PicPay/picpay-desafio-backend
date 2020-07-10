<?php

use Illuminate\Support\Facades\Route;

Route::post('transaction', 'Transfer\TransferController')->name('transfer');

