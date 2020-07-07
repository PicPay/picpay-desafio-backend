<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use Throwable;

use function in_array;
use function is_null;

final class TransferService
{
    private AccountTransactionBalanceServiceInterface $accountTransactionBalanceServiceInterface;
    private AccountTransactionOperationServiceInterface $accountTransactionOperationService;
    private TransactionServiceInterface $transactionService;
    private TransactionValidatorServiceInterface $transactionValidatorService;
    private Transaction $transaction;

    public function __construct(
        AccountTransactionBalanceServiceInterface $accountTransactionBalanceServiceInterface,
        AccountTransactionOperationServiceInterface $accountTransactionOperationService,
        TransactionServiceInterface $transactionService,
        TransactionValidatorServiceInterface $transactionValidatorService
    ) {
        $this->accountTransactionBalanceServiceInterface = $accountTransactionBalanceServiceInterface;
        $this->accountTransactionOperationService = $accountTransactionOperationService;
        $this->transactionService = $transactionService;
        $this->transactionValidatorService = $transactionValidatorService;
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
