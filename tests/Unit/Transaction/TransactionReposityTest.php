<?php

namespace Tests\Unit\Transaction;

use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Repositories\Transaction\TransactionRepository;
use App\Models\Transaction\Transaction;
use Faker\Generator as Faker;

class TransactionReposityTest extends TestCase
{
    use DatabaseMigrations;

    const TRANSACTION_TABLE = "transactions";

    private $payload;
    private $transcationRepository;

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

        $this->transcationRepository = app(TransactionRepository::class);
        
        $this->withoutEvents();
    }

    /**
     * Testing transaction creation class
     *
     * @return void
     */
    public function test_can_create_transaction(): void
    {
        $transactionRecord = $this->transcationRepository->create($this->payload);

        $this->removeDateFields($transactionRecord);

        $this->seeInDatabase(self::TRANSACTION_TABLE, $transactionRecord);
    }

    /**
     *  Transaction update status method
     *
     * @return void
     */
    public function test_can_update_status_transaction(): void
    {
        $transactionRecord = $this->transcationRepository->create($this->payload);
        
        $transactionRecord["status"] = $newStatus = Transaction::AUTHORIZED;

        $this->transcationRepository->updateStatus($newStatus, $transactionRecord["id"]);
        
        $this->removeDateFields($transactionRecord);

        $this->seeInDatabase(self::TRANSACTION_TABLE, $transactionRecord);
    }

    /**
     *  Testing transaction findById method
     *
     * @return void
     */
    public function test_can_find_by_id(): void
    {
        $transactionRecord = $this->transcationRepository->create($this->payload);

        $this->removeDateFields($transactionRecord);
        
        $transactionFound = $this->transcationRepository->findById($transactionRecord["id"]);
        
        $this->removeDateFields($transactionFound);

        $this->assertEquals($transactionRecord, $transactionFound);
    }

    /**
     *  Testing transaction findById method that couldnt find
     *
     * @return void
     */
    public function test_cant_find_by_id(): void
    {
        $transactionRecord = $this->transcationRepository->create($this->payload);

        $faker = app(Faker::class);

        $fakeTransactionId = $faker->numberBetween($transactionRecord["id"] + 1, 10);
        
        $transactionFound = $this->transcationRepository->findById($fakeTransactionId);

        $this->assertEquals([], $transactionFound);
    }

    /**
     *  Testing transaction findById method that couldnt find
     *
     * @return void
     */
    public function test_cant_update_with_id(): void
    {
        $faker = app(Faker::class);
        
        $transactionRecord = $this->transcationRepository->create($this->payload);
        
        $transactionRecord["status"] = $newStatus = Transaction::AUTHORIZED;

        $transactionRecord["id"] = $faker->numberBetween($transactionRecord["id"] + 1, 10);

        $this->transcationRepository->updateStatus($newStatus, $transactionRecord["id"]);
        
        $this->removeDateFields($transactionRecord);

        $this->notSeeInDatabase(self::TRANSACTION_TABLE, $transactionRecord);
    }
}
