<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\AmountInterface;

final class PayerAccount extends AbstractAccount
{
    private AmountInterface $balance;

    public function getBalance(): AmountInterface
    {
        return $this->balance;
    }

    public function setBalance(AmountInterface $balance): void
    {
        $this->balance = $balance;
    }
}
