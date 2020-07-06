<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Helper\IdentifierTrait;
use RedRat\Entity\DateTimeCreatedTrait;

class Transaction
{
    use IdentifierTrait;
    use DateTimeCreatedTrait;

    private int $amount;
    private string $authentication;
    private Account $payer;
    private Account $payee;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getAuthentication(): string
    {
        return $this->authentication;
    }

    public function setAuthentication(string $authentication): void
    {
        $this->authentication = $authentication;
    }

    public function getPayer(): Account
    {
        return $this->payer;
    }

    public function setPayer(Account $payer): void
    {
        $this->payer = $payer;
    }

    public function getPayee(): Account
    {
        return $this->payee;
    }

    public function setPayee(Account $payee): void
    {
        $this->payee = $payee;
    }
}
