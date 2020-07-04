<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\Exception\ValueObject\Email\InvalidValueException;
use App\Domain\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testGetValue(): void
    {
        $emailExpected = 'john@doe.com';
        $email = new Email($emailExpected);

        self::assertEquals($emailExpected, $email->getValue());
    }

    public function testConstructThrowInvalidValueException(): void
    {
        self::expectException(InvalidValueException::class);

        new Email('other');
    }

    public function testIsValid(): void
    {
        self::assertTrue(Email::isValid('john@doe.com'));
    }

    public function testIsNotValid(): void
    {
        self::assertFalse(Email::isValid('other'));
    }
}
