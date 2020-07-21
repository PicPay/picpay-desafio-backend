<?php

namespace App\Jobs;

use App\Events\CreateTransaction;
use App\Services\NotificationService;

class NotificationPaymentReceived extends Queue
{
    private $notificationService;

    public $tries = 25;

    public $maxExceptions = 3;

    public $timeout = 20;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CreateTransaction $createTransactionEvent): void
    {
        $transaction = $createTransactionEvent->getTransaction();

        $this->notificationService->sendNotification($transaction->payee, "You have just received a payment of $transaction->value");
    }
}
