<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Service\MoneyTransfer\ListService;

class ListCommand
{
    private ListService $listService;

    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
    }

    public function execute(): TransactionCollection
    {
        return $this
            ->listService
            ->handleList()
        ;
    }
}
