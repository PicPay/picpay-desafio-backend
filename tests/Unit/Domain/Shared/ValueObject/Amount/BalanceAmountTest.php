<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\ValueObject\Amount;

use App\Domain\Shared\Exception\ValueObject\Amount\BalanceAmount\InvalidValueException;
use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use PHPUnit\Framework\TestCase;

class BalanceAmountTest extends TestCase
{
    public function testAttributes(): void
    {
        $valueExpected = 10;
        $valueDecimalExpected = '0.10';
        $balance = new BalanceAmount($valueExpected);

        self::assertEquals($valueExpected, $balance->getValue());
        self::assertEquals($valueDecimalExpected, $balance->getValueDecimal());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new BalanceAmount(-1);
    }

    public function testIsValid(): void
    {
        self::assertTrue(BalanceAmount::isValid(10));
    }

    public function testIsNotValid(): void
    {
        self::assertFalse(BalanceAmount::isValid(-1));
    }
}
