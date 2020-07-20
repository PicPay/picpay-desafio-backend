<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Services\PayeeService;
use App\Services\AccountService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PayeeServiceTest extends TestCase
{
    public function testMustReturnSingleBeneficiary()
    {
        $transaction = factory(User::class)->make();

        $accountService = Mockery::mock(AccountService::class);

        $accountService->shouldReceive('getUserById')
            ->with($transaction->id)
            ->once()
            ->andReturn($transaction);

        $payeeService = new PayeeService($accountService);

        $payeeService->getById($transaction->id);
    }

    public function testReturnErrorIfBeneficiaryIsNotFound()
    {
        $transaction = factory(User::class)->make();

        $accountService = Mockery::mock(AccountService::class);

        $accountService->shouldReceive('getUserById')
            ->with($transaction->id)
            ->once()
            ->andThrow(new ModelNotFoundException('Could not find beneficiary'));

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Could not find beneficiary');

        $payeeService = new PayeeService($accountService);

        $payeeService->getById($transaction->id);
    }
}
