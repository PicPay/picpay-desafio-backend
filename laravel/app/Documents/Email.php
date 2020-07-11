<?php

namespace App\Documents;

use App\Concepts\Document;

class Email extends Document
{

    public function isValid(): bool
    {
        $pattern = "/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/";
        return preg_match($pattern, $this->value);
    }

    protected function setValue(string $value): void
    {
        $this->value = trim(strtolower($value));
    }
}
