<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\ValueObject\Amount\InvalidValueException;
use App\Domain\Shared\ValueObject\Amount;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    public function testGetValue(): void
    {
        $valueExpected = 10;
        $amount = new Amount($valueExpected);

        self::assertEquals($valueExpected, $amount->getValue());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new Amount(-1);
    }
}
