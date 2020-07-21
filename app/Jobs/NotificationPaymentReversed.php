<?php

namespace App\Jobs;

use App\Events\CreateTransaction;
use App\Services\NotificationService;

class NotificationPaymentReversed extends Queue
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

        $this->notificationService->sendNotification($transaction->payer, "It was not possible to complete your transfer in the amount of $transaction->value");
        $this->notificationService->sendNotification($transaction->payee, "A $transaction->value payment was reversed");
    }
}
