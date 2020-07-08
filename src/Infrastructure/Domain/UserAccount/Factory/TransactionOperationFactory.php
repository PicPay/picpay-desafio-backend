<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\Factory;

use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\TransactionOperation;
use App\Infrastructure\ORM\Entity\Operation as OperationORM;

class TransactionOperationFactory
{
    public static function createFromORM(OperationORM $operationORM): TransactionOperation
    {
        $transactionORM = $operationORM->getTransaction();
        $payerAccount = $transactionORM->getPayer();
        $payeeAccount = $transactionORM->getPayee();

        $transactionOperation = new TransactionOperation();
        $transactionOperation->setUuid(
            new UuidV4($operationORM->getUuid())
        );
        $transactionOperation->setType(
            $operationORM->getType()
        );
        $transactionOperation->setAuthentication(
            $transactionORM->getAuthentication()
        );
        $transactionOperation->setAmount(
            new TransactionAmount($transactionORM->getAmount())
        );
        $transactionOperation->setPayerDocument(
            new Document($payerAccount->getDocumentNumber())
        );
        $transactionOperation->setPayeeDocument(
            new Document($payeeAccount->getDocumentNumber())
        );
        $transactionOperation->setCreatedAt($transactionORM->getCreatedAt());

        return $transactionOperation;
    }


}
