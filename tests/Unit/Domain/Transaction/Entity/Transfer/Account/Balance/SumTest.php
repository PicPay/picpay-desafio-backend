<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer\Account\Balance;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Transaction\Entity\Transfer\Account\Balance\Sum;
use PHPUnit\Framework\TestCase;

class SumTest extends TestCase
{
    public function testGetBalance(): void
    {
        $transactionAmount = new TransactionAmount(250);
        $balanceAmount = new BalanceAmount(1000);
        $sum = new Sum();
        $balanceAmountGot = $sum->getBalance($transactionAmount, $balanceAmount);

        self::assertEquals(1250, $balanceAmountGot->getValue());
    }
}
