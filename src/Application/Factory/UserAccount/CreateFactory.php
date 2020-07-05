<?php

declare(strict_types=1);

namespace App\Application\Factory\UserAccount;

use App\Domain\Entity\UserAccount;
use App\Domain\ValueObject\Document;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;

class CreateFactory
{
    public static function createFromRequest(array $requestData): UserAccount
    {
        $userAccount = new UserAccount();
        $userAccount->setFirstName(
            new Name($requestData['firstName'])
        );
        $userAccount->setLastName(
            new Name($requestData['lastName'])
        );
        $userAccount->setDocument(
            new Document($requestData['document'])
        );
        $userAccount->setEmail(
            new Email($requestData['email'])
        );
        $userAccount->setPassword($requestData['password']);

        return $userAccount;
    }
}
