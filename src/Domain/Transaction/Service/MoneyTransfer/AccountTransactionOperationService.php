<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\TransactionIn;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\TransactionOut;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;

final class AccountTransactionOperationService
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function createTransactionOperation(MoneyTransfer $moneyTransfer, Transaction $transaction): void
    {
        $this
            ->accountRepository
            ->createTransactionOperation(
                $transaction,
                $moneyTransfer->getPayerAccount(),
                new TransactionOut()
            )
        ;

        $this
            ->accountRepository
            ->createTransactionOperation(
                $transaction,
                $moneyTransfer->getPayeeAccount(),
                new TransactionIn()
            )
        ;
    }
}
