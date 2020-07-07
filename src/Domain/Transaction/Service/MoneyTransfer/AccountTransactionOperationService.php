<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\RefundIn;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\RefundOut;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\TransactionIn;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\TransactionOut;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;

final class AccountTransactionOperationService implements AccountTransactionOperationServiceInterface
{
    use AccountRepositoryHelperTrait;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->setAccountRepository($accountRepository);
    }

    public function createTransactionOperation(MoneyTransfer $moneyTransfer, Transaction $transaction): void
    {
        $this
            ->getAccountRepository()
            ->createTransactionOperation(
                $transaction,
                $moneyTransfer->getPayerAccount(),
                new TransactionOut()
            )
        ;

        $this
            ->getAccountRepository()
            ->createTransactionOperation(
                $transaction,
                $moneyTransfer->getPayeeAccount(),
                new TransactionIn()
            )
        ;
    }

    public function createTransactionRefundOperation(MoneyTransfer $moneyTransfer, Transaction $transaction): void
    {
        $this
            ->getAccountRepository()
            ->createTransactionOperation(
                $transaction,
                $moneyTransfer->getPayerAccount(),
                new RefundIn()
            )
        ;

        $this
            ->getAccountRepository()
            ->createTransactionOperation(
                $transaction,
                $moneyTransfer->getPayeeAccount(),
                new RefundOut()
            )
        ;
    }
}
