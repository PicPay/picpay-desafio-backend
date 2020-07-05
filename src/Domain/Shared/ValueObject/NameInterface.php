<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

interface NameInterface
{
    public function getValue(): string;

    public static function isValid(string $name): bool;
}
