<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    protected $response_structure =
        [
            'payer_wallet_id',
            'payee_wallet_id',
            'value'
        ];
    public function testSalesPersonCantPay()
    {
        $payer = factory('App\Models\User')->create()->setAttribute('type', 'salesPerson');
        $payee = factory('App\Models\User')->create();
        $payerWallet = factory('App\Models\Wallet')->create()->setAttribute('user_id', $payer->id);
        $payeeWallet = factory('App\Models\Wallet')->create()->setAttribute('user_id', $payee->id);

        $response = $this->json('POST', 'api/transactions', [
            'payer_wallet_id' => $payerWallet->id,
            'payee_wallet_id' => $payeeWallet->id,
            'value' => 100.00
        ]);
        $response->assertStatus(400);
    }

    public function testHasNoBalance()
    {
        $payer = factory('App\Models\Wallet')->create()->setAttribute('balance',0.0);
        $payee = factory('App\Models\Wallet')->create()->setAttribute('balance',0.0);

        $response = $this->json('POST', 'api/transactions', [
            'payer_wallet_id' => $payer->id,
            'payee_wallet_id' => $payee->id,
            'value' => 100.00
        ]);
        $response->assertStatus(400);
    }
}
