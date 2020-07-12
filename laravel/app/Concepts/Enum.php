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
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();
        if (isset($constants["LABELS"])) {
            unset($constants["LABELS"]);
        }
        return $constants;
    }

    /**
     * @param $constantValue
     * @return string|null
     */
    public static function getConstantName($constantValue): ?string
    {
        $constants = static::getConstants();
        $constantName = array_search($constantValue, $constants);
        return $constantName ? $constantName : null;
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

    /**
     * @param $constantValue
     * @return bool
     */
    public static function isValid($constantValue): bool
    {
        $constants = static::getConstants();
        return in_array($constantValue, $constants);
    }
}
