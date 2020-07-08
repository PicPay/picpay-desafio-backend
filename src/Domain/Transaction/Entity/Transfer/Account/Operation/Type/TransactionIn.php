<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Account\Operation\Type;

class TransactionIn implements OperationInterface
{
    public function getType(): string
    {
        return 'transaction_in';
    }
}
