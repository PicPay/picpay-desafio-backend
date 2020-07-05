<?php

declare(strict_types=1);

namespace App\Domain\Exception\ValueObject\Document;

use InvalidArgumentException;

use function sprintf;

class InvalidNumberException extends InvalidArgumentException
{
    public static function handle(string $numberGot): self
    {
        return new self(sprintf('Invalid number got [ %s ]', $numberGot));
    }
}
