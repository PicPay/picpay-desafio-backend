<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Models\Wallet;
use App\Response\WalletResponse;

class WalletResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $wallet = factory(Wallet::class)->make();

        $contextResponse = new WalletResponse($wallet);

        $payload = $contextResponse->response()->getContent();

        $expected = [
            'data' => [
                'amount' => $wallet->amount,
                'created_at' => null,
                'updated_at' => null,
            ],
        ];

        $this->assertEquals(json_encode($expected), $payload);
    }
}
