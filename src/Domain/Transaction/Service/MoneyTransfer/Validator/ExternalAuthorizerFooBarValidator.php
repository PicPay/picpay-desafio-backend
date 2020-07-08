<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Service\MoneyTransfer\Validator;

use App\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient\ApiClientInterface;
use App\Domain\Transaction\Entity\Transfer\MoneyTransfer;
use App\Domain\Transaction\Exception\Service\MoneyTransfer\Validator\ExternalValidatorValidationException;
use function sprintf;

class ExternalAuthorizerFooBarValidator implements ExternalValidatorInterface
{
    private ApiClientInterface $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function handleValidation(MoneyTransfer $moneyTransfer): void
    {
        $response = $this
            ->apiClient
            ->isValidPayerAccount(
                $moneyTransfer
                    ->getPayerAccount()
                    ->getDocument()
            )
        ;

        if (!$response) {
            throw ExternalValidatorValidationException::handle(
                $this->getExceptionMessage($moneyTransfer)
            );
        }
    }

    private function getExceptionMessage(MoneyTransfer $moneyTransfer): string
    {
        return sprintf(
            'Vendor FooBar refused payer document [ %s ]',
            $moneyTransfer
                ->getPayerAccount()
                ->getDocument()
                ->getNumber()
        );
    }
}
