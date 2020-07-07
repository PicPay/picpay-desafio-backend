<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Operation\Type;

class RefundIn implements OperationInterface
{
    public function getType(): string
    {
        return 'refund_in';
    }
}
