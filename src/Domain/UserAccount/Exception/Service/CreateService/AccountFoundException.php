<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Exception\Service\CreateService;

use App\Domain\Shared\ValueObject\DocumentInterface;
use RuntimeException;

use function sprintf;

class AccountFoundException extends RuntimeException
{
    public static function handle(DocumentInterface $document): self
    {
        return new self(
            sprintf(
                'Account with document [ %s:%s ] can not be created, already exists',
                $document->getType(),
                $document->getNumber()
            )
        );
    }
}
