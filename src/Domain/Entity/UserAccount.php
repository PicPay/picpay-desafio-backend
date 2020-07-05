<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Amount;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid\V4 as UuidV4;
use DateTime;
use DateTimeInterface;

class UserAccount
{
    private UuidV4 $id;
    private Name $firstName;
    private Name $lastName;
    private Document $document;
    private Email $email;
    private string $password;
    private Amount $balance;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function setId(UuidV4 $id): void
    {
        $this->id = $id;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setCreatedAtNow(): void
    {
        $this->setCreatedAt(new DateTime('now'));
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setUpdatedAtNow(): void
    {
        $this->setUpdatedAt(new DateTime('now'));
    }
}
