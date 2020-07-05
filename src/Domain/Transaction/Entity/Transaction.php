<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity;

use App\Domain\Shared\ValueObject\Amount;

final class Transaction
{
    private AccountPayer $accountPayer;
    private AccountPayee $accountPayee;
    private Amount $transferAmount;

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

    public function getTransferAmount(): Amount
    {
        return $this->transferAmount;
    }

    public function setTransferAmount(Amount $transferAmount): void
    {
        $this->transferAmount = $transferAmount;
    }
}
