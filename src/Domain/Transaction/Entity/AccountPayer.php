<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity;

use App\Domain\Shared\ValueObject\AmountInterface;
use App\Domain\Shared\ValueObject\DocumentInterface;

final class AccountPayer extends AbstractAccount
{
    private DocumentInterface $document;
    private AmountInterface $balance;

    public function getDocument(): DocumentInterface
    {
        return $this->document;
    }

    public function setDocument(DocumentInterface $document): void
    {
        $this->document = $document;
    }

    public function getBalance(): AmountInterface
    {
        return $this->balance;
    }

    public function setBalance(AmountInterface $balance): void
    {
        $this->balance = $balance;
    }

    public function isCommercialEstablishment(): bool
    {
        return $this
            ->document
            ->isTypeCnpj()
        ;
    }
}
