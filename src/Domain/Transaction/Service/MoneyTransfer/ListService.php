<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;

final class ListService extends AbstractService
{
    public function handleList(): TransactionCollection
    {
        return $this
            ->getTransactionRepository()
            ->list()
        ;
    }
}
