<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Entity;

use App\Domain\Shared\Helper\TimestampHelperTrait;
use App\Domain\Shared\ValueObject\Amount;
use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\Shared\ValueObject\Uuid\V4 as UuidV4;

final class Account
{
    use TimestampHelperTrait;

    private UuidV4 $uuid;
    private Name $firstName;
    private Name $lastName;
    private Document $document;
    private Email $email;
    private string $password;
    private Amount $balance;

    public function getUuid(): UuidV4
    {
        return $this->uuid;
    }

    public function setUuid(UuidV4 $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getFirstName(): Name
    {
        return $this->firstName;
    }

    public function setFirstName(Name $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): Name
    {
        return $this->lastName;
    }

    public function setLastName(Name $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
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

    public function getBalance(): Amount
    {
        return $this->balance;
    }

    public function setBalance(Amount $balance): void
    {
        $this->balance = $balance;
    }
}
