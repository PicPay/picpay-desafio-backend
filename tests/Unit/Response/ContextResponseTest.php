<?php

namespace Tests\Unit\Response;

use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Response\ContextResponse;

class ContextResponseTest extends TestCase
{
    public function testSchemaValidation()
    {
        $wallet = factory(Wallet::class)->make();
        $user = factory(User::class)->make();
        $user->wallet = $wallet;

        $contextResponse = new ContextResponse($user);

        $payload = $contextResponse->response()->getContent();

        $expected = [
            'data' => [
                'id' => $user->id,
                'fullName' => $user->fullName,
                'email' => $user->email,
                'document' => $user->document,
                'type' => $user->type,
                'wallet' => [
                    'amount' => $wallet->amount,
                    'created_at' => null,
                    'updated_at' => null,
                ],
            ],
        ];

        $this->assertEquals(json_encode($expected), $payload);
    }
}
