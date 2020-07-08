<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Service\NotificationServiceInterface;
use Throwable;

final class TransferService implements TransferServiceInterface
{
    private AccountTransactionBalanceServiceInterface $accountTransactionBalanceServiceInterface;
    private AccountTransactionOperationServiceInterface $accountTransactionOperationService;
    private TransactionServiceInterface $transactionService;
    private TransactionValidatorServiceInterface $transactionValidatorService;
    private Transaction $transaction;
    private NotificationServiceInterface $notificationService;

    public function __construct(
        AccountTransactionBalanceServiceInterface $accountTransactionBalanceServiceInterface,
        AccountTransactionOperationServiceInterface $accountTransactionOperationService,
        TransactionServiceInterface $transactionService,
        TransactionValidatorServiceInterface $transactionValidatorService,
        NotificationServiceInterface $notificationService
    ) {
        $this->accountTransactionBalanceServiceInterface = $accountTransactionBalanceServiceInterface;
        $this->accountTransactionOperationService = $accountTransactionOperationService;
        $this->transactionService = $transactionService;
        $this->transactionValidatorService = $transactionValidatorService;
        $this->notificationService = $notificationService;
    }

    public function handleTransfer(MoneyTransfer $moneyTransfer): Transaction
    {
        $this
            ->transactionValidatorService
            ->handleValidate($moneyTransfer)
        ;

        return $this->doTransfer($moneyTransfer);
    }

    private function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    private function setTransaction(Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }

    private function doTransfer(MoneyTransfer $moneyTransfer): Transaction
    {
        try {
            $transaction = $this
                ->transactionService
                ->createTransaction($moneyTransfer)
            ;

            $this->setTransaction($transaction);

            $this
                ->accountTransactionOperationService
                ->createTransactionOperation($moneyTransfer, $this->getTransaction())
            ;
        } catch (Throwable $e) {
            throw $e;
        }

        $this->doTransferUpdateBalance($moneyTransfer);

        $this
            ->notificationService
            ->handleNotificationNewTransaction($this->getTransaction())
        ;

        return $this->getTransaction();
    }

    private function doTransferUpdateBalance(MoneyTransfer $moneyTransfer): void
    {
        try {
            $this
                ->accountTransactionBalanceServiceInterface
                ->updateBalance($moneyTransfer)
            ;
        } catch (Throwable $e) {
            $this
                ->accountTransactionBalanceServiceInterface
                ->rollbackBalance($moneyTransfer)
            ;

            $this
                ->accountTransactionOperationService
                ->createTransactionRefundOperation(
                    $moneyTransfer,
                    $this->getTransaction()
                )
            ;

            throw $e;
        }
    }
}
