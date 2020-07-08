<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Domain\Transaction\Repository;

use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Infrastructure\Domain\Transaction\Cache\TransactionCacheInterface;
use App\Infrastructure\Domain\Transaction\Repository\AccountRepository;
use App\Infrastructure\ORM\Entity\Account as AccountORM;
use App\Infrastructure\ORM\Repository\AccountRepositoryInterface as AccountRepositoryORMInterface;
use App\Infrastructure\ORM\Repository\OperationRepositoryInterface as OperationRepositoryORMInterface;
use App\Infrastructure\ORM\Repository\TransactionRepositoryInterface as TransactionRepositoryORMInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class AccountRepositoryTest extends TestCase
{
    public function testGetPayerAccount(): void
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setUuid(
            new UuidV4('7103e331-9d57-4c2d-9604-393172375a16')
        );

        $accountORM = $this->getAccountORM();

        $accountRepositoryORM = Mockery::mock(AccountRepositoryORMInterface::class);
        $accountRepositoryORM
            ->shouldReceive('get')
            ->withArgs([$payerAccount->getUuid()->getValue()])
            ->andReturn($accountORM)
        ;

        $operationRepositoryORM = Mockery::mock(OperationRepositoryORMInterface::class);
        $transactionRepositoryORM = Mockery::mock(TransactionRepositoryORMInterface::class);
        $transactionCache = Mockery::mock(TransactionCacheInterface::class);

        $accountRepository = new AccountRepository(
            $accountRepositoryORM,
            $operationRepositoryORM,
            $transactionRepositoryORM,
            $transactionCache
        );

        $payerAccountGot = $accountRepository->getPayerAccount($payerAccount);

        self::assertEquals(
            $accountORM->getDocumentNumber(),
            $payerAccountGot->getDocument()->getNumber()
        );
        self::assertEquals(
            $accountORM->getBalance(),
            $payerAccountGot->getBalance()->getValue()
        );
    }

    public function testGetPayerAccountNull(): void
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setUuid(
            new UuidV4('7103e331-9d57-4c2d-9604-393172375a16')
        );

        $accountRepositoryORM = Mockery::mock(AccountRepositoryORMInterface::class);
        $accountRepositoryORM
            ->shouldReceive('get')
            ->withArgs([$payerAccount->getUuid()->getValue()])
            ->andReturn(null)
        ;

        $operationRepositoryORM = Mockery::mock(OperationRepositoryORMInterface::class);
        $transactionRepositoryORM = Mockery::mock(TransactionRepositoryORMInterface::class);
        $transactionCache = Mockery::mock(TransactionCacheInterface::class);

        $accountRepository = new AccountRepository(
            $accountRepositoryORM,
            $operationRepositoryORM,
            $transactionRepositoryORM,
            $transactionCache
        );

        $payerAccountGot = $accountRepository->getPayerAccount($payerAccount);
        self::assertNull($payerAccountGot);
    }

    public function testHasPayeeAccount(): void
    {
        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid(
            new UuidV4('7103e331-9d57-4c2d-9604-393172375a16')
        );

        $accountRepositoryORM = Mockery::mock(AccountRepositoryORMInterface::class);
        $accountRepositoryORM
            ->shouldReceive('get')
            ->withArgs([$payeeAccount->getUuid()->getValue()])
            ->andReturn($this->getAccountORM())
        ;

        $operationRepositoryORM = Mockery::mock(OperationRepositoryORMInterface::class);
        $transactionRepositoryORM = Mockery::mock(TransactionRepositoryORMInterface::class);
        $transactionCache = Mockery::mock(TransactionCacheInterface::class);

        $accountRepository = new AccountRepository(
            $accountRepositoryORM,
            $operationRepositoryORM,
            $transactionRepositoryORM,
            $transactionCache
        );

        self::assertTrue($accountRepository->hasPayeeAccount($payeeAccount));
    }

    public function testHasNotPayeeAccount(): void
    {
        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid(
            new UuidV4('7103e331-9d57-4c2d-9604-393172375a16')
        );

        $accountRepositoryORM = Mockery::mock(AccountRepositoryORMInterface::class);
        $accountRepositoryORM
            ->shouldReceive('get')
            ->withArgs([$payeeAccount->getUuid()->getValue()])
            ->andReturn(null)
        ;

        $operationRepositoryORM = Mockery::mock(OperationRepositoryORMInterface::class);
        $transactionRepositoryORM = Mockery::mock(TransactionRepositoryORMInterface::class);
        $transactionCache = Mockery::mock(TransactionCacheInterface::class);

        $accountRepository = new AccountRepository(
            $accountRepositoryORM,
            $operationRepositoryORM,
            $transactionRepositoryORM,
            $transactionCache
        );

        self::assertFalse($accountRepository->hasPayeeAccount($payeeAccount));
    }

    private function getAccountORM(): AccountORM
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
