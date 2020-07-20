<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Services\AccountService;
use App\Repositories\AccountRepository;

class AccountServiceTest extends TestCase
{
    public function testfunctionMustRegisterAUser()
    {
        $accountRepository = Mockery::mock(AccountRepository::class);

        $accountService = new AccountService($accountRepository);

        $payload = [
            'fullName' => 'Simple PicPay User',
            'email' => 'test-seller@gmail.com',
            'document' => '23859564000180',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'type' => 'SELLER',
        ];

        $accountRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn(new User());

        $accountService->create($payload);
    }

    public function testARegisteredUserMustReturnById()
    {
        $user = factory(User::class)->make();

        $accountRepository = Mockery::mock(AccountRepository::class);

        $accountService = new AccountService($accountRepository);

        $accountRepository
            ->shouldReceive('getById')
            ->with($user->id)
            ->once()
            ->andReturn($user);

        $accountService->getUserById($user->id);
    }
}
