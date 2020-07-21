<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use App\Services\AccountService;
use App\Repositories\AccountRepository;

class AccountServiceTest extends TestCase
{
    public function testfunctionMustRegisterAUser()
    {
        $accountRepository = Mockery::mock(AccountRepository::class);
        $walletService = Mockery::mock(WalletService::class);

        $walletService
            ->shouldReceive('create')
            ->with([])
            ->once(factory(Wallet::class)->make());

        $accountService = new AccountService($accountRepository, $walletService);

        $payload = [
            'fullName' => 'Simple PicPay User',
            'email' => 'test-seller@gmail.com',
            'document' => '23859564000180',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'type' => 'SELLER',
        ];

        $accountRepository
            ->shouldReceive('createWithAssociations')
            ->once()
            ->andReturn(new User());

        $accountService->create($payload);
    }

    public function testARegisteredUserMustReturnById()
    {
        $user = factory(User::class)->make();

        $accountRepository = Mockery::mock(AccountRepository::class);
        $walletService = Mockery::mock(WalletService::class);

        $accountService = new AccountService($accountRepository, $walletService);

        $accountRepository
            ->shouldReceive('getById')
            ->with($user->id)
            ->once()
            ->andReturn($user);

        $accountService->getUserById($user->id);
    }
}
