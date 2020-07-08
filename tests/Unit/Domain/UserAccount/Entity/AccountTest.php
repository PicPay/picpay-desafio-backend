<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Entity;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use DateTime;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');
        $firstNameExpected = new Name('John');
        $lastNameExpected = new Name('Doe');
        $documentExpected = new Document('57588899034');
        $emailExpected = new Email('john@doe.com');
        $passwordExpected = '123456';
        $balanceExpected = new BalanceAmount(10);
        $createdAtExpected = new DateTime('2020-07-05');
        $updatedAtExpected = new DateTime('2020-07-05');

        $account = new Account();
        $account->setUuid($uuidExpected);
        $account->setFirstName($firstNameExpected);
        $account->setLastName($lastNameExpected);
        $account->setDocument($documentExpected);
        $account->setEmail($emailExpected);
        $account->setPassword($passwordExpected);
        $account->setBalance($balanceExpected);
        $account->setCreatedAt($createdAtExpected);
        $account->setUpdatedAt($updatedAtExpected);

        self::assertEquals($uuidExpected, $account->getUuid());
        self::assertEquals($firstNameExpected, $account->getFirstName());
        self::assertEquals($lastNameExpected, $account->getLastName());
        self::assertEquals($documentExpected, $account->getDocument());
        self::assertEquals($emailExpected, $account->getEmail());
        self::assertEquals($passwordExpected, $account->getPassword());
        self::assertEquals($balanceExpected, $account->getBalance());
        self::assertEquals($createdAtExpected, $account->getCreatedAt());
        self::assertEquals($updatedAtExpected, $account->getUpdatedAt());
    }
}
