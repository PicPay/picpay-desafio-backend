<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Wallet;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    protected $response_structure =
    [
        'payee',
        'payer',
        'value'
    ];

    public function testShopkeepersCantPay()
    {
        $payer = factory(User::class)->create();
        $payee = factory(User::class)->create();

        factory(Wallet::class)->create(['user_id' => $payer->id, 'wallet_type' => 2, 'balance' => 100.00]);
        factory(Wallet::class)->create(['user_id' => $payee->id]);

        $response = $this->json('POST', 'api/exchange', [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 100.00
        ]);

        $response->assertStatus(400);
    }

    public function testNotEnoughBalance()
    {
        $payer = factory(User::class)->create();
        $payee = factory(User::class)->create();

        factory(Wallet::class)->create(['user_id' => $payer->id, 'balance' => 0]);
        factory(Wallet::class)->create(['user_id' => $payee->id]);

        $response = $this->json('POST', 'api/exchange', [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 100.00
        ]);

        $response->assertStatus(400);
    }

    public function testSuccessfulTransation()
    {
        $payer = factory(User::class)->create();
        $payee = factory(User::class)->create();

        factory(Wallet::class)->create(['user_id' => $payer->id, 'wallet_type' => 1 ,'balance' => 200]);
        factory(Wallet::class)->create(['user_id' => $payee->id]);

        $response = $this->json('POST', 'api/exchange', [
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => 100.00
        ]);

        $response->assertStatus(200);
    }
}
