<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Helper\IdentifierTrait;
use RedRat\Entity\DateTimeCreatedTrait;

class Operation
{
    use IdentifierTrait;
    use DateTimeCreatedTrait;

    private string $type;
    private Account $account;
    private Transaction $transaction;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }
}
