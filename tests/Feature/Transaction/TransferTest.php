<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Events\Transaction\Validation;
use App\Interfaces\Transaction\TransactionInterface;
use App\Interfaces\User\UserWalletInterface;
use App\Models\Transaction\Transaction;
use App\Listeners\Transaction\Authorization;
use Mockery;

class TransferTest extends TestCase
{
    use DatabaseMigrations;

    const TRANSACTION_API_URL = '/api/v1/transaction';

    const TRANSACTION_TABLE = "transactions";
    const USER_WALLET_TABLE = "users_wallet";

    const DEFAULT_METHOD = "POST";

    private $payload;

    private $transcationRepository;
    private $walletRepository;

    /**
     *  Setup for payload initialize.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->payload = [
            'payer' => $this->createCommonUser()->user_id,
            'payee' => $this->createShopKeeper()->user_id,
            'value' => 90
        ];

        $this->transcationRepository = app(TransactionInterface::class);
        $this->walletRepository = app(UserWalletInterface::class);
    }

    /**
     * Testing transaction intent of transfer credits
     *
     * @return void
     */
    public function test_transaction_intent(): void
    {
        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->seeInDatabase(self::TRANSACTION_TABLE, $this->payload);
    }

    /**
     *  Transaction fire event test
     *
     * @return void
     */
    public function test_transaction_event(): void
    {
        $this->expectsEvents(Validation::class);
        
        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

    }

    /**
     *  Testing transaction success between two users
     *
     * @return void
     */
    public function test_transaction_sucessful(): void
    {
        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->payload["status"] = Transaction::APPROVED;

        $this->seeInDatabase(self::TRANSACTION_TABLE, $this->payload);
    }

    /**
     * Testing money increase on user wallet
     *
     * @return void
     */
    public function test_improve_user_wallet(): void
    {
        $payerWalletBefore = $this->walletRepository->findByUserId($this->payload["payer"]);
        $payeeWalletBefore = $this->walletRepository->findByUserId($this->payload["payee"]);
        
        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $payeeWalletBefore["amount"] += $this->payload["value"];

        $this->removeDateFields($payeeWalletBefore);

        $this->seeInDatabase(self::USER_WALLET_TABLE, $payeeWalletBefore);
    }

    /**
     * Testing money descrease on user wallet
     *
     * @return void
     */
    public function test_descrease_user_wallet_amount(): void
    {
        $payerWalletBefore = $this->walletRepository->findByUserId($this->payload["payer"]);
        
        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $payerWalletBefore["amount"] -= $this->payload["value"];

        $this->removeDateFields($payerWalletBefore);

        $this->seeInDatabase(self::USER_WALLET_TABLE, $payerWalletBefore);
    }

    /**
     *
     *
     * @return void
     */
    public function test_declined_transaction(): void
    {
        $this->changeAuthorizationService();

        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->payload["status"] = Transaction::INCONSISTENCY;

        $this->seeInDatabase(self::TRANSACTION_TABLE, $this->payload);
    }

    /**
     * Setting to a non existant service
     *
     * @return void
     */
    private function changeAuthorizationService(): void
    {
        config(['external.authorization' => 'http://en.c1']);
    }
}
