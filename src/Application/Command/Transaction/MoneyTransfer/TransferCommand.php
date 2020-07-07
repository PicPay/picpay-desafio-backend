<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction\MoneyTransfer;

use App\Application\Factory\Transaction\Transfer\MoneyTransferFactory;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Service\MoneyTransfer\TransferService;

class TransferCommand
{
    private TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function execute(array $data): Transaction
    {
        $moneyTransfer = MoneyTransferFactory::createFromRequest($data);

        return $this
            ->transferService
            ->handleTransfer($moneyTransfer)
        ;
    }
}
