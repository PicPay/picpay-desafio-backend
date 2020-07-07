<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transfer;

use App\Domain\Shared\ValueObject\AmountInterface;
use App\Domain\Shared\ValueObject\Document;

final class PayerAccount extends AbstractAccount
{
    private Document $document;
    private AmountInterface $balance;

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
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
}
