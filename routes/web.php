<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use App\Http\Controllers\TransactionController;
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/v1/transaction', [ 'as' => 'transaction.execute', 
                                    'uses' => TransactionController::class.'@execute']);
