<?php

/**
 * @var \Illuminate\Support\Facades\Route $router
 */

$router->post('api/transaction', [
    'middleware' => 'transfer',
    'uses' => 'TransferController@store'
]);
