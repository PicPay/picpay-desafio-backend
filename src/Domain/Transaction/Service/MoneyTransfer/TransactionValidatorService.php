<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\AccountNotFoundException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\CuteEasterEggException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\InsufficientBalanceException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransactionValidatorService\InvalidPayerAccountException;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Domain\Transaction\Service\MoneyTransfer\Validator\ExternalValidatorInterface;

use function in_array;
use function is_null;

final class TransactionValidatorService implements TransactionValidatorServiceInterface
{
    use AccountRepositoryHelperTrait;

    /** @var ExternalValidatorInterface[]  */
    private array $externalValidators;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->setAccountRepository($accountRepository);
        $this->externalValidators = [];
    }

    public function addExternalValidator(ExternalValidatorInterface $externalValidator): bool
    {
        if ($this->hasExternalValidator($externalValidator)) {
            return false;
        }

        $this->externalValidators[] = $externalValidator;
        return true;
    }

    public function hasExternalValidator(ExternalValidatorInterface $externalValidator): bool
    {
        return in_array($externalValidator, $this->externalValidators);
    }

    public function handleValidate(MoneyTransfer $moneyTransfer): void
    {
        $this->validatePayerAccount($moneyTransfer);
        $this->validatePayeeAccount($moneyTransfer);
        $this->validateSameAccount($moneyTransfer);
        $this->handleExternalValidations($moneyTransfer);
    }

    private function validatePayerAccount(MoneyTransfer $moneyTransfer): void
    {
        $payerAccount = $this
            ->getAccountRepository()
            ->getPayerAccount($moneyTransfer->getPayerAccount())
        ;

        if (is_null($payerAccount)) {
            throw AccountNotFoundException::handle('payer', $moneyTransfer->getPayerAccount());
        }

        if ($payerAccount->isCommercialEstablishment()) {
            throw InvalidPayerAccountException::handleNew($payerAccount);
        }

        $moneyTransferAmount = $moneyTransfer->getTransferAmount();
        $payerAccountBalance = $payerAccount->getBalance();

        if ($moneyTransferAmount->getValue() > $payerAccountBalance->getValue()) {
            throw InsufficientBalanceException::handle($payerAccountBalance, $moneyTransferAmount);
        }
    }

    private function validatePayeeAccount(MoneyTransfer $moneyTransfer): void
    {
        if (!$this
            ->getAccountRepository()
            ->hasPayeeAccount($moneyTransfer->getPayeeAccount())
        ) {
            throw AccountNotFoundException::handle('payee', $moneyTransfer->getPayeeAccount());
        }
    }

    private function validateSameAccount(MoneyTransfer $moneyTransfer): void
    {
        $payerAccountUuid = $moneyTransfer->getPayerAccount()->getUuid();
        $payeeAccountUuid = $moneyTransfer->getPayeeAccount()->getUuid();

        if ($payerAccountUuid->getValue() === $payeeAccountUuid->getValue()) {
            throw CuteEasterEggException::handle();
        }
    }

    private function handleExternalValidations(MoneyTransfer $moneyTransfer): void
    {
        foreach ($this->externalValidators as $externalValidator) {
            $externalValidator->handleValidation($moneyTransfer);
        }
    }
}
