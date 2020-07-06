<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Entity;

use App\Domain\Shared\Helper\TimestampHelperTrait;
use App\Domain\Shared\ValueObject\AmountInterface;
use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\Shared\ValueObject\Uuid\UuidInterface as UuidV4Interface;

final class TransactionOperation
{
    use TimestampHelperTrait;

    private UuidV4Interface $uuid;
    private string $type;
    private string $authentication;
    private AmountInterface $amount;
    private DocumentInterface $payerDocument;
    private DocumentInterface $payeeDocument;

    public function getUuid(): UuidV4Interface
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4Interface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getAuthentication(): string
    {
        return $this->authentication;
    }

    public function setAuthentication(string $authentication): void
    {
        $this->authentication = $authentication;
    }

    public function getAmount(): AmountInterface
    {
        return $this->amount;
    }

    public function setAmount(AmountInterface $amount): void
    {
        $this->amount = $amount;
    }

    public function getPayerDocument(): DocumentInterface
    {
        return $this->payerDocument;
    }

    public function setPayerDocument(DocumentInterface $payerDocument): void
    {
        $this->payerDocument = $payerDocument;
    }

    public function getPayeeDocument(): DocumentInterface
    {
        return $this->payeeDocument;
    }

    public function setPayeeDocument(DocumentInterface $payeeDocument): void
    {
        $this->payeeDocument = $payeeDocument;
    }
}
