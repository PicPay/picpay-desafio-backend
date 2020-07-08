<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\ValueObject\Name\InvalidValueException;
use App\Domain\Shared\ValueObject\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testGetValue(): void
    {
        $nameExpected = 'João';
        $name = new Name($nameExpected);

        self::assertEquals($nameExpected, $name->getValue());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new Name('o');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Name::isValid('João'));
    }

    public function testIsNotValid(): void
    {
        self::assertFalse(Name::isValid('o'));
    }
}
