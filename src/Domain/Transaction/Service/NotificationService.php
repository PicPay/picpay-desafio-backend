<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service;

use App\Domain\Transaction\Component\Vendor\NotificationBazQux\ApiClient\ApiClientInterface;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use Throwable;

class NotificationService implements NotificationServiceInterface
{
    private ApiClientInterface $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function handleNotificationNewTransaction(Transaction $transaction): void
    {
        try {
            $this
                ->apiClient
                ->notifyNewTransaction($transaction)
            ;
        } catch (Throwable $e) {
        }
    }
}
