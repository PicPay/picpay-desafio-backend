<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\DTO;

use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Infrastructure\DTO\DTOHelperTrait;
use App\Infrastructure\DTO\ItemInterface;

class TransactionDTO implements ItemInterface
{
    use DTOHelperTrait;

    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function toArray(): array
    {
        $transaction = $this->transaction;

        return [
            'uuid' => $transaction
                ->getUuid()
                ->getValue()
            ,
            'accountPayer' => $this->getAccountFragment(
                $transaction->getAccountPayer()
            ),
            'accountPayee' => $this->getAccountFragment(
                $transaction->getAccountPayee()
            ),
            'amount' => $this->getAmountFragment(
                $transaction->getAmount()
            ),
            'authentication' => $transaction->getAuthentication(),
            'createdAt' => $this->getDateTimeFragment(
                $transaction->getCreatedAt()
            ),
        ];
    }

    private function getAccountFragment(Account $account): array
    {
        return [
            'id' => $account
                ->getUuid()
                ->getValue()
            ,
            'document' => $this->getDocumentFragment(
                $account->getDocument()
            ),
        ];
    }
}
