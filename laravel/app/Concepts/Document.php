<?php

namespace App\Concepts;

abstract class Document
{
    /** @var string $value */
    protected $value;

    /**
     * Document constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    abstract public function isValid(): bool;

    /**
     * @param string $value
     */
    abstract protected function setValue(string $value): void;
}
