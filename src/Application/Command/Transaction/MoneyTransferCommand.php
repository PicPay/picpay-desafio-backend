<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction;

use App\Application\Factory\Transaction\MoneyTransferFactory;
use App\Domain\Transaction\Service\MoneyTransferService;

class MoneyTransferCommand
{
    private MoneyTransferService $moneyTransferService;

    public function __construct(MoneyTransferService $moneyTransferService)
    {
        $this->moneyTransferService = $moneyTransferService;
    }

    public function execute(array $data)
    {
        $moneyTransfer = MoneyTransferFactory::createFromRequest($data);

        return $this
            ->moneyTransferService
            ->handleTransfer($moneyTransfer)
        ;
    }
}
