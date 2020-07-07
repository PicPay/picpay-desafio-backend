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

    private function doTransfer(MoneyTransfer $moneyTransfer): Transaction
    {
        $transaction = $this->doTransferCreateTransaction($moneyTransfer);
        $this->doTransferCreateTransactionOperation($moneyTransfer, $transaction);
        $this->doTransferUpdateBalance($moneyTransfer);

        return $transaction;
    }

    private function doTransferCreateTransaction(MoneyTransfer $moneyTransfer): Transaction
    {
        return $this
            ->transactionService
            ->createTransaction($moneyTransfer)
        ;
    }

    private function doTransferCreateTransactionOperation(MoneyTransfer $moneyTransfer, Transaction $transaction): void
    {
        $this
            ->accountTransactionOperationService
            ->createTransactionOperation($moneyTransfer, $transaction)
        ;
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
        }
    }
}
