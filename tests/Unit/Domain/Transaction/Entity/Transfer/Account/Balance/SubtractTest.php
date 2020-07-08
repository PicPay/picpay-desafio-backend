<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer\Account\Balance;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Transaction\Entity\Transfer\Account\Balance\Subtract;
use PHPUnit\Framework\TestCase;

class SubtractTest extends TestCase
{
    public function testGetBalance(): void
    {
        $transactionAmount = new TransactionAmount(250);
        $balanceAmount = new BalanceAmount(1250);
        $subtract = new Subtract();
        $balanceAmountGot = $subtract->getBalance($transactionAmount, $balanceAmount);

        self::assertEquals(1000, $balanceAmountGot->getValue());
    }
}
