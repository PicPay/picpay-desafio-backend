<?php

declare(strict_types=1);

namespace App\Domain\Exception\Service\UserAccount\CreateService;

use App\Domain\ValueObject\Document;
use RuntimeException;
use function sprintf;

class UserAccountFoundException extends RuntimeException
{
    public static function handle(Document $document): self
    {
        return new self(
            sprintf(
                'User account with document [ %s : %s ] can not be created, already exists',
                $document->getType(),
                $document->getNumber()
            )
        );
    }
}
