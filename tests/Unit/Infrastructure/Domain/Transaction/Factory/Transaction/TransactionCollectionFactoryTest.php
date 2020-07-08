<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Domain\Transaction\Factory\Transaction;

use App\Domain\Transaction\Entity\Transaction\TransactionCollection;
use App\Infrastructure\Domain\Transaction\Factory\Transaction\TransactionCollectionFactory;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Entity\Transaction as TransactionORM;
use PHPUnit\Framework\TestCase;

class TransactionCollectionFactoryTest extends TestCase
{
    public function testCreateFromORM(): void
    {
        $transactionCollection = TransactionCollectionFactory::createFromORM([
            $this->getTransaction(),
        ]);

        self::assertInstanceOf(TransactionCollection::class, $transactionCollection);
    }

    private function getTransaction(): TransactionORM
    {
        $transaction = new TransactionORM();

        $transaction->forgeUuid();
        $transaction->forgeCreatedAt();
        $transaction->setAmount(1250);
        $transaction->setAuthentication('BR8166940296824476522617194O9');
        $transaction->setPayer($this->getAccount());
        $transaction->setPayee($this->getAccount());

        return $transaction;
    }

    private function getAccount(): AccountORM
    {
        $account = new AccountORM();

        $account->forgeUuid();
        $account->forgeCreatedAt();
        $account->setFirstName('John');
        $account->setLastName('Doe');
        $account->setDocumentNumber('00412651068');
        $account->setDocumentType('cpf');
        $account->setEmail('john@doe.com');
        $account->setPassword('123456');
        $account->setBalance(1250);

        return $account;
    }
}
