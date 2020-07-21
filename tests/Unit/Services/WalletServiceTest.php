<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\AuthService;
use App\Services\WalletService;
use App\Repositories\WalletRepository;

class WalletServiceTest extends TestCase
{
    public function testYouMustCreateANewWallet()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);
        $authService = Mockery::mock(AuthService::class);

        $walletRepository->shouldReceive('create')->with(['amount' => 102.2])
            ->once()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository, $authService);

        $walletService->create(['amount' => 102.2]);
    }

    public function testMustWithdrawMoneyFromTheWalletUsingATransaction()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);
        $authService = Mockery::mock(AuthService::class);

        $transaction = factory(Transaction::class)->make();

        $payer = factory(User::class)->make();

        $wallet = factory(Wallet::class)->make();

        $payer->wallet = $wallet;

        $transaction->payer = $payer;

        $walletRepository->shouldReceive('update')->with($wallet, ['amount' => bcsub($wallet->amount, $transaction->value)])
            ->once()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository, $authService);

        $walletService->withdrawByTransaction($transaction);
    }

    public function testMustAddMoneyToTheWalletUsingATransaction()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);
        $authService = Mockery::mock(AuthService::class);

        $transaction = factory(Transaction::class)->make();

        $payee = factory(User::class)->make();

        $wallet = factory(Wallet::class)->make();

        $payee->wallet = $wallet;

        $transaction->payee = $payee;

        $walletRepository->shouldReceive('update')->with($wallet, ['amount' => bcadd($wallet->amount, $transaction->value)])
            ->once()
            ->andReturn(new Wallet());

        $walletService = new WalletService($walletRepository, $authService);

        $walletService->depositByTransaction($transaction);
    }

    public function testMustReturnThePayerMoneyAndCancelThePayeeMoney()
    {
        $walletRepository = Mockery::mock(WalletRepository::class);
        $authService = Mockery::mock(AuthService::class);

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

        $walletService = new WalletService($walletRepository, $authService);

        $walletService->rollbackByTransaction($transaction);
    }

    public function testMustAddAValueSpecifiedInTheWallet()
    {
        $user = factory(User::class)->make();
        $wallet = factory(Wallet::class)->make(['amount' => 10]);
        $user->wallet = $wallet;

        $walletRepository = Mockery::mock(WalletRepository::class);

        $walletRepository->shouldReceive('update')->with($wallet, ['amount' => 20])->once()->andReturn($wallet);

        $authService = Mockery::mock(AuthService::class);

        $authService->shouldReceive('context')->once()->andReturn($user);

        $walletService = new WalletService($walletRepository, $authService);

        $walletService->directWithdraw(10.10);
    }
}
