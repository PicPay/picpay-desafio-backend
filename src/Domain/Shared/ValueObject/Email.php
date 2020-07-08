<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\ValueObject\Email\InvalidValueException;

use function filter_var;

final class Email implements EmailInterface
{
    protected string $value;

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

    public static function isValid(?string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
