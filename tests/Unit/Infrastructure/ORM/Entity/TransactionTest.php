<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Entity\Account;
use App\Infrastructure\ORM\Entity\Transaction;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testAttributes(): void
    {
        $amountExpected = 1250;
        $authenticationExpected = 'BR8166940296824476522617194O9';
        $payerExpected = new Account();
        $payeeExpected = new Account();

        $transaction = new Transaction();

        self::assertNull($transaction->getCreatedAt());
        self::assertNull($transaction->getCreatedAtString());

        $transaction->forgeCreatedAt();

        self::assertInstanceOf(DateTimeInterface::class, $transaction->getCreatedAt());
        self::assertIsString($transaction->getCreatedAtString());

        $transaction->forgeUuid();

        self::assertIsString($transaction->getUuid());

        $transaction->setAmount($amountExpected);
        $transaction->setAuthentication($authenticationExpected);
        $transaction->setPayer($payerExpected);
        $transaction->setPayee($payeeExpected);

        self::assertEquals($amountExpected, $transaction->getAmount());
        self::assertEquals($authenticationExpected, $transaction->getAuthentication());
        self::assertEquals($payerExpected, $transaction->getPayer());
        self::assertEquals($payeeExpected, $transaction->getPayee());
    }
}
