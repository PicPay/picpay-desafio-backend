<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer\Operation\Type;

// @todo move this to App\Domain\Transaction\Entity\Transfer\Account\Operation\Type
interface OperationInterface
{
    public function getType(): string;
}
