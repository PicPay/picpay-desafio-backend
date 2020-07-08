<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Entity;

use App\Domain\Shared\Helper\TimestampHelperTrait;
use App\Domain\Shared\ValueObject\Amount\BalanceAmountInterface;
use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\Shared\ValueObject\EmailInterface;
use App\Domain\Shared\ValueObject\NameInterface;
use App\Domain\Shared\ValueObject\Uuid\UuidInterface as UuidV4Interface;

final class Account
{
    use TimestampHelperTrait;

    private UuidV4Interface $uuid;
    private NameInterface $firstName;
    private NameInterface $lastName;
    private DocumentInterface $document;
    private EmailInterface $email;
    private string $password;
    private BalanceAmountInterface $balance;

    public function getUuid(): UuidV4Interface
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4Interface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getFirstName(): NameInterface
    {
        return $this->firstName;
    }

    public function setFirstName(NameInterface $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): NameInterface
    {
        return $this->lastName;
    }

    public function setLastName(NameInterface $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDocument(): DocumentInterface
    {
        return $this->document;
    }

    public function setDocument(DocumentInterface $document): void
    {
        $this->document = $document;
    }

    public function getEmail(): EmailInterface
    {
        return $this->email;
    }

    public function setEmail(EmailInterface $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getBalance(): BalanceAmountInterface
    {
        return $this->balance;
    }

    public function setBalance(BalanceAmountInterface $balance): void
    {
        $this->balance = $balance;
    }
}
