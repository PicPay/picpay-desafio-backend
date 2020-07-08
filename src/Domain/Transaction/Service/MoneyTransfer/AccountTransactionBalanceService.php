<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transfer\Account\Balance\Subtract;
use App\Domain\Transaction\Entity\Transfer\Account\Balance\Sum;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;

final class AccountTransactionBalanceService implements AccountTransactionBalanceServiceInterface
{
    use AccountRepositoryHelperTrait;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->setAccountRepository($accountRepository);
    }

    public function updateBalance(MoneyTransfer $moneyTransfer): void
    {
        $this
            ->getAccountRepository()
            ->updateBalance(
                $moneyTransfer->getTransferAmount(),
                $moneyTransfer->getPayerAccount(),
                new Subtract(),
                $moneyTransfer->getPayeeAccount(),
                new Sum()
            )
        ;
    }

    public function rollbackBalance(MoneyTransfer $moneyTransfer): void
    {
        $this
            ->accountRepository
            ->rollbackBalance(
                $moneyTransfer->getPayerAccount(),
                $moneyTransfer->getPayeeAccount()
            )
        ;
    }
}
