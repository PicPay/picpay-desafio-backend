<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObject\Document;

use App\Domain\Exception\ValueObject\Document\Cnpj\InvalidNumberException;
use App\Domain\ValueObject\Document\Cnpj;
use PHPUnit\Framework\TestCase;

class CnpjTest extends TestCase
{
    public function testGetNumber(): void
    {
        $numberExpected = '06074197000190';
        $cnpj = new Cnpj($numberExpected);

        self::assertEquals($numberExpected, $cnpj->getNumber());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Cnpj('06074197000192');
    }

    public function testIsValidNumber(): void
    {
        self::assertTrue(Cnpj::isValidNumber('06074197000190'));
    }

    public function testIsNotValidNumber(): void
    {
        self::assertFalse(Cnpj::isValidNumber('06074197000192'));
    }
}
