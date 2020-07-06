<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\DTO;

use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\UserAccount\Entity\TransactionOperation;
use App\Infrastructure\DTO\ItemInterface;

class TransactionOperationDTO implements ItemInterface
{
    use DTOHelperTrait;

    private TransactionOperation $transactionOperation;

    public function __construct(TransactionOperation $transactionOperation)
    {
        $this->transactionOperation = $transactionOperation;
    }

    public function toArray(): array
    {
        $transactionOperation = $this->transactionOperation;

        return [
            'uuid' => $transactionOperation
                ->getUuid()
                ->getValue()
            ,
            'type' => $transactionOperation->getType(),
            'authentication' => $transactionOperation->getAuthentication(),
            'amount' => $this->getAmountFragment(
                $transactionOperation->getAmount()
            ),
            'payer' => $this->getDocumentFragment(
                $transactionOperation->getPayerDocument()
            ),
            'payee' => $this->getDocumentFragment(
                $transactionOperation->getPayeeDocument()
            ),
        ];
    }

    private function getDocumentFragment(DocumentInterface $document): array
    {
        return [
            'number' => $document->getNumber(),
            'type' => $document->getType(),
        ];
    }
}
