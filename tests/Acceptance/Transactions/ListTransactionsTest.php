<?php

namespace Tests\Acceptance\Transactions;

use Carbon\Carbon;
use App\Models\User;
use App\Enum\UserType;
use App\Models\Wallet;
use Tests\AcceptanceTestCase;

class ListTransactionsTest extends AcceptanceTestCase
{
    public function testShouldReturnAListOfTransactionsFilteredByStatus()
    {
        Carbon::setTestNow('2020-07-20 00:00:00');

        $user = factory(User::class)->create(['type' => UserType::CUSTUMER, 'wallet_id' => factory(Wallet::class)->create()->id]);
        $userPayee = factory(User::class)->create(['type' => UserType::SELLER, 'wallet_id' => factory(Wallet::class)->create()->id]);

        $payload = [
            'value' => 250.00,
            'payer' => $user->id,
            'payee' => $userPayee->id,
        ];

        $transactionsCreate = $this->actingAs($user)->call('POST', 'v1/transactions', $payload);

        $this->assertEquals(201, $transactionsCreate->status());

        $this->seeInDatabase('transactions', [
            'value' => 250.00,
            'payer_id' => $user->id,
            'payee_id' => $userPayee->id,
        ]);

        $transactionsList = $this->actingAs($user)->call('GET', 'v1/transactions?status[]=UNPROCESSED&status[]=PROCESSED');

        $this->assertEquals(200, $transactionsList->status());

        $expected = [
            'data' => [
                'current_page' => 1,
                'data' => [
                    [
                        'value' => '250.00',
                        'status' => 'PROCESSED',
                        'created_at' => '2020-07-20T00:00:00.000000Z',
                        'updated_at' => '2020-07-20T00:00:00.000000Z',
                    ],
                ],
                'first_page_url' => 'http://localhost/v1/transactions?page=1',
                'from' => 1,
                'last_page' => 1,
                'last_page_url' => 'http://localhost/v1/transactions?page=1',
                'next_page_url' => null,
                'path' => 'http://localhost/v1/transactions',
                'per_page' => 15,
                'prev_page_url' => null,
                'to' => 1,
                'total' => 1,
            ],
        ];

        $data = $transactionsList->json();

        unset($data['data']['data'][0]['id']);

        $this->assertEquals($expected, $data);
    }
}
