<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction\MoneyTransfer;

use App\Application\Command\AbstractCommand;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Service\MoneyTransfer\ListServiceInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ListCommand extends AbstractCommand
{
    private ListServiceInterface $listService;

    public function __construct(ListServiceInterface $listService, LoggerInterface $logger)
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
