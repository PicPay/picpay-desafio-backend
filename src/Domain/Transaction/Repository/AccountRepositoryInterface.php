<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Repository;

use App\Domain\Shared\ValueObject\TransactionAmountInterface;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\AbstractAccount;
use App\Domain\Transaction\Entity\Transfer\Account\Balance\OperationInterface as BalanceOperationInterface;
use App\Domain\Transaction\Entity\Transfer\Operation\Type\OperationInterface as TypeOperationInterface;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;

interface AccountRepositoryInterface
{
    public function getPayerAccount(PayerAccount $payerAccount): ?PayerAccount;

    public function hasPayeeAccount(PayeeAccount $payeeAccount): bool;

    public function createTransactionOperation(
        Transaction $transaction,
        AbstractAccount $account,
        TypeOperationInterface $operation
    ): void;

    public function updateBalance(
        TransactionAmountInterface $transferAmount,
        AbstractAccount $payerAccount,
        BalanceOperationInterface $payerBalanceOperation,
        AbstractAccount $payeeAccount,
        BalanceOperationInterface $payeeBalanceOperation
    ): void;

    public function rollbackBalance(
        AbstractAccount $payerAccount,
        AbstractAccount $payeeAccount
    ): void;
}
