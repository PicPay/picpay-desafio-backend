<?php

declare(strict_types=1);

namespace App\Application\Command\UserAccount;

use App\Application\Command\AbstractCommand;
use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Domain\UserAccount\Service\TransactionOperationListServiceInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class TransactionOperationListCommand extends AbstractCommand
{
    private TransactionOperationListServiceInterface $transactionOperationListService;

    public function __construct(
        TransactionOperationListServiceInterface $transactionOperationListService,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
        $this->transactionOperationListService = $transactionOperationListService;
    }

    public function execute(string $accountUuid): TransactionOperationCollection
    {
        try {
            return $this
                ->transactionOperationListService
                ->handleList($accountUuid)
            ;
        } catch (Throwable $e) {
            $this->logException($e);
            throw $e;
        }
    }
}
