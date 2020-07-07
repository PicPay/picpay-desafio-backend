<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\DTO;

use App\Domain\Shared\ValueObject\TransactionAmountInterface;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Infrastructure\DTO\ItemInterface;
use DateTimeInterface;

use function is_null;

class TransactionDTO implements ItemInterface
{
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
            'document' => [
                'number' => $account
                    ->getDocument()
                    ->getNumber()
                ,
                'type' => $account
                    ->getDocument()
                    ->getType()
                ,
            ],
        ];
    }

    private function getAmountFragment(TransactionAmountInterface $transactionAmount): array
    {
        return [
            'integer' => $transactionAmount->getValue(),
            'decimal' => $transactionAmount->getValueDecimal(),
        ];
    }

    private function getDateTimeFragment(?DateTimeInterface $dateTime): ?string
    {
        if (is_null($dateTime)) {
            return null;
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
