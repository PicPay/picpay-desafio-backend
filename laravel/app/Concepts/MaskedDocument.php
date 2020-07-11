<?php

namespace App\Concepts;

abstract class MaskedDocument extends Document
{
    /**
     * @return string|null
     */
    public function getUnmaskedValue(): ?string
    {
        return $this->isValid() ? $this->value : null;
    }

    abstract public function getMaskedValue(): ?string;
}
