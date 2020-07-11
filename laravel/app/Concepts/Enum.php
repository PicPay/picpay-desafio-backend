<?php

namespace App\Concepts;

use App\Exceptions\InvalidEnumException;
use ReflectionClass;

abstract class Enum
{
    private $value;

    /**
     * Enum constructor.
     * @param $constantName
     * @throws InvalidEnumException
     */
    public function __construct($constantName)
    {
        $constants = static::getConstants();
        if (!isset($constants[$constantName])) {
            throw new InvalidEnumException();
        }
        $this->value = $constants[$constantName];
    }

    /**
     * @return array
     */
    private static function getConstants(): array
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getConstants();
    }

    /**
     * @param $name
     * @param $arguments
     * @return static
     * @throws InvalidEnumException
     */
    public static function __callStatic($name, $arguments): self
    {
        return new static($name);
    }

    public static function isValid($constantValue): bool
    {
        $constants = static::getConstants();
        return in_array($constantValue, $constants);
    }
}
