<?php

namespace Tests\Unit\Job;

use Mockery;
use Tests\TestCase;
use App\Events\CreateTransaction;
use App\Services\NotificationService;
use App\Jobs\NotificationPaymentReceived;
use App\Models\Transaction;
use App\Models\User;

class NotificationPaymentReceivedTest extends TestCase
{
    public function testShouldCallsTheNotificationFunction()
    {
        $user = factory(User::class)->make();
        $transaction = factory(Transaction::class)->make();
        $transaction->payee = $user;

        $createTransaction = Mockery::mock(CreateTransaction::class);
        $createTransaction->shouldReceive('getTransaction')->once()->andReturn($transaction);

        $notificationService = Mockery::mock(NotificationService::class);
        $notificationService->shouldReceive('sendNotification')->with($user, "You have just received a payment of $transaction->value");

        $notificationPaymentReceived = new NotificationPaymentReceived($notificationService);

        $notificationPaymentReceived->handle($createTransaction);
    }
}
