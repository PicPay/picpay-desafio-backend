<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Domain\Transaction\Entity\Transaction\Transaction;

interface NotificationServiceInterface
{
    public function handleNotificationNewTransaction(Transaction $transaction): void;
}
