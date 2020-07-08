<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Entity\Transaction;

use App\Domain\Shared\ValueObject\Amount\TransactionAmountInterface;
use App\Domain\Shared\ValueObject\Uuid\UuidInterface as UuidV4Interface;
use DateTimeInterface;

class Transaction
{
    private UuidV4Interface $uuid;
    private Account $accountPayer;
    private Account $accountPayee;
    private TransactionAmountInterface $amount;
    private string $authentication;
    private DateTimeInterface $createdAt;

    public function getUuid(): UuidV4Interface
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4Interface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getAccountPayer(): Account
    {
        return $this->accountPayer;
    }

    public function setAccountPayer(Account $accountPayer): void
    {
        $this->accountPayer = $accountPayer;
    }

    public function getAccountPayee(): Account
    {
        return $this->accountPayee;
    }

    public function setAccountPayee(Account $accountPayee): void
    {
        $this->accountPayee = $accountPayee;
    }

    public function getAmount(): TransactionAmountInterface
    {
        return $this->amount;
    }

    public function setAmount(TransactionAmountInterface $amount): void
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
