<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\TransactionAmountInterface;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\AbstractAccount;
use App\Domain\Transaction\Entity\Transfer\Account\Balance\OperationInterface as BalanceOperationInterface;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\OperationInterface as TypeOperationInterface;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Infrastructure\ORM\Builder\OperationBuilder;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Entity\Transaction as TransactionORM;
use App\Infrastructure\ORM\Repository\AccountRepository as AccountRepositoryORM;
use App\Infrastructure\ORM\Repository\OperationRepository as OperationRepositoryORM;
use App\Infrastructure\ORM\Repository\TransactionRepository as TransactionRepositoryORM;

class AccountRepository implements AccountRepositoryInterface
{
    private AccountRepositoryORM $accountRepositoryORM;
    private OperationRepositoryORM $operationRepositoryORM;
    private TransactionRepositoryORM $transactionRepositoryORM;

    public function __construct(
        AccountRepositoryORM $accountRepositoryORM,
        OperationRepositoryORM $operationRepositoryORM,
        TransactionRepositoryORM $transactionRepositoryORM
    ) {
        $this->accountRepositoryORM = $accountRepositoryORM;
        $this->operationRepositoryORM = $operationRepositoryORM;
        $this->transactionRepositoryORM = $transactionRepositoryORM;
    }

    public function getPayerAccount(PayerAccount $payerAccount): ?PayerAccount
    {
        $accountORM = $this
            ->accountRepositoryORM
            ->find(
                $payerAccount
                    ->getUuid()
                    ->getValue()
            )
        ;

        if (!$accountORM instanceof AccountORM) {
            return null;
        }

        $payerAccount->setDocument(
            new Document($accountORM->getDocumentNumber())
        );

        $payerAccount->setBalance(
            new Amount($accountORM->getBalance())
        );

        return $payerAccount;
    }

    public function hasPayeeAccount(PayeeAccount $payeeAccount): bool
    {
        $accountORM = $this
            ->accountRepositoryORM
            ->find(
                $payeeAccount
                    ->getUuid()
                    ->getValue()
            )
        ;

        return $accountORM instanceof AccountORM;
    }

    public function createTransactionOperation(
        Transaction $transaction,
        AbstractAccount $account,
        TypeOperationInterface $operation
    ): void {
        $accountORM = $this->getAccountORM($account);
        $transactionORM = $this->getTransactionORM($transaction);

        $operation = (new OperationBuilder())
            ->addType($operation->getType())
            ->addAccount($accountORM)
            ->addTransaction($transactionORM)
            ->get()
        ;

        $this
            ->operationRepositoryORM
            ->add($operation)
        ;
    }

    public function updateBalance(
        AbstractAccount $account,
        TransactionAmountInterface $transferAmount,
        BalanceOperationInterface $operation
    ): void {
        $accountORM = $this->getAccountORM($account);
        $newBalance = $operation->getBalance(
            $transferAmount,
            new Amount($accountORM->getBalance())
        );

        $accountORM->setBalance($newBalance->getValue());

        $this
            ->accountRepositoryORM
            ->update($accountORM)
        ;
    }

    private function getAccountORM(AbstractAccount $account): AccountORM
    {
        return $this
            ->accountRepositoryORM
            ->find(
                $account
                    ->getUuid()
                    ->getValue()
            )
        ;
    }

    private function getTransactionORM(Transaction $transaction): TransactionORM
    {
        return $this
            ->transactionRepositoryORM
            ->find(
                $transaction
                    ->getUuid()
                    ->getValue()
            )
        ;
    }
}
