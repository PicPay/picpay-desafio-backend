<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Uuid;

interface UuidInterface
{
    public function getValue(): string;

    public function getVersion(): string;

    public static function isValid(string $uuid): bool;
}
