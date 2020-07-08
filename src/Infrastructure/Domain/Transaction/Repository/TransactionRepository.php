<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Domain\Transaction\Entity\Transfer\AbstractAccount;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Infrastructure\Domain\Transaction\Factory\Transaction\TransactionCollectionFactory;
use App\Infrastructure\Domain\Transaction\Factory\Transaction\TransactionFactory;
use App\Infrastructure\ORM\Builder\TransactionBuilder;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Repository\AccountRepositoryInterface as AccountRepositoryORMInterface;
use App\Infrastructure\ORM\Repository\TransactionRepositoryInterface as TransactionRepositoryORMInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    private AccountRepositoryORMInterface $accountRepositoryORM;
    private TransactionRepositoryORMInterface $transactionRepositoryORM;

    public function __construct(
        AccountRepositoryORMInterface $accountRepositoryORM,
        TransactionRepositoryORMInterface $transactionRepositoryORM
    ) {
        $this->accountRepositoryORM = $accountRepositoryORM;
        $this->transactionRepositoryORM = $transactionRepositoryORM;
    }

    public function list(): TransactionCollection
    {
        $transactionsORM = $this
            ->transactionRepositoryORM
            ->getList()
        ;

        return TransactionCollectionFactory::createFromORM($transactionsORM);
    }

    public function create(MoneyTransfer $moneyTransfer): Transaction
    {
        $payerAccountORM = $this->getAccountORM($moneyTransfer->getPayerAccount());
        $payeeAccountORM = $this->getAccountORM($moneyTransfer->getPayeeAccount());

        $transactionORM = (new TransactionBuilder())
            ->addAmount(
                $moneyTransfer
                    ->getTransferAmount()
                    ->getValue()
            )
            ->addAuthentication(
                $this->getRandomAuthentication()
            )
            ->addPayer($payerAccountORM)
            ->addPayee($payeeAccountORM)
            ->get()
        ;

        $transactionORM = $this
            ->transactionRepositoryORM
            ->add($transactionORM)
        ;

        return TransactionFactory::createFromORM($transactionORM);
    }

    private function getAccountORM(AbstractAccount $account): AccountORM
    {
        return $this
            ->accountRepositoryORM
            ->get(
                $account
                    ->getUuid()
                    ->getValue()
            )
        ;
    }

    private function getRandomAuthentication(): string
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(
            new \Faker\Provider\Payment($faker)
        );

        return $faker->iban('br');
    }
}
