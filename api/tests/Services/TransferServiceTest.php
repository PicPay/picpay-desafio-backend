<?php

use App\Models\Transfer;
use App\Services\Contracts\AuthorizationResultInterface;
use App\Services\Contracts\AuthorizationServiceInterface;
use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Services\TransferService;
use PHPUnit\Framework\MockObject\MockObject;


class TransferServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider dataProviderTestTransfer
     */
    public function testTransfer(
        $payer,
        $payee,
        $amount,
        $authorizationService,
        $status
    )
    {
        $s = new TransferService($authorizationService);
        $transfer = $s->transfer($payer, $payee, $amount);
        $this->assertEquals($status, $transfer->status);
    }

    public function dataProviderTestTransfer()
    {
        $this->refreshApplication();
        $this->runDatabaseMigrations();
        return [
            [
                factory('App\Models\User')->create(['balance' => 900]),
                factory('App\Models\User')->create(),
                500,
                (function() {
                    $result = $this->getAuthorizationResultMock();
                    $result->method('isSuccess')->willReturn(true);
                    $mock = $this->getAuthorizationServiceMock();
                    $mock->expects($this->once())->method('authorize')->willReturn($result);
                    return $mock;
                })(),
                Transfer::STATUS_SUCCEEDED
            ],
            [
                factory('App\Models\User')->create(['balance' => 900]),
                factory('App\Models\User')->create(),
                500,
                (function() {
                    $result = $this->getAuthorizationResultMock();
                    $result->method('isSuccess')->willReturn(false);
                    $mock = $this->getAuthorizationServiceMock();
                    $mock->expects($this->once())->method('authorize')->willReturn($result);
                    return $mock;
                })(),
                Transfer::STATUS_FAIL
            ],
            [
                factory('App\Models\User')->create(['isCompany' => true]),
                factory('App\Models\User')->create(),
                500,
                (function() {
                    $mock = $this->getAuthorizationServiceMock();
                    $mock->expects($this->never())->method('authorize');
                    return $mock;
                })(),
                Transfer::STATUS_INVALID
            ],
            [
                factory('App\Models\User')->create(['balance' => 10]),
                factory('App\Models\User')->create(),
                500,
                (function() {
                    $mock = $this->getAuthorizationServiceMock();
                    $mock->expects($this->never())->method('authorize');
                    return $mock;
                })(),
                Transfer::STATUS_INVALID
            ],
            [
                factory('App\Models\User')->create(['balance' => 900]),
                factory('App\Models\User')->state('company')->create(),
                500,
                (function() {
                    $result = $this->getAuthorizationResultMock();
                    $result->method('isSuccess')->willReturn(true);
                    $mock = $this->getAuthorizationServiceMock();
                    $mock->expects($this->once())->method('authorize')->willReturn($result);
                    return $mock;
                })(),
                Transfer::STATUS_SUCCEEDED
            ],
        ];
    }

    /**
     * @return AuthorizationServiceInterface|MockObject
     */
    public function getAuthorizationServiceMock()
    {
        return $this->getMockBuilder(AuthorizationServiceInterface::class)->getMock();
    }

    /**
     * @return AuthorizationResultInterface|MockObject
     */
    public function getAuthorizationResultMock()
    {
        return $this->getMockBuilder(AuthorizationResultInterface::class)->getMock();
    }
}

