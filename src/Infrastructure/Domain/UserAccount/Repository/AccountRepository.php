<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\Repository;

use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\UserAccount\Entity\Account;
use App\Domain\UserAccount\Entity\AccountCollection;
use App\Domain\UserAccount\Entity\TransactionOperationCollection;
use App\Domain\UserAccount\Repository\AccountRepositoryInterface;
use App\Infrastructure\Domain\UserAccount\Factory\AccountCollectionFactory;
use App\Infrastructure\Domain\UserAccount\Factory\AccountFactory;
use App\Infrastructure\Domain\UserAccount\Factory\TransactionOperationCollectionFactory;
use App\Infrastructure\ORM\Builder\AccountBuilder;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Repository\AccountRepository as AccountRepositoryORM;
use App\Infrastructure\ORM\Repository\OperationRepository as OperationRepositoryORM;

class AccountRepository implements AccountRepositoryInterface
{
    private AccountRepositoryORM $accountRepositoryORM;
    private OperationRepositoryORM $operationRepositoryORM;

    public function __construct(
        AccountRepositoryORM $accountRepositoryORM,
        OperationRepositoryORM $operationRepositoryORM
    ) {
        $this->accountRepositoryORM = $accountRepositoryORM;
        $this->operationRepositoryORM = $operationRepositoryORM;
    }

    public function hasByDocument(DocumentInterface $document): bool
    {
        $accountORMFound = $this
            ->accountRepositoryORM
            ->findOneBy(['documentNumber' => $document->getNumber()])
        ;

        return $accountORMFound instanceof AccountORM;
    }

    public function get(string $accountUuid): ?Account
    {
        $accountORM = $this
            ->accountRepositoryORM
            ->find($accountUuid)
        ;

        if (!$accountORM instanceof AccountORM) {
            return null;
        }

        return AccountFactory::createFromORM($accountORM);
    }

    public function create(Account $account): Account
    {
        $accountORM = (new AccountBuilder())
            ->addFirstName($account->getFirstName())
            ->addLastName($account->getLastName())
            ->addDocument($account->getDocument())
            ->addEmail($account->getEmail())
            ->addPassword($account->getPassword())
            ->addBalance($account->getBalance())
            ->get()
        ;

        $accountORM = $this
            ->accountRepositoryORM
            ->add($accountORM)
        ;

        $account->setUuid(
            new UuidV4($accountORM->getUuid())
        );

        $account->setCreatedAt($accountORM->getCreatedAt());

        return $account;
    }

    public function list(): AccountCollection
    {
        $accountsORM = $this
            ->accountRepositoryORM
            ->findAll()
        ;

        return AccountCollectionFactory::createFromORM($accountsORM);
    }

    public function listTransactionOperations(Account $account): TransactionOperationCollection
    {
        $data = $this
            ->operationRepositoryORM
            ->getOperationsByAccount(
                $account
                    ->getUuid()
                    ->getValue()
            )
        ;

        return TransactionOperationCollectionFactory::createFromORM($data);
    }
}
