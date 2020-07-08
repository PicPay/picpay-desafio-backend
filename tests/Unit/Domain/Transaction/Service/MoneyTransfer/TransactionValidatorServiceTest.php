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
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\AccountNotFoundException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\CuteEasterEggException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\InsufficientBalanceException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\InvalidPayerAccountException;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Domain\Transaction\Service\MoneyTransfer\TransactionValidatorService;
use App\Domain\Transaction\Service\MoneyTransfer\Validator\ExternalValidatorInterface;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransactionValidatorServiceTest extends TestCase
{
    public function testAttributes(): void
    {
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $myValidator = new class implements ExternalValidatorInterface {
            public function handleValidation(MoneyTransfer $moneyTransfer): void
            {
                return;
            }
        };

        $transactionValidatorService = new TransactionValidatorService($repository);

        self::assertFalse($transactionValidatorService->hasExternalValidator($myValidator));
        self::assertTrue($transactionValidatorService->addExternalValidator($myValidator));
        self::assertFalse($transactionValidatorService->addExternalValidator($myValidator));
        self::assertTrue($transactionValidatorService->hasExternalValidator($myValidator));
    }

    public function testHandleValidate(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn($this->getPayerAccount())
        ;
        $repository
            ->shouldReceive('hasPayeeAccount')
            ->withArgs([$moneyTransfer->getPayeeAccount()])
            ->andReturn(true)
        ;

        $myValidator = new class implements ExternalValidatorInterface {
            public function handleValidation(MoneyTransfer $moneyTransfer): void
            {
                return;
            }
        };

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->addExternalValidator($myValidator);
        $transactionValidatorService->handleValidate($moneyTransfer);

        self::assertTrue(true);
    }

    public function testHandleValidateValidatePayerAccountThrowAccountNotFoundException(): void
    {
        self::expectException(AccountNotFoundException::class);

        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn(null)
        ;

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->handleValidate($moneyTransfer);
    }

    public function testHandleValidateValidatePayerAccountThrowInvalidPayerAccountException(): void
    {
        self::expectException(InvalidPayerAccountException::class);

        $payerAccount = $this->getPayerAccount();
        $payerAccount->setDocument(
            new Document('22681894000165')
        );

        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn($payerAccount)
        ;

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->handleValidate($moneyTransfer);
    }

    public function testHandleValidateValidatePayerAccountThrowInsufficientBalanceException(): void
    {
        self::expectException(InsufficientBalanceException::class);

        $payerAccount = $this->getPayerAccount();
        $payerAccount->setBalance(
            new BalanceAmount(1000)
        );

        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn($payerAccount)
        ;

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->handleValidate($moneyTransfer);
    }

    public function testHandleValidateValidatePayeeAccountThrowAccountNotFoundException(): void
    {
        $this->expectException(AccountNotFoundException::class);

        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn($this->getPayerAccount())
        ;
        $repository
            ->shouldReceive('hasPayeeAccount')
            ->withArgs([$moneyTransfer->getPayeeAccount()])
            ->andReturn(false)
        ;

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->handleValidate($moneyTransfer);
    }

    public function testHandleValidateValidateSameAccountThrowCuteEasterEggException(): void
    {
        self::expectException(CuteEasterEggException::class);

        $moneyTransfer = $this->getMoneyTransfer();
        $moneyTransfer->getPayeeAccount()->setUuid(
            $moneyTransfer->getPayerAccount()->getUuid()
        );

        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn($this->getPayerAccount())
        ;
        $repository
            ->shouldReceive('hasPayeeAccount')
            ->withArgs([$moneyTransfer->getPayeeAccount()])
            ->andReturn(true)
        ;

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->handleValidate($moneyTransfer);
    }

    public function testHandleValidateHandleExternalValidationsThrowException(): void
    {
        self::expectException(Exception::class);

        $moneyTransfer = $this->getMoneyTransfer();
        $repository = Mockery::mock(AccountRepositoryInterface::class);
        $repository
            ->shouldReceive('getPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()])
            ->andReturn($this->getPayerAccount())
        ;
        $repository
            ->shouldReceive('hasPayeeAccount')
            ->withArgs([$moneyTransfer->getPayeeAccount()])
            ->andReturn(true)
        ;

        $myValidator = new class implements ExternalValidatorInterface {
            public function handleValidation(MoneyTransfer $moneyTransfer): void
            {
                throw new Exception('other');
            }
        };

        $transactionValidatorService = new TransactionValidatorService($repository);
        $transactionValidatorService->addExternalValidator($myValidator);
        $transactionValidatorService->handleValidate($moneyTransfer);
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
        $payerAccount->setUuid(new UuidV4('19045898-2706-4fec-9227-a70d19f79a6b'));
        $payerAccount->setDocument(new Document('57588899034'));
        $payerAccount->setBalance(new BalanceAmount(2250));

        return $payerAccount;
    }

    private function getPayeeAccount(): PayeeAccount
    {
        $payeeAccount = new PayeeAccount();
        $payeeAccount->setUuid(new UuidV4('fa24ccc6-26eb-48c1-8ceb-b9356dfca98e'));

        return $payeeAccount;
    }
}
