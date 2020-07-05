<?php

declare(strict_types=1);

namespace App\Application\Factory\UserAccount;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\UserAccount\Entity\Account;

class CreateFactory
{
    public static function createFromRequest(array $requestData): Account
    {
        $account = new Account();
        $account->setFirstName(
            new Name($requestData['firstName'])
        );
        $account->setLastName(
            new Name($requestData['lastName'])
        );
        $account->setDocument(
            new Document($requestData['document'])
        );
        $account->setEmail(
            new Email($requestData['email'])
        );
        $account->setPassword($requestData['password']);

        return $account;
    }
}
