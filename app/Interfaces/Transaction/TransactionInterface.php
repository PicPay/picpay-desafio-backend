<?php

namespace App\Interfaces\Transaction;

use App\Models\Transaction\Transaction;

interface TransactionInterface
{
    public function __construct(Transaction $transaction);
    public function create(array $payloadData): array;
    public function updateStatus(string $status, int $id): void;
    public function findById(int $id): array;
}
