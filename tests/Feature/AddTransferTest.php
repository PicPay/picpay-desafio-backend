<?php

namespace Tests\Feature;

use App\Jobs\TransferAuthorizationJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Model\Users\Users;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class AddTransferTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTransferWillSucceedWithCreditAndValidUsers()
    {
        Queue::fake();
        $transfer_amount = 50;

        $payer = factory(Users::class)->create([
            'credit_balance' => 100,
            'document'       => '12345678910',
            'is_shopkeeper'  => false,
        ]);
        $payee = factory(Users::class)->create([
            'credit_balance' => 0,
            'document'       => '10987654321',
            'is_shopkeeper' => true,
        ]);

        $response = $this->post('/transaction',[
            'payer' => $payer->user_id,
            'payee' => $payee->user_id,
            'value' => $transfer_amount
        ]);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('transactions', [
            'payer_id' => $payer->user_id,
            'payee_id' => $payee->user_id,
            'amount'    => $transfer_amount
        ]);

        Queue::assertPushed(TransferAuthorizationJob::class);
        $this->assertEquals(50,$payer->fresh()->credit_balance);
    }

    public function testTransferWillFailWithInvalidShopkeeperPayer()
    {
        $transfer_amount = 50;

        $payer = factory(Users::class)->create([
            'credit_balance' => 100,
            'document'       => '12345678910',
            'is_shopkeeper' => true,
        ]);
        $payee = factory(Users::class)->create([
            'credit_balance' => 0,
            'document'       => '10987654321',
            'is_shopkeeper' => false,
        ]);

        $response = $this->post('/transaction',[
            'payer' => $payer->user_id,
            'payee' => $payee->user_id,
            'value' => $transfer_amount
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('transactions', [
            'payer_id' => $payer->user_id,
            'payee_id' => $payee->user_id,
            'amount'    => $transfer_amount
        ]);
        $this->assertEquals(100,$payer->fresh()->credit_balance);
    }

    public function testTransferWillFailWithoutEnoughCreditBalance()
    {
        $transfer_amount = 50;

        $payer = factory(Users::class)->create([
            'credit_balance' => 20,
            'document'       => '12345678910',
            'is_shopkeeper' => false,
        ]);
        $payee = factory(Users::class)->create([
            'credit_balance' => 0,
            'document'       => '10987654321',
            'is_shopkeeper' => true,
        ]);

        $response = $this->post('/transaction',[
            'payer' => $payer->user_id,
            'payee' => $payee->user_id,
            'value' => $transfer_amount
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('transactions', [
            'payer_id' => $payer->user_id,
            'payee_id' => $payee->user_id,
            'amount'    => $transfer_amount
        ]);
        $this->assertEquals(20,$payer->fresh()->credit_balance);
    }
}
