<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

interface DocumentInterface
{
    public function getNumber(): string;

    public function getType(): string;

    public function isTypeCpf(): bool;

    public function isTypeCnpj(): bool;

    public static function isValidCpf(?string $number): bool;

    public static function isValidCnpj(?string $number): bool;
}
