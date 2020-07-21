<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Models\Transaction;
use App\Response\TransactionsResponse;
use Illuminate\Pagination\Paginator;

class TransactionsResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $transction = factory(Transaction::class)->make();

        $transactionsResponse = new TransactionsResponse(new Paginator([$transction], 15));

        $payload = $transactionsResponse->response()->getContent();

        $expected = [
            'data' => [
                'current_page' => 1,
                'data' => [
                    [
                        'id' => $transction->id,
                        'value' => $transction->value,
                        'status' => $transction->status,
                        'created_at' => null,
                        'updated_at' => null,
                    ],
                ],
                'first_page_url' => '/?page=1',
                'from' => 1,
                'next_page_url' => null,
                'path' => '/',
                'per_page' => 15,
                'prev_page_url' => null,
                'to' => 1,
            ],
        ];

        $this->assertEquals(json_encode($expected), $payload);
    }
}
