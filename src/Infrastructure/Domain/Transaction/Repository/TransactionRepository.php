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
use App\Infrastructure\ORM\Repository\AccountRepository as AccountRepositoryORM;
use App\Infrastructure\ORM\Repository\TransactionRepository as TransactionRepositoryORM;

class TransactionRepository implements TransactionRepositoryInterface
{
    private AccountRepositoryORM $accountRepositoryORM;
    private TransactionRepositoryORM $transactionRepositoryORM;

    public function __construct(
        AccountRepositoryORM $accountRepositoryORM,
        TransactionRepositoryORM $transactionRepositoryORM
    ) {
        $this->accountRepositoryORM = $accountRepositoryORM;
        $this->transactionRepositoryORM = $transactionRepositoryORM;
    }

    public function list(): TransactionCollection
    {
        $transactionsORM = $this
            ->transactionRepositoryORM
            ->findBy([], ['createdAt' => 'desc'])
        ;

        return TransactionCollectionFactory::createFromORM($transactionsORM);
    }

    public function create(MoneyTransfer $moneyTransfer): Transaction
    {
        $payerAccountORM = $this->getAccount($moneyTransfer->getPayerAccount());
        $payeeAccountORM = $this->getAccount($moneyTransfer->getPayeeAccount());

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

    private function getAccount(AbstractAccount $account): AccountORM
    {
        return $this
            ->accountRepositoryORM
            ->find(
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
