<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\Amount\TransactionAmountInterface;

final class MoneyTransfer
{
    private PayerAccount $PayerAccount;
    private PayeeAccount $PayeeAccount;
    private TransactionAmountInterface $transferAmount;

    public function getPayerAccount(): PayerAccount
    {
        return $this->PayerAccount;
    }

    public function setPayerAccount(PayerAccount $PayerAccount): void
    {
        $this->PayerAccount = $PayerAccount;
    }

    public function getPayeeAccount(): PayeeAccount
    {
        return $this->PayeeAccount;
    }

    public function setPayeeAccount(PayeeAccount $PayeeAccount): void
    {
        $this->PayeeAccount = $PayeeAccount;
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
