<?php

/**
 * @var \Illuminate\Support\Facades\Route $router
 */

$router->post('/transaction', [
    'middleware' => 'transfer',
    'uses' => 'TransferController@store'
]);
