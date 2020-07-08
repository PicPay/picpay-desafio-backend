<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer\Account\Operation\Type;

use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\RefundOut;
use PHPUnit\Framework\TestCase;

class RefundOutTest extends TestCase
{
    public function testGetType(): void
    {
        $expectedType = 'refund_out';
        $refundOut = new RefundOut();

        self::assertEquals($expectedType, $refundOut->getType());
    }
}
