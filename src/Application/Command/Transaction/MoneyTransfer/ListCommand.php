<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction\MoneyTransfer;

use App\Application\Command\AbstractCommand;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Service\MoneyTransfer\ListService;
use Psr\Log\LoggerInterface;
use Throwable;

class ListCommand extends AbstractCommand
{
    private ListService $listService;

    public function __construct(ListService $listService, LoggerInterface $logger)
    {
        parent::__construct($logger);
        $this->listService = $listService;
    }

    public function execute(): TransactionCollection
    {
        try {
            return $this
                ->listService
                ->handleList()
            ;
        } catch (Throwable $e) {
            $this->logException($e);
            throw $e;
        }
    }
}
