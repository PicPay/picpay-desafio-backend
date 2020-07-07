<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;

final class TransferService extends AbstractService
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        parent::__construct($transactionRepository);
        $this->accountRepository = $accountRepository;
    }

    public function handleTransfer(MoneyTransfer $moneyTransfer): Transaction
    {
        dd($moneyTransfer);
    }
}
