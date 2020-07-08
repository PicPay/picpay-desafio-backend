<?php

declare(strict_types=1);

namespace App\Domain\UserAccount\Exception\Service\GetService;

use RuntimeException;

use function sprintf;

class AccountNotFoundException extends RuntimeException
{
    public static function handle(string $accountUuid): self
    {
        return new self(sprintf('Account with uuid [ %s ] not found', $accountUuid));
    }
}
