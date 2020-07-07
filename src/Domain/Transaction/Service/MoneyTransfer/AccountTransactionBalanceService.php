<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transfer\Account\Balance\Subtract;
use App\Domain\Transaction\Entity\Transfer\Account\Balance\Sum;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;

class AccountTransactionBalanceService
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function updateBalance(MoneyTransfer $moneyTransfer): void
    {
        $this
            ->accountRepository
            ->updateBalance(
                $moneyTransfer->getPayerAccount(),
                $moneyTransfer->getTransferAmount(),
                new Subtract()
            )
        ;

        $this
            ->accountRepository
            ->updateBalance(
                $moneyTransfer->getPayeeAccount(),
                $moneyTransfer->getTransferAmount(),
                new Sum()
            )
        ;
    }
}
