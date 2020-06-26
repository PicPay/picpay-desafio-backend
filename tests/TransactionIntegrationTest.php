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

    public function testInvalidBalance()
    {
        $res = $this->json( 'POST', '/api/v1/transaction',[
                'value' => 12200,
                'payer' => 4,
                'payee' => 15
            ]);

        
        $res->seeStatusCode(403)
            ->seeJson(['failed' => 1, 'error' => 'Payer balance is insuficient' ] );
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
            ->seeJson(['value' => ['Must provide a valid value'] ] );
    }
}
