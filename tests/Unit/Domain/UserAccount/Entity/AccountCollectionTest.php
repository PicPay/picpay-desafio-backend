<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\UserAccount\Entity;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Entity\AccountCollection;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AccountCollectionTest extends TestCase
{
    public function testAttributes(): void
    {
        $accountOne = $this->getAccount();
        $accountTwo = $this->getAccount();

        $accountCollection = new AccountCollection();

        self::assertCount(0, $accountCollection->get());
        self::assertTrue($accountCollection->add($accountOne));
        self::assertFalse($accountCollection->add($accountOne));

        self::assertFalse($accountCollection->has($accountTwo));
        $accountCollection->add($accountTwo);
        self::assertTrue($accountCollection->has($accountTwo));

        self::assertTrue($accountCollection->remove($accountTwo));
        self::assertFalse($accountCollection->remove($accountTwo));

        self::assertCount(1, $accountCollection->get());
    }

    private function getAccount(): Account
    {
        $account = new Account();
        $account->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $account->setFirstName(new Name('John'));
        $account->setLastName(new Name('Doe'));
        $account->setDocument(new Document('57588899034'));
        $account->setEmail(new Email('john@doe.com'));
        $account->setPassword('123456');
        $account->setBalance(new BalanceAmount(10));
        $account->setCreatedAt(new DateTime('2020-07-05'));

        return $account;
    }
}
