<?php

declare(strict_types=1);

namespace App\Domain\Exception\ValueObject\Name;

use InvalidArgumentException;

use function sprintf;

class InvalidValueException extends InvalidArgumentException
{
    public static function handle(string $nameGot): self
    {
        return new self(sprintf('Invalid name got [ %s ]', $nameGot));
    }
}
