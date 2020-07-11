<?php

namespace App\DocumentModels;

use App\Concepts\MaskedDocument;

class Cpf extends MaskedDocument
{
    /**
     * @return bool
     */
    private function isFirstDigitValid(): bool
    {
        $sum = 0;
        $firstMultiplier = 10;
        for ($index = 0; $index <= 8; $index++) {
            $sum += $this->value[$index] * ($firstMultiplier - $index);
        }
        if (($sum % 11) < 2) {
            $calculatedDigit = 0;
        } else {
            $calculatedDigit = 11 - ($sum % 11);
        }
        return $calculatedDigit == $this->value[9];
    }

    /**
     * @return bool
     */
    private function isSecondDigitValid(): bool
    {
        $sum = 0;
        $firstMultiplier = 11;
        for ($index = 0; $index <= 9; $index++) {
            if (str_repeat($index, 11) == $this->value) {
                return false;
            }
            $sum += $this->value[$index] * ($firstMultiplier - $index);
        }
        if (($sum % 11) < 2) {
            $calculatedDigit = 0;
        } else {
            $calculatedDigit = 11 - ($sum % 11);
        }
        return $calculatedDigit == $this->value[10];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return strlen($this->value) == 11
            && $this->isFirstDigitValid()
            && $this->isSecondDigitValid();
    }

    /**
     * @return string|null
     */
    public function getMaskedValue(): ?string
    {
        $value = $this->getUnmaskedValue();
        if ($value) {
            $pattern = "/^(\d{3})(\d{3})(\d{3})(\d{2})$/";
            $replacement = "$1.$2.$3-$4";
            return preg_replace($pattern, $replacement, $value);
        }
        return null;
    }

    /**
     * @param string $value
     */
    protected function setValue(string $value): void
    {
        $this->value = preg_replace("/[^0-9]/", "", $value);
    }
}
