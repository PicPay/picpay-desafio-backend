<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transaction\Account;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Domain\Transaction\Service\MoneyTransfer\AccountTransactionOperationService;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AccountTransactionOperationServiceTest extends TestCase
{
    public function testCreateTransactionOperation(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $transaction = $this->getTransaction();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('createTransactionOperation')
            ->andReturn(null)
        ;
        $repository
            ->shouldReceive('createTransactionOperation')
            ->andReturn(null)
        ;

        $accountTransactionOperationService = new AccountTransactionOperationService($repository);
        $accountTransactionOperationService->createTransactionOperation($moneyTransfer, $transaction);

        self::assertTrue(true);
    }

    public function testCreateTransactionRefundOperation(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $transaction = $this->getTransaction();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('createTransactionOperation')
            ->andReturn(null)
        ;
        $repository
            ->shouldReceive('createTransactionOperation')
            ->andReturn(null)
        ;

        $accountTransactionOperationService = new AccountTransactionOperationService($repository);
        $accountTransactionOperationService->createTransactionRefundOperation($moneyTransfer, $transaction);

        self::assertTrue(true);
    }

    private function getMoneyTransfer(): MoneyTransfer
    {
        $moneyTransfer = new MoneyTransfer();
        $moneyTransfer->setPayerAccount($this->getPayerAccount());
        $moneyTransfer->setPayeeAccount($this->getPayeeAccount());
        $moneyTransfer->setTransferAmount(new TransactionAmount(1250));

        return $moneyTransfer;
    }

    private function getPayerAccount(): PayerAccount
    {
        $payerAccount = new PayerAccount();
        $payerAccount->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));
        $payerAccount->setDocument(new Document('57588899034'));
        $payerAccount->setBalance(new BalanceAmount(1250));

        return $payerAccount;
    }

    private function getPayeeAccount(): PayeeAccount
    {
        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));

        return $payeeAccount;
    }

    private function getTransaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));
        $transaction->setAccountPayer($this->getTransactionAccount());
        $transaction->setAccountPayee($this->getTransactionAccount());
        $transaction->setAmount(new TransactionAmount(1250));
        $transaction->setAuthentication('BR8166940296824476522617194O9');
        $transaction->setCreatedAt(new DateTime('2020-07-07 19:00:00'));

        return $transaction;
    }

    private function getTransactionAccount(): Account
    {
        $account = new Account();
        $account->setUuid(
            new UuidV4(
                Uuid
                    ::uuid4()
                    ->toString()
            )
        );
        $account->setDocument(new Document('57588899034'));

        return $account;
    }
}
