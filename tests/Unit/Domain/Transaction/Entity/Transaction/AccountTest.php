<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transaction;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');
        $documentExpected = new Document('57588899034');

        $account = new Account();
        $account->setUuid($uuidExpected);
        $account->setDocument($documentExpected);

        self::assertEquals($uuidExpected, $account->getUuid());
        self::assertEquals($documentExpected, $account->getDocument());
    }
}
