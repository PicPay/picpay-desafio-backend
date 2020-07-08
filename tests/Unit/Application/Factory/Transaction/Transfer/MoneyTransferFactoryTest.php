<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Factory\Transaction\Transfer;

use App\Application\Factory\Transaction\Transfer\MoneyTransferFactory;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use PHPUnit\Framework\TestCase;

class MoneyTransferFactoryTest extends TestCase
{
    public function testCreateFromRequest(): void
    {
        $requestData = [
            'payerUuid' => '89b4e999-ebda-45f8-91e6-3500b7993772',
            'payeeUuid' => 'a01e3d27-0279-4968-9a84-641c82522ac6',
            'amount' => 1250,
        ];
        $moneyTransfer = MoneyTransferFactory::createFromRequest($requestData);

        self::assertInstanceOf(MoneyTransfer::class, $moneyTransfer);
    }
}
