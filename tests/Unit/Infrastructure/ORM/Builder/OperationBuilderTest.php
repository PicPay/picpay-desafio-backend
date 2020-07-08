<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\ORM\Builder;

use App\Infrastructure\ORM\Builder\OperationBuilder;
use App\Infrastructure\ORM\Entity\Account;
use App\Infrastructure\ORM\Entity\Operation;
use App\Infrastructure\ORM\Entity\Transaction;
use PHPUnit\Framework\TestCase;

class OperationBuilderTest extends TestCase
{
    public function testAttributes(): void
    {
        $operation = (new OperationBuilder())
            ->addType('transaction_in')
            ->addAccount(new Account())
            ->addTransaction(new Transaction())
            ->get()
        ;

        self::assertInstanceOf(Operation::class, $operation);
    }
}
