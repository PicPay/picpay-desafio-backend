<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;

interface TransactionRepositoryInterface
{
    public function list(): TransactionCollection;

    public function create(MoneyTransfer $moneyTransfer): Transaction;
}
