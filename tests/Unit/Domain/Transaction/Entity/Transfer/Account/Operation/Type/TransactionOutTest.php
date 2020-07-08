<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer\Account\Operation\Type;

use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\TransactionOut;
use PHPUnit\Framework\TestCase;

class TransactionOutTest extends TestCase
{
    public function testGetType(): void
    {
        $expectedType = 'transaction_out';
        $transactionOut = new TransactionOut();

        self::assertEquals($expectedType, $transactionOut->getType());
    }
}
