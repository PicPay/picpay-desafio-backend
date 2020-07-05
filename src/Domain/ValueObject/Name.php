<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\ValueObject\Name\InvalidValueException;

use function filter_var;

final class Name implements NameInterface
{
    public const REGEX = '/^[a-zA-Z\u00C0-\u00FF ]{2,}$/';

    private string $value;

    public function __construct(string $value)
    {
        if (!self::isValid($value)) {
            throw InvalidValueException::handle($value);
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function isValid(?string $name): bool
    {
        return filter_var($name, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => self::REGEX]]) !== false;
    }
}
