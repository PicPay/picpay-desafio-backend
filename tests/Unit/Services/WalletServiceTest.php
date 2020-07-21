<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\WalletService;
use App\Repositories\WalletRepository;

class WalletServiceTest extends TestCase
{
    public function testYouMustCreateANewWallet()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);

        $walletRepository->shouldReceive('create')->with(['amount' => 102.2])
            ->once()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository);

        $walletService->create(['amount' => 102.2]);
    }

    public function testMustWithdrawMoneyFromTheWalletUsingATransaction()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);

        $transaction = factory(Transaction::class)->make();

        $payer = factory(User::class)->make();

        $wallet = factory(Wallet::class)->make();

        $payer->wallet = $wallet;

        $transaction->payer = $payer;

        $walletRepository->shouldReceive('update')->with($wallet, ['amount' => bcsub($wallet->amount, $transaction->value)])
            ->once()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository);

        $walletService->withdrawByTransaction($transaction);
    }

    public function testMustAddMoneyToTheWalletUsingATransaction()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);

        $transaction = factory(Transaction::class)->make();

        $payee = factory(User::class)->make();

        $wallet = factory(Wallet::class)->make();

        $payee->wallet = $wallet;

        $transaction->payee = $payee;

        $walletRepository->shouldReceive('update')->with($wallet, ['amount' => bcadd($wallet->amount, $transaction->value)])
            ->once()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository);

        $walletService->depositByTransaction($transaction);
    }

    public function testMustReturnThePayerMoneyAndCancelThePayeeMoney()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);

        $transaction = factory(Transaction::class)->make();

        $payee = factory(User::class)->make();
        $wallet = factory(Wallet::class)->make();
        $payee->wallet = $wallet;
        $transaction->payee = $payee;

        $payer = factory(User::class)->make();
        $wallet = factory(Wallet::class)->make();
        $payer->wallet = $wallet;
        $transaction->payer = $payer;

        $walletRepository->shouldReceive('update')
            ->twice()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository);

        $walletService->rollbackByTransaction($transaction);
    }
}
