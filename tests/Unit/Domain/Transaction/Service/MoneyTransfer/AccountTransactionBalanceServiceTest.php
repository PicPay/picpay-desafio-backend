<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Domain\Transaction\Service\MoneyTransfer\AccountTransactionBalanceService;
use Mockery;
use PHPUnit\Framework\TestCase;

class AccountTransactionBalanceServiceTest extends TestCase
{
    public function testUpdateBalance(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('updateBalance')
            ->andReturn(null)
        ;

        $accountTransactionBalanceService = new AccountTransactionBalanceService($repository);
        $accountTransactionBalanceService->updateBalance($moneyTransfer);

        self::assertTrue(true);
    }

    public function testRollbackBalancee(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('rollbackBalance')
            ->andReturn(null)
        ;

        $accountTransactionBalanceService = new AccountTransactionBalanceService($repository);
        $accountTransactionBalanceService->rollbackBalance($moneyTransfer);

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
}
