<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Factory\Transaction;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\TransactionAmount;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Entity\Transaction as TransactionORM;

class TransactionFactory
{
    public static function createFromORM(TransactionORM $transactionORM): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUuid(
            new UuidV4($transactionORM->getUuid())
        );
        $transaction->setAccountPayer(
            self::createAccountFromORM($transactionORM->getPayer())
        );
        $transaction->setAccountPayee(
            self::createAccountFromORM($transactionORM->getPayee())
        );
        $transaction->setAmount(
            new TransactionAmount($transactionORM->getAmount())
        );
        $transaction->setAuthentication($transactionORM->getAuthentication());
        $transaction->setCreatedAt($transactionORM->getCreatedAt());

        return $transaction;
    }

    private static function createAccountFromORM(AccountORM $accountORM): Account
    {
        $account = new Account();
        $account->setUuid(
            new UuidV4($accountORM->getUuid())
        );
        $account->setDocument(
            new Document($accountORM->getDocumentNumber())
        );

        return $account;
    }
}
