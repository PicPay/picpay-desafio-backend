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
use App\Domain\Transaction\Service\MoneyTransfer\AccountTransactionBalanceServiceInterface;
use App\Domain\Transaction\Service\MoneyTransfer\AccountTransactionOperationServiceInterface;
use App\Domain\Transaction\Service\MoneyTransfer\TransactionServiceInterface;
use App\Domain\Transaction\Service\MoneyTransfer\TransactionValidatorServiceInterface;
use App\Domain\Transaction\Service\MoneyTransfer\TransferService;
use DateTime;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class TransferServiceTest extends TestCase
{
    public function testHandleTransfer(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $transactionExpected = $this->getTransaction();

        $accountTransactionBalanceService = Mockery::mock(AccountTransactionBalanceServiceInterface::class);
        $accountTransactionBalanceService
            ->shouldReceive('updateBalance')
            ->withArgs([$moneyTransfer])
            ->andReturn(null)
        ;

        $accountTransactionOperationService = Mockery::mock(AccountTransactionOperationServiceInterface::class);
        $accountTransactionOperationService
            ->shouldReceive('createTransactionOperation')
            ->withArgs([$moneyTransfer, $transactionExpected])
            ->andReturn(null)
        ;

        $transactionService = Mockery::mock(TransactionServiceInterface::class);
        $transactionService
            ->shouldReceive('createTransaction')
            ->withArgs([$moneyTransfer])
            ->andReturn($transactionExpected)
        ;

        $transactionValidatorService = Mockery::mock(TransactionValidatorServiceInterface::class);
        $transactionValidatorService
            ->shouldReceive('handleValidate')
            ->withArgs([$moneyTransfer])
            ->andReturn(null)
        ;

        $transferService = new TransferService(
            $accountTransactionBalanceService,
            $accountTransactionOperationService,
            $transactionService,
            $transactionValidatorService
        );

        $transactionGot = $transferService->handleTransfer($moneyTransfer);

        self::assertEquals($transactionExpected, $transactionGot);
    }

    public function testHandleTransferDoTransferThrowException(): void
    {
        self::expectException(Throwable::class);

        $moneyTransfer = $this->getMoneyTransfer();

        $accountTransactionBalanceService = Mockery::mock(AccountTransactionBalanceServiceInterface::class);
        $accountTransactionOperationService = Mockery::mock(AccountTransactionOperationServiceInterface::class);

        $transactionService = Mockery::mock(TransactionServiceInterface::class);
        $transactionService
            ->shouldReceive('createTransaction')
            ->withArgs([$moneyTransfer])
            ->andThrow(Exception::class)
        ;

        $transactionValidatorService = Mockery::mock(TransactionValidatorServiceInterface::class);
        $transactionValidatorService
            ->shouldReceive('handleValidate')
            ->withArgs([$moneyTransfer])
            ->andReturn(null)
        ;

        $transferService = new TransferService(
            $accountTransactionBalanceService,
            $accountTransactionOperationService,
            $transactionService,
            $transactionValidatorService
        );

        $transferService->handleTransfer($moneyTransfer);
    }

    public function testHandleTransferDoTransferUpdateBalanceThrowException(): void
    {
        self::expectException(Throwable::class);

        $moneyTransfer = $this->getMoneyTransfer();
        $transaction = $this->getTransaction();

        $accountTransactionBalanceService = Mockery::mock(AccountTransactionBalanceServiceInterface::class);
        $accountTransactionBalanceService
            ->shouldReceive('updateBalance')
            ->withArgs([$moneyTransfer])
            ->andThrow(Exception::class)
        ;
        $accountTransactionBalanceService
            ->shouldReceive('rollbackBalance')
            ->withArgs([$moneyTransfer])
            ->andReturn(null)
        ;

        $accountTransactionOperationService = Mockery::mock(AccountTransactionOperationServiceInterface::class);
        $accountTransactionOperationService
            ->shouldReceive('createTransactionOperation')
            ->withArgs([$moneyTransfer, $transaction])
            ->andReturn(null)
        ;
        $accountTransactionOperationService
            ->shouldReceive('createTransactionRefundOperation')
            ->withArgs([$moneyTransfer, $transaction])
            ->andReturn(null)
        ;

        $transactionService = Mockery::mock(TransactionServiceInterface::class);
        $transactionService
            ->shouldReceive('createTransaction')
            ->withArgs([$moneyTransfer])
            ->andReturn($transaction)
        ;

        $transactionValidatorService = Mockery::mock(TransactionValidatorServiceInterface::class);
        $transactionValidatorService
            ->shouldReceive('handleValidate')
            ->withArgs([$moneyTransfer])
            ->andReturn(null)
        ;

        $transferService = new TransferService(
            $accountTransactionBalanceService,
            $accountTransactionOperationService,
            $transactionService,
            $transactionValidatorService
        );

        $transferService->handleTransfer($moneyTransfer);
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
