<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer\Account\Operation\Type;

use App\Domain\Transaction\Entity\Transfer\Account\Operation\Type\RefundIn;
use PHPUnit\Framework\TestCase;

class RefundInTest extends TestCase
{
    public function testGetType(): void
    {
        $expectedType = 'refund_in';
        $refundIn = new RefundIn();

        self::assertEquals($expectedType, $refundIn->getType());
    }
}
