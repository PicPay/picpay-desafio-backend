<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer;

use App\Domain\Transaction\Entity\Transaction\Transaction;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransferService\AccountNotFoundException;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\TransferService\InsufficientBalanceException;
use App\Domain\Transaction\Repository\AccountRepositoryInterface;
use App\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Domain\Transaction\Service\MoneyTransfer\Validator\ExternalValidatorInterface;

use function in_array;
use function is_null;

final class TransferService extends AbstractService
{
    private AccountRepositoryInterface $accountRepository;
    /** @var ExternalValidatorInterface[]  */
    private array $externalValidators;

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        parent::__construct($transactionRepository);
        $this->accountRepository = $accountRepository;
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

    public function handleTransfer(MoneyTransfer $moneyTransfer): Transaction
    {
        $this->handleValidations($moneyTransfer);
        $this->doTransfer($moneyTransfer);

        dd($moneyTransfer);
    }

    private function doTransfer(MoneyTransfer $moneyTransfer): Transaction
    {
        $transaction = $this
            ->getTransactionRepository()
            ->create($moneyTransfer)
        ;

        dd($transaction);
    }

    private function handleValidations(MoneyTransfer $moneyTransfer): void
    {
        $this->validatePayerAccount($moneyTransfer);
        $this->validatePayeeAccount($moneyTransfer);
        $this->handleExternalValidations($moneyTransfer);
    }

    private function handleExternalValidations(MoneyTransfer $moneyTransfer): void
    {
        foreach ($this->externalValidators as $externalValidator) {
            $externalValidator->handleValidation($moneyTransfer);
        }
    }

    private function validatePayerAccount(MoneyTransfer $moneyTransfer): void
    {
        $payerAccount = $this
            ->accountRepository
            ->getPayerAccount($moneyTransfer->getPayerAccount())
        ;

        if (is_null($payerAccount)) {
            throw AccountNotFoundException::handle('payer', $moneyTransfer->getPayerAccount());
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
            ->accountRepository
            ->hasPayeeAccount($moneyTransfer->getPayeeAccount())
        ) {
            throw AccountNotFoundException::handle('payee', $moneyTransfer->getPayeeAccount());
        }
    }
}
