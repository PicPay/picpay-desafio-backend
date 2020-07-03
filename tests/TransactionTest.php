<?php

class TransactionTest extends TestCase
{

    const TRANSACTION_SERVICE_URL = "http://localhost:8000/api/v1/transaction";

    public function testTransactionCreation() {
        $this->post(self::TRANSACTION_SERVICE_URL, [
            'value' => 100.00,
            'payer' => 1,
            'payee' => 2
        ])->seeStatusCode(201);
    }

    public function testTransactionCreationWithStoreUserAsPayer() {
        $this->post(self::TRANSACTION_SERVICE_URL, [
            'value' => 100.00,
            'payer' => 4,
            'payee' => 1
        ])->seeStatusCode(500);
    }

    public function testTransactionCreationWithNotFoundUsers() {
        $this->post(self::TRANSACTION_SERVICE_URL, [
            'value' => 100.00,
            'payer' => 100,
            'payee' => 154
        ])->seeStatusCode(500);
    }

    public function testTransactionCreationWithTheSameUsers() {
        $this->post(self::TRANSACTION_SERVICE_URL, [
            'value' => 100.00,
            'payer' => 100,
            'payee' => 154
        ])->seeJsonStructure([
           'message',
           'cause',
           'code'
        ]);
    }

    public function testTransactionCreationWithUserWithoutBalance() {
        $this->post(self::TRANSACTION_SERVICE_URL, [
            'value' => 1000000000.00,
            'payer' => 100,
            'payee' => 154
        ])->seeJsonStructure([
            'message',
            'cause',
            'code'
        ])->seeStatusCode(500);
    }
}
