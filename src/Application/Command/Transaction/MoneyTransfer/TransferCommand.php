<?php

declare(strict_types=1);

namespace App\Application\Command\Transaction\MoneyTransfer;

use App\Application\Command\AbstractCommand;
use App\Application\Factory\Transaction\Transfer\MoneyTransferFactory;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Service\MoneyTransfer\TransferServiceInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class TransferCommand extends AbstractCommand
{
    private TransferServiceInterface $transferService;

    public function __construct(TransferServiceInterface $transferService, LoggerInterface $logger)
    {
        parent::__construct($logger);
        $this->transferService = $transferService;
    }

    public function execute(array $data): Transaction
    {
        try {
            $moneyTransfer = MoneyTransferFactory::createFromRequest($data);

            return $this
                ->transferService
                ->handleTransfer($moneyTransfer)
            ;
        } catch (Throwable $e) {
            $this->logException($e);
            throw $e;
        }
    }
}
