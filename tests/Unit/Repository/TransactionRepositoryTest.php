<?php

namespace Tests\Unit\Repository;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Pagination\Paginator;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepositoryTest extends TestCase
{
    public function testMustListAllTransactionsFilteringByUserAndStatus()
    {
        $user = Mockery::mock(factory(User::class)->make());
        $transaction = Mockery::mock(factory(Transaction::class)->make());
        $status = [];
        $pearPage = 10;

        $builderMock = Mockery::mock(Builder::class);

        $this->app->instance(Transaction::class, $transaction);

        $builderMock->shouldReceive('where')->with('payer_id', $user->id)->once()
            ->andReturn($builderMock)
            ->shouldReceive('whereIn')->with('status', $status)->once()
            ->andReturn($builderMock)
            ->shouldReceive('paginate')->once()
            ->andReturn(new Paginator([$transaction], 10));

        $transaction->shouldReceive('newQuery')->once()->andReturn($builderMock);

        $accountRepository = new TransactionRepository();

        $accountRepository->listPaginate($user, $status, $pearPage);
    }

    public function testMustReturnATransactionFilteringByUserAndId()
    {
        $user = Mockery::mock(factory(User::class)->make());
        $transaction = Mockery::mock(factory(Transaction::class)->make());

        $builderMock = Mockery::mock(Builder::class);

        $this->app->instance(Transaction::class, $transaction);

        $builderMock->shouldReceive('where')->with([['payer_id', $user->id], ['id', $transaction->id]])
            ->once()
            ->andReturn($builderMock)
            ->shouldReceive('firstOrFail')->once()
            ->andReturn($transaction);

        $transaction->shouldReceive('newQuery')->once()->andReturn($builderMock);

        $accountRepository = new TransactionRepository();

        $accountRepository->findByUserAndId($user, $transaction->id);
    }
}
