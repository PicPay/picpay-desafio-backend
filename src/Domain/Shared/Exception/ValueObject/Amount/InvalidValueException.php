<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exception\ValueObject\Amount;

use InvalidArgumentException;

use function sprintf;

class InvalidValueException extends InvalidArgumentException
{
    public static function handleLessThanMinimum(int $valueGot, int $valueExpected): self
    {
        return new self(
            sprintf(
                'Invalid value, got [ %d ] less than minimum expected [ %d ]',
                $valueGot,
                $valueExpected
            )
        );
    }
}
