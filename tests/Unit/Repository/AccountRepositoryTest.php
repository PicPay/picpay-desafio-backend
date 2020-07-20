<?php

namespace Tests\Unit\Repository;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Builder;

class AccountRepositoryTest extends TestCase
{
    public function testMustReturnAUserUsingTheId()
    {
        $user = Mockery::mock(factory(User::class)->make());

        $builderMock = Mockery::mock(Builder::class);

        $this->app->instance(User::class, $user);

        $builderMock->shouldReceive('where')->with('id', $user->id)->once()
            ->andReturn($builderMock)
            ->shouldReceive('select')->with(['*'])->once()
            ->andReturn($builderMock)
            ->shouldReceive('first')->once()
            ->andReturn($user);

        $user->shouldReceive('newQuery')->once()->andReturn($builderMock);

        $accountRepository = new AccountRepository();

        $accountRepository->getById($user->id);
    }
}
