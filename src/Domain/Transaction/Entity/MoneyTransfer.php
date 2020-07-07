<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity;

use App\Domain\Shared\ValueObject\TransactionAmountInterface;

final class MoneyTransfer
{
    private AccountPayer $accountPayer;
    private AccountPayee $accountPayee;
    private TransactionAmountInterface $transferAmount;

    public function getAccountPayer(): AccountPayer
    {
        return $this->accountPayer;
    }

    public function setAccountPayer(AccountPayer $accountPayer): void
    {
        $this->accountPayer = $accountPayer;
    }

    public function getAccountPayee(): AccountPayee
    {
        return $this->accountPayee;
    }

    public function setAccountPayee(AccountPayee $accountPayee): void
    {
        $this->accountPayee = $accountPayee;
    }

    public function getTransferAmount(): TransactionAmountInterface
    {
        return $this->transferAmount;
    }

    public function setTransferAmount(TransactionAmountInterface $transferAmount): void
    {
        $this->transferAmount = $transferAmount;
    }
}
