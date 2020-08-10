<?php

namespace Tests\Unit;

use App\Jobs\TransferAuthorizationJob;
use App\Services\Transfer\FinishTransferService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Model\Transactions\Transactions;
use Model\Users\Users;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class FinishTransferServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $finishTransferService;
    protected $payer;
    protected $payee;
    protected $transaction;

    public function setUp() : void {

        parent::setUp();

        $this->payer = factory(Users::class)->create([
            'credit_balance' => 50,
            'document'       => '12345678910',
            'is_shopkeeper'  => false,
        ]);
        $this->payee = factory(Users::class)->create([
            'credit_balance' => 0,
            'document'       => '10987654321',
            'is_shopkeeper'  => true,
        ]);

        $this->transaction = factory(Transactions::class)->create([
            'payer_id'  => $this->payer->user_id,
            'payee_id'  => $this->payee->user_id,
            'amount'    => 50,
            'transaction_status_id' => 1
        ]);

        $this->finishTransferService = $this->app->make(FinishTransferService::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthorizedTransferCheckout()
    {
        $this->finishTransferService->executeFinishAuthorizedTransaction($this->transaction->transaction_id);
        $this->assertTrue((bool) $this->transaction->fresh()->authorized);
        $this->assertEquals(2,$this->transaction->fresh()->transaction_status_id);
        $this->assertEquals(50,$this->payee->fresh()->credit_balance);
        $this->assertEquals(50,$this->payer->fresh()->credit_balance);

    }

    public function testFailedTransferCheckout()
    {
        $this->finishTransferService->executeRollbackFailedTransaction($this->transaction->transaction_id);
        $this->assertFalse((bool) $this->transaction->fresh()->authorized);
        $this->assertEquals(3,$this->transaction->fresh()->transaction_status_id);
        $this->assertEquals(0,$this->payee->fresh()->credit_balance);
        $this->assertEquals(100,$this->payer->fresh()->credit_balance);
    }
}
