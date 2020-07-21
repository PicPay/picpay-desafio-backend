<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Enum\UserType;
use App\Models\Transaction;
use App\Services\AuthService;
use App\Services\PayeeService;
use App\Enum\TransactionStatus;
use App\Events\CreateTransaction;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Event;
use App\Services\AuthorizationService;
use App\Exceptions\InvalidPayerException;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;

class TransactionServiceTest extends TestCase
{
    public function testItShouldNotBePossibleToTransferToYourself()
    {
        $custumer = factory(User::class)->make(['type' => UserType::CUSTUMER]);

        $transactionRepository = Mockery::mock(TransactionRepository::class);
        $authService = Mockery::mock(AuthService::class);
        $payeeService = Mockery::mock(PayeeService::class);
        $authorizationService = Mockery::mock(AuthorizationService::class);

        $authService->shouldReceive('context')->andReturn($custumer);

        $transactionService = new TransactionService($transactionRepository, $authService, $payeeService, $authorizationService);

        $this->expectException(InvalidPayerException::class);
        $this->expectExceptionMessage('It is not possible to transfer from payer to payer.');

        $transactionService->create([
            'value' => 100.00,
            'payer' => $custumer->id,
            'payee' => $custumer->id,
        ]);
    }

    public function testTheSameUserIdentifierMustBeInformedInPayer()
    {
        $seller = factory(User::class)->make(['type' => UserType::SELLER]);
        $custumer = factory(User::class)->make(['type' => UserType::CUSTUMER]);

        $transactionRepository = Mockery::mock(TransactionRepository::class);
        $authService = Mockery::mock(AuthService::class);
        $payeeService = Mockery::mock(PayeeService::class);
        $authorizationService = Mockery::mock(AuthorizationService::class);

        $authService->shouldReceive('context')->andReturn($seller);

        $transactionService = new TransactionService($transactionRepository, $authService, $payeeService, $authorizationService);

        $this->expectException(InvalidPayerException::class);
        $this->expectExceptionMessage('Invalid payer.');

        $transactionService->create([
            'value' => 100.00,
            'payer' => $custumer->id + 1,
            'payee' => $seller->id,
        ]);
    }

    public function testSellerUserCannotMakeTransfers()
    {
        $seller = factory(User::class)->make(['type' => UserType::SELLER]);

        $transactionRepository = Mockery::mock(TransactionRepository::class);
        $authService = Mockery::mock(AuthService::class);
        $payeeService = Mockery::mock(PayeeService::class);
        $authorizationService = Mockery::mock(AuthorizationService::class);

        $authService->shouldReceive('context')->andReturn($seller);

        $transactionService = new TransactionService($transactionRepository, $authService, $payeeService, $authorizationService);

        $this->expectException(InvalidPayerException::class);
        $this->expectExceptionMessage('Seller user cannot make transfers.');

        $transactionService->create([
            'value' => 100.00,
            'payer' => $seller->id,
            'payee' => $seller->id + 1,
        ]);
    }

    public function testTransactionCreation()
    {
        Event::fake();
        $walletCustumer = factory(Wallet::class)->make();

        $custumer = factory(User::class)->make(['type' => UserType::CUSTUMER]);
        $custumer->wallet = $walletCustumer;

        $seller = factory(User::class)->make(['type' => UserType::SELLER]);

        $transactionRepository = Mockery::mock(TransactionRepository::class);
        $authService = Mockery::mock(AuthService::class);
        $payeeService = Mockery::mock(PayeeService::class);
        $authorizationService = Mockery::mock(AuthorizationService::class);

        $authService->shouldReceive('context')->andReturn($custumer);
        $payeeService->shouldReceive('getById')->andReturn($seller);

        $expected = new Transaction();

        $transactionRepository->shouldReceive('createWithAssociations')->with(
            ['value' => 100],
            ['payer' => $custumer, 'payee' => $seller]
        )->andReturn($expected);

        $this->expectsEvents(CreateTransaction::class);

        $transactionService = new TransactionService($transactionRepository, $authService, $payeeService, $authorizationService);

        $newTransaction = $transactionService->create([
            'value' => 100.00,
            'payer' => $custumer->id,
            'payee' => $seller->id,
        ]);

        $this->assertEquals($expected, $newTransaction);
    }

    public function testIfAuthorizedYouMustProcessTheTransaction()
    {
        $transaction = factory(Transaction::class)->make();

        $transactionRepository = Mockery::mock(TransactionRepository::class);
        $authService = Mockery::mock(AuthService::class);
        $payeeService = Mockery::mock(PayeeService::class);
        $authorizationService = Mockery::mock(AuthorizationService::class);

        $authorizationService->shouldReceive('isAuthorized')
            ->with('8fafdd68-a090-496f-8c9a-3442cf30dae6')
            ->once()
            ->andReturn(true);


        $transactionRepository->shouldReceive('update')
            ->with($transaction, ['status' => TransactionStatus::PROCESSED])
            ->once()
            ->andReturn($transaction);

        $transactionService = new TransactionService($transactionRepository, $authService, $payeeService, $authorizationService);

        $transactionService->process($transaction);
    }

    public function testIfNotAuthorizedMarkAsUnauthorized()
    {
        $transaction = factory(Transaction::class)->make();

        $transactionRepository = Mockery::mock(TransactionRepository::class);
        $authService = Mockery::mock(AuthService::class);
        $payeeService = Mockery::mock(PayeeService::class);
        $authorizationService = Mockery::mock(AuthorizationService::class);

        $authorizationService->shouldReceive('isAuthorized')
            ->with('8fafdd68-a090-496f-8c9a-3442cf30dae6')
            ->once()
            ->andReturn(false);

        $transactionRepository->shouldReceive('update')
            ->with($transaction, ['status' => TransactionStatus::UNAUTHORIZED])
            ->once()
            ->andReturn($transaction);

        $transactionService = new TransactionService($transactionRepository, $authService, $payeeService, $authorizationService);

        $transactionService->process($transaction);
    }
}
