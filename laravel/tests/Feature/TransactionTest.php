<?php

namespace Tests\Feature;

use App\Enums\WalletTypeEnum;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    private const REQUEST_HEADERS = [
        'accept' => 'application/json',
    ];


    private function createWallet(array $options = []): Wallet
    {
        return factory(Wallet::class)->create($options);
    }

    private function getInsertResponse(Wallet $payerWallet, Wallet $payeeWallet, float $value)
    {
        return $this->post(
            '/api/transaction',
            [
                "value" => $value,
                "payer" => $payerWallet->user->id,
                "payee" => $payeeWallet->user->id,
            ],
            self::REQUEST_HEADERS
        );
    }

    private function assertWalletBalance(int $id, float $expectedBalance)
    {
        $wallet = Wallet::findOrFail($id);
        $this->assertTrue(
            $wallet->balance == $expectedBalance,
            "O saldo da carteira #$id não ficou igual ao esperado: {$wallet->balance} != $expectedBalance."
        );
    }

    private function assertValidTransaction(string $payerType, string $payeeType): void
    {
        $initialPayerBalance = rand(1000, 3000);
        $initialPayeeBalance = rand(30, 90);
        $transactionValue = rand(300, 999);
        $payerWallet = $this->createWallet([
            "type" => $payerType,
            "balance" => $initialPayerBalance,
        ]);
        $payeeWallet = $this->createWallet([
            "type" => $payeeType,
            "balance" => $initialPayeeBalance,
        ]);
        $response = $this->getInsertResponse($payerWallet, $payeeWallet, $transactionValue);
        $response->assertStatus(201);
        $response->assertJsonFragment([
            "value" => $transactionValue,
            "payer_wallet_id" => $payerWallet->id,
            "payee_wallet_id" => $payeeWallet->id,
        ]);
        $this->assertWalletBalance($payerWallet->id, $initialPayerBalance - $transactionValue);
        $this->assertWalletBalance($payeeWallet->id, $initialPayeeBalance + $transactionValue);
    }

    public function testUserToUser()
    {
        $this->assertValidTransaction(WalletTypeEnum::USER_WALLET, WalletTypeEnum::USER_WALLET);
    }

    public function testUserToShopkeeper()
    {
        $this->assertValidTransaction(WalletTypeEnum::USER_WALLET, WalletTypeEnum::SHOPKEEPER_WALLET);
    }

    private function assertInvalidTransaction(
        float $initialPayerBalance,
        float $initialPayeeBalance,
        float $transactionValue,
        string $payerType,
        string $payeeType
    ) {
        $payerWallet = $this->createWallet([
            "type" => $payerType,
            "balance" => $initialPayerBalance,
        ]);
        $payeeWallet = $this->createWallet([
            "type" => $payeeType,
            "balance" => $initialPayeeBalance,
        ]);
        $response = $this->getInsertResponse($payerWallet, $payeeWallet, $transactionValue);
        $response->assertStatus(500);
        $this->assertWalletBalance($payerWallet->id, $initialPayerBalance);
        $this->assertWalletBalance($payeeWallet->id, $initialPayeeBalance);
    }

    public function testShopkeeperToUser()
    {
        $this->assertInvalidTransaction(
            rand(1000, 3000),
            rand(30, 90),
            rand(300, 999),
            WalletTypeEnum::SHOPKEEPER_WALLET,
            WalletTypeEnum::USER_WALLET
        );
    }

    public function testInsufficientBalance()
    {
        $this->assertInvalidTransaction(
            rand(30, 90),
            rand(1000, 3000),
            rand(300, 999),
            WalletTypeEnum::USER_WALLET,
            WalletTypeEnum::SHOPKEEPER_WALLET
        );
    }

    public function testFetch()
    {
        $transaction = factory(Transaction::class)->create();
        $response = $this->get('/api/transaction/' . $transaction->id, self::REQUEST_HEADERS);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "id" => $transaction->id,
            "value" => $transaction->value,
            "payer_wallet_id" => $transaction->payer_wallet_id,
            "payee_wallet_id" => $transaction->payee_wallet_id,
        ]);
    }

    public function testDelete()
    {
        $transaction = factory(Transaction::class)->create();
        $response = $this->delete('/api/transaction/' . $transaction->id, [], self::REQUEST_HEADERS);
        $response->assertStatus(204);
        $this->assertDatabaseMissing("transactions", ["id" => $transaction->id]);
    }
}
