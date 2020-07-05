<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Entity;

use App\Infrastructure\ORM\Helper\IdentifierTrait;
use RedRat\Entity\DateTimeCreatedTrait;
use RedRat\Entity\DateTimeUpdatedTrait;

class Account
{
    use IdentifierTrait;
    use DateTimeCreatedTrait;
    use DateTimeUpdatedTrait;

    private string $firstName;
    private string $lastName;
    private string $documentNumber;
    private string $documentType;
    private string $email;
    private string $password;
    private int $balance;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    public function setDocumentNumber(string $documentNumber): void
    {
        $this->documentNumber = $documentNumber;
    }

    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    public function setDocumentType(string $documentType): void
    {
        $this->documentType = $documentType;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
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

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}
