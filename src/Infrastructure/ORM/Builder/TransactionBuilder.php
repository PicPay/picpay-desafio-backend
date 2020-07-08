<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Builder;

use App\Infrastructure\ORM\Entity\Account;
use App\Infrastructure\ORM\Entity\Transaction;

class TransactionBuilder
{
    private Transaction $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function addAmount(int $amount): self
    {
        $this
            ->transaction
            ->setAmount($amount)
        ;

        return $this;
    }

    public function addAuthentication(string $authentication): self
    {
        $this
            ->transaction
            ->setAuthentication($authentication)
        ;

        return $this;
    }

    public function addPayer(Account $payer): self
    {
        $this
            ->transaction
            ->setPayer($payer)
        ;

        return $this;
    }

    public function addPayee(Account $payee): self
    {
        $this
            ->transaction
            ->setPayee($payee)
        ;

        return $this;
    }

    public function get(): Transaction
    {
        return $this->transaction;
    }
}
