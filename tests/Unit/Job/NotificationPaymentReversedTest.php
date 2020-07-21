<?php

namespace Tests\Unit\Job;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction;
use App\Events\CreateTransaction;
use App\Services\NotificationService;
use App\Jobs\NotificationPaymentReversed;

class NotificationPaymentReversedTest extends TestCase
{
    public function testShouldCallsTheNotificationFunction()
    {
        $payee = factory(User::class)->make();
        $payer = factory(User::class)->make();

        $transaction = factory(Transaction::class)->make();
        $transaction->payee = $payee;
        $transaction->payer = $payer;

        $createTransaction = Mockery::mock(CreateTransaction::class);
        $createTransaction->shouldReceive('getTransaction')->once()->andReturn($transaction);

        $notificationService = Mockery::mock(NotificationService::class);
        $notificationService->shouldReceive('sendNotification')->twice();

        $notificationPaymentReversed = new NotificationPaymentReversed($notificationService);

        $notificationPaymentReversed->handle($createTransaction);
    }
}
