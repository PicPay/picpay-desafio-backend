<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Component\Vendor\NotificationBazQux\ApiClient;

use App\Domain\Transaction\Entity\Transaction\Transaction;

interface ApiClientInterface
{
    public function notifyNewTransaction(Transaction $transaction): bool;
}
