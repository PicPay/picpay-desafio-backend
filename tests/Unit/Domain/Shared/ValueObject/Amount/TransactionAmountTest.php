<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\ValueObject\Amount;

use App\Domain\Shared\Exception\ValueObject\Amount\TransactionAmount\InvalidValueException;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use PHPUnit\Framework\TestCase;

class TransactionAmountTest extends TestCase
{
    public function testAttributes(): void
    {
        $valueExpected = 1257;
        $valueDecimalExpected = '12.57';
        $balance = new TransactionAmount($valueExpected);

        self::assertEquals($valueExpected, $balance->getValue());
        self::assertEquals($valueDecimalExpected, $balance->getValueDecimal());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new TransactionAmount(0);
    }

    public function testIsValid(): void
    {
        self::assertTrue(TransactionAmount::isValid(10));
    }

    public function testIsNotValid(): void
    {
        self::assertFalse(TransactionAmount::isValid(0));
    }
}
