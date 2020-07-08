<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;

interface ListServiceInterface
{
    public function handleList(): TransactionCollection;
}
