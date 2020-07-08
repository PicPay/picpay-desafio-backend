<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Entity\Account;
use App\Infrastructure\ORM\Entity\Operation;
use App\Infrastructure\ORM\Entity\Transaction;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    public function testAttributes(): void
    {
        $typeExpected = 'refund_in';
        $accountExpected = new Account();
        $transactionExpected = new Transaction();

        $operation = new Operation();

        self::assertNull($operation->getCreatedAt());
        self::assertNull($operation->getCreatedAtString());

        $operation->forgeCreatedAt();

        self::assertInstanceOf(DateTimeInterface::class, $operation->getCreatedAt());
        self::assertIsString($operation->getCreatedAtString());

        $operation->forgeUuid();

        self::assertIsString($operation->getUuid());

        $operation->setType($typeExpected);
        $operation->setAccount($accountExpected);
        $operation->setTransaction($transactionExpected);

        self::assertEquals($typeExpected, $operation->getType());
        self::assertEquals($accountExpected, $operation->getAccount());
        self::assertEquals($transactionExpected, $operation->getTransaction());
    }
}
