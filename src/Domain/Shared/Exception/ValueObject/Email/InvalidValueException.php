<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exception\ValueObject\Email;

use InvalidArgumentException;

use function sprintf;

class InvalidValueException extends InvalidArgumentException
{
    public static function handle(string $emailGot): self
    {
        return new self(sprintf('Invalid e-mail got [ %s ]', $emailGot));
    }
}
