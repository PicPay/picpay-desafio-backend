<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;

interface TransactionRepositoryInterface
{
    public function list(): TransactionCollection;
}
