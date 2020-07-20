<?php

$app->get('/probe', function ($request, $response) {
       return    $response->withStatus(200);
    });

$app->post('/user/register', \Transfer\Api\Action\RegisterCustomer::class)
    ->setName('CustomerService');

$app->post('/transaction', \Transfer\Api\Action\Transaction::class)
    ->setName('TransactionService');
