<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\ValueObject\Document\InvalidNumberException;
use App\Domain\Shared\ValueObject\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testAttributes(): void
    {
        $cpfNumberExpected = '57588899034';
        $cpfTypeExpected = Document::TYPE_CPF;
        $cnpjNumberExpected = '06074197000190';
        $cnpjTypeExpected = Document::TYPE_CNPJ;
        $cpf = new Document($cpfNumberExpected);
        $cnpj = new Document($cnpjNumberExpected);

        self::assertEquals($cpfNumberExpected, $cpf->getNumber());
        self::assertEquals($cpfTypeExpected, $cpf->getType());
        self::assertTrue($cpf->isTypeCpf());
        self::assertFalse($cpf->isTypeCnpj());

        self::assertEquals($cnpjNumberExpected, $cnpj->getNumber());
        self::assertEquals($cnpjTypeExpected, $cnpj->getType());
        self::assertFalse($cnpj->isTypeCpf());
        self::assertTrue($cnpj->isTypeCnpj());
    }

    public function testConstructThrowInvalidNumberException(): void
    {
        self::expectException(InvalidNumberException::class);

        new Document('other');
    }

    public function testIsValidCpf(): void
    {
        self::assertTrue(Document::isValidCpf('57588899034'));
    }

    public function testIsNotValidCpf(): void
    {
        self::assertFalse(Document::isValidCpf('57588899030'));
    }

    public function testIsValidCnpj(): void
    {
        self::assertTrue(Document::isValidCnpj('06074197000190'));
    }

    public function testIsNotValidCnpj(): void
    {
        self::assertFalse(Document::isValidCnpj('06074197000192'));
    }
}
