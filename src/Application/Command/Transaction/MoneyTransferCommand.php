<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction;

class MoneyTransferCommand
{
    public function execute(array $data): array
    {
        return [
            'oi' => 'tudo bom?',
            'data' => $data,
        ];
    }
}
