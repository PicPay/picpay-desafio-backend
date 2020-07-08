<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\Amount\BalanceAmountInterface;
use App\Domain\Shared\ValueObject\Document;

final class PayerAccount extends AbstractAccount
{
    private Document $document;
    private BalanceAmountInterface $balance;

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }

    public function getBalance(): BalanceAmountInterface
    {
        return $this->balance;
    }

    public function setBalance(BalanceAmountInterface $balance): void
    {
        $this->balance = $balance;
    }

    public function isCommercialEstablishment(): bool
    {
        return $this
            ->getDocument()
            ->isTypeCnpj()
        ;
    }
}
