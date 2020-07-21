<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Models\Transaction;
use App\Response\TransactionResponse;

class TransactionResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $transction = factory(Transaction::class)->make();

        $transactionResponse = new TransactionResponse($transction);

        $payload = $transactionResponse->response()->getContent();

        $expected = [
            'data' => [
                'id' => $transction->id,
                'value' => $transction->value,
                'status' => $transction->status,
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        $this->assertEquals(json_encode($expected), $payload);
    }
}
