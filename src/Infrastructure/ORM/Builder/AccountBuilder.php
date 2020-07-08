<?php

declare(strict_types=1);

namespace App\Infrastructure\ORM\Builder;

use App\Domain\Shared\ValueObject\Amount\BalanceAmountInterface;
use App\Domain\Shared\ValueObject\DocumentInterface;
use App\Domain\Shared\ValueObject\EmailInterface;
use App\Domain\Shared\ValueObject\NameInterface;
use App\Infrastructure\ORM\Entity\Account;

class AccountBuilder
{
    private Account $account;

    public function __construct()
    {
        $this->account = new Account();
    }

    public function addFirstName(NameInterface $firstName): self
    {
        $this
            ->account
            ->setFirstName($firstName->getValue())
        ;

        return $this;
    }

    public function addLastName(NameInterface $lastName): self
    {
        $this
            ->account
            ->setLastName($lastName->getValue())
        ;

        return $this;
    }

    public function addDocument(DocumentInterface $document): self
    {
        $this
            ->account
            ->setDocumentNumber($document->getNumber())
        ;

        $this
            ->account
            ->setDocumentType($document->getType())
        ;

        return $this;
    }

    public function addEmail(EmailInterface $email): self
    {
        $this
            ->account
            ->setEmail($email->getValue())
        ;

        return $this;
    }

    public function addPassword(string $password): self
    {
        $this
            ->account
            ->setPassword($password)
        ;

        return $this;
    }

    public function addBalance(BalanceAmountInterface $amount): self
    {
        $this
            ->account
            ->setBalance($amount->getValue())
        ;

        return $this;
    }

    public function get(): Account
    {
        return $this->account;
    }
}
