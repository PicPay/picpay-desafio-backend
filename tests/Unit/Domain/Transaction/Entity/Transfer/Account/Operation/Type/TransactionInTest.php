<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer\Account\Operation\Type;

use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\TransactionIn;
use PHPUnit\Framework\TestCase;

class TransactionInTest extends TestCase
{
    public function testGetType(): void
    {
        $expectedType = 'transaction_in';
        $transactionIn = new TransactionIn();

        self::assertEquals($expectedType, $transactionIn->getType());
    }
}
