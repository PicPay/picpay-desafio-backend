<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Transaction\Service\MoneyTransfer\Validator;

use App\Domain\Shared\ValueObject\Amount\BalanceAmount;
use App\Domain\Shared\ValueObject\Amount\TransactionAmount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;
use App\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient\ApiClientInterface;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Entity\Transfer\PayeeAccount;
use App\Domain\Transaction\Entity\Transfer\PayerAccount;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\Validator\ExternalValidatorValidationException;
use App\Domain\Transaction\Service\MoneyTransfer\Validator\ExternalAuthorizerFooBarValidator;
use Mockery;
use PHPUnit\Framework\TestCase;

class ExternalAuthorizerFooBarValidatorTest extends TestCase
{
    public function testHandleValidation(): void
    {
        $moneyTransfer = $this->getMoneyTransfer();
        $apiClient = Mockery::mock(ApiClientInterface::class);
        $apiClient
            ->shouldReceive('isValidPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()->getDocument()])
            ->andReturn(true)
        ;

        $externalAuthorizerFooBarValidator = new ExternalAuthorizerFooBarValidator($apiClient);
        $externalAuthorizerFooBarValidator->handleValidation($moneyTransfer);

        self::assertTrue(true);
    }

    public function testHandleValidationThrowExternalValidatorValidationException(): void
    {
        self::expectException(ExternalValidatorValidationException::class);

        $moneyTransfer = $this->getMoneyTransfer();
        $apiClient = Mockery::mock(ApiClientInterface::class);
        $apiClient
            ->shouldReceive('isValidPayerAccount')
            ->withArgs([$moneyTransfer->getPayerAccount()->getDocument()])
            ->andReturn(false)
        ;

        $externalAuthorizerFooBarValidator = new ExternalAuthorizerFooBarValidator($apiClient);
        $externalAuthorizerFooBarValidator->handleValidation($moneyTransfer);
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
