<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Account\Operation\Type;

class RefundOut implements OperationInterface
{
    public function getType(): string
    {
        return 'refund_out';
    }
}
