<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\ORM\Builder;

use App\Infrastructure\ORM\Builder\TransactionBuilder;
use App\Infrastructure\ORM\Entity\Account;
use App\Infrastructure\ORM\Entity\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionBuilderTest extends TestCase
{
    public function testAttributes(): void
    {
        $transaction = (new TransactionBuilder())
            ->addAmount(1250)
            ->addAuthentication('BR8166940296824476522617194O9')
            ->addPayer(new Account())
            ->addPayee(new Account())
            ->get()
        ;

        self::assertInstanceOf(Transaction::class, $transaction);
    }
}
