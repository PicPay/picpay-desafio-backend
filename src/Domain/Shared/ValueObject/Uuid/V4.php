<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Uuid;

use App\Domain\Shared\Exception\ValueObject\Uuid\V4\InvalidValueException;

final class V4 implements UuidInterface
{
    public const VERSION = 'v4';
    public const REGEX = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

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

    public function getVersion(): string
    {
        return self::VERSION;
    }

    public static function isValid(string $uuid): bool
    {
        return filter_var($uuid, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => self::REGEX]]) !== false;
    }
}
