<?php

declare(strict_types=1);

namespace App\Domain\Exception\ValueObject\Uuid\V4;

use InvalidArgumentException;

use function sprintf;

class InvalidValueException extends InvalidArgumentException
{
    public static function handle(string $uuidGot): self
    {
        return new self(sprintf('Invalid uuid v4 got [ %s ]', $uuidGot));
    }
}
