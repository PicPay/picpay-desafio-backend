<?php

use Illuminate\Support\Facades\Http;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    public function testSuccess()
    {
        $res = $this->json( 'POST', '/api/v1/transaction',[
                'value' => 100,
                'payer' => 4,
                'payee' => 15
            ]);

        $res->seeStatusCode(200)
            ->seeJson(['message' => "Done" ] );
    }

    public function testInvalidPayer()
    {
        $res = $this->json( 'POST', '/api/v1/transaction',[
                'value' => 100,
                'payer' => 15,
                'payee' => 4
            ]);

        $res->seeStatusCode(422)
            ->seeJson(['payer' => ['Payer must be valid'] ] );
    }

    public function testInvalidPayee()
    {
        $res = $this->json( 'POST', '/api/v1/transaction',[
                'value' => 100,
                'payer' => 4,
                'payee' => -1
            ]);

        $res->seeStatusCode(422)
            ->seeJson(['payee' => ['Payee must be valid'] ] );
    }

    public function testInvalidValue()
    {
        $res = $this->json( 'POST', '/api/v1/transaction',[
                'value' => 'asdasdas',
                'payer' => 4,
                'payee' => 15
            ]);

        $res->seeStatusCode(422)
            ->seeJson(['payee' => ['Must provide a valid value'] ] );
    }
}
