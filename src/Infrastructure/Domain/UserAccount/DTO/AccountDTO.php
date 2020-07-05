<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\DTO;

use App\Domain\UserAccount\Entity\Account;
use App\Infrastructure\DTO\ItemInterface;
use DateTimeInterface;

use function is_null;

class AccountDTO implements ItemInterface
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this
                ->account
                ->getUuid()
                ->getValue()
            ,
            'firstName' => $this
                ->account
                ->getFirstName()
                ->getValue()
            ,
            'lastName' => $this
                ->account
                ->getLastName()
                ->getValue()
            ,
            'document' => [
                'number' => $this
                    ->account
                    ->getDocument()
                    ->getNumber()
                ,
                'type' => $this
                    ->account
                    ->getDocument()
                    ->getType()
                ,
            ],
            'email' => $this
                ->account
                ->getEmail()
                ->getValue()
            ,
            'password' => 'boooo, this is secret data',
            'balance' => $this
                ->account
                ->getBalance()
                ->getValue()
            ,
            'createdAt' => $this->getDateTimeFragment(
                $this
                    ->account
                    ->getCreatedAt()
            ),
            'updatedAt' => $this->getDateTimeFragment(
                $this
                    ->account
                    ->getUpdatedAt()
            ),
        ];
    }

    private function getDateTimeFragment(?DateTimeInterface $dateTime): ?string
    {
        if (is_null($dateTime)) {
            return null;
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
