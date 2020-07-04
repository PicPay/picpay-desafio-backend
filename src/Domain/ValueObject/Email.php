<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\ValueObject\Email\InvalidValueException;

use function filter_var;

class Email implements EmailInterface
{
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

    public static function isValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
