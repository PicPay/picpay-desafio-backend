<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\ORM\Builder;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Infrastructure\ORM\Builder\AccountBuilder;
use App\Infrastructure\ORM\Entity\Account;
use PHPUnit\Framework\TestCase;

class AccountBuilderTest extends TestCase
{
    public function testAttributes(): void
    {
        $account = (new AccountBuilder())
            ->addFirstName(new Name('John'))
            ->addLastName(new Name('Doe'))
            ->addDocument(new Document('00412651068'))
            ->addEmail(new Email('john@doe.com'))
            ->addPassword('123456')
            ->addBalance(new BalanceAmount(1250))
            ->get()
        ;

        self::assertInstanceOf(Account::class, $account);
    }
}
