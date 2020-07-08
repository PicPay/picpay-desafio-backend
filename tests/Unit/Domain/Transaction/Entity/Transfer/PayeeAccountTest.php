<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use PHPUnit\Framework\TestCase;

class PayeeAccountTest extends TestCase
{
    public function testAttributes(): void
    {
        $uuidExpected = new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e');

        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid($uuidExpected);

        self::assertEquals($uuidExpected, $payeeAccount->getUuid());
    }
}
