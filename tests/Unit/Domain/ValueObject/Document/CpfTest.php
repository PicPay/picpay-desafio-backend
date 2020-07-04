<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\ValueObject\Document;

use App\Domain\Exception\ValueObject\Document\Cpf\InvalidNumberException;
use App\Domain\ValueObject\Document\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    public function testGetNumber(): void
    {
        $numberExpected = '57588899034';
        $cpf = new Cpf($numberExpected);

        self::assertEquals($numberExpected, $cpf->getNumber());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Cpf('57588899030');
    }

    public function testIsValidNumber(): void
    {
        self::assertTrue(Cpf::isValidNumber('57588899034'));
    }

    public function testIsNotValidNumber(): void
    {
        self::assertFalse(Cpf::isValidNumber('57588899030'));
    }
}
