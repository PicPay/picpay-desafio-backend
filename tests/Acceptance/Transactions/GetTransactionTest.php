<?php

namespace Tests\Acceptance\Transactions;

use Carbon\Carbon;
use App\Models\User;
use App\Enum\UserType;
use Tests\AcceptanceTestCase;

class GetTransactionTest extends AcceptanceTestCase
{
    public function testMustReturnATransaction()
    {
        Carbon::setTestNow('2020-07-20 00:00:00');

        $user = factory(User::class)->create(['type' => UserType::CUSTUMER]);
        $userPayee = factory(User::class)->create(['type' => UserType::SELLER]);

        $payload = [
            'value' => 250.00,
            'payer' => $user->id,
            'payee' => $userPayee->id,
        ];

        $response = $this->actingAs($user)->call('POST', 'v1/transactions', $payload);

        $this->assertEquals(201, $response->status());

        $this->seeInDatabase('transactions', [
            'value' => 250.00,
            'payer_id' => $user->id,
            'payee_id' => $userPayee->id,
        ]);

        $transactionsList = $this->actingAs($user)->call('GET', 'v1/transactions');

        $id = $transactionsList->json()['data']['data'][0]['id'];

        $singleTransaction = $this->actingAs($user)->call('GET', "v1/transactions/$id");

        $this->assertEquals(200, $singleTransaction->status());

        $this->assertEquals([
            'data' => [
                'id' => $id,
                'value' => 250,
                'status' => 'PROCESSED',
                'created_at' => '2020-07-20T00:00:00.000000Z',
                'updated_at' => '2020-07-20T00:00:00.000000Z',
            ],
        ], $singleTransaction->json());
    }
}
