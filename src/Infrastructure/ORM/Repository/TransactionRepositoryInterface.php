<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Repository;

use App\Infrastructure\ORM\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function add(Transaction $transaction): Transaction;

    public function getList(): array;

    public function get(string $uuid): ?Transaction;
}
