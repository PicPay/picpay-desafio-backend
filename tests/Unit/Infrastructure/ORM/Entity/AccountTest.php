<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Entity\Account;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testAttributes(): void
    {
        $firstNameExpected = 'John';
        $lastNameExpected = 'Doe';
        $documentNumberExpected = '00412651068';
        $documentTypeExpected = 'cpf';
        $emailExpected = 'john@doe.com';
        $passwordExpected = '123456';
        $balanceExpected = 1250;

        $account = new Account();

        self::assertNull($account->getCreatedAt());
        self::assertNull($account->getCreatedAtString());
        self::assertNull($account->getUpdatedAt());
        self::assertNull($account->getUpdatedAtString());

        $account->forgeCreatedAt();
        $account->forgeUpdatedAt();

        self::assertInstanceOf(DateTimeInterface::class, $account->getCreatedAt());
        self::assertIsString($account->getCreatedAtString());
        self::assertInstanceOf(DateTimeInterface::class, $account->getUpdatedAt());
        self::assertIsString($account->getUpdatedAtString());

        $account->forgeUuid();

        self::assertIsString($account->getUuid());

        $account->setFirstName($firstNameExpected);
        $account->setLastName($lastNameExpected);
        $account->setDocumentNumber($documentNumberExpected);
        $account->setDocumentType($documentTypeExpected);
        $account->setEmail($emailExpected);
        $account->setPassword($passwordExpected);
        $account->setBalance($balanceExpected);

        self::assertEquals($firstNameExpected, $account->getFirstName());
        self::assertEquals($lastNameExpected, $account->getLastName());
        self::assertEquals($documentNumberExpected, $account->getDocumentNumber());
        self::assertEquals($documentTypeExpected, $account->getDocumentType());
        self::assertEquals($emailExpected, $account->getEmail());
        self::assertEquals($passwordExpected, $account->getPassword());
        self::assertEquals($balanceExpected, $account->getBalance());
    }
}
