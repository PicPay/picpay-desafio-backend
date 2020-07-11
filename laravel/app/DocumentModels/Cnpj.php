<?php

namespace App\DocumentModels;

use App\Concepts\MaskedDocument;

class Cnpj extends MaskedDocument
{
    /**
     * @return bool
     */
    private function isFirstDigitValid(): bool
    {
        $sum = 0;
        for ($index = 0; $index < 4; $index++) {
            $sum += (5 - $index) * ($this->value[$index] + $this->value[8 + $index]) + ((9 - $index) * $this->value[4 + $index]);
        }
        $calculatedDigit = 11 - ($sum % 11);
        if ($calculatedDigit >= 10) {
            $calculatedDigit = 0;
        }
        return $calculatedDigit == $this->value[12];
    }

    /**
     * @return bool
     */
    private function isSecondDigitValid(): bool
    {
        $sum = 0;
        for ($index = 0; $index < 4; $index++) {
            $sum += (6 - $index) * ($this->value[$index] + $this->value[8 + $index]);
        }
        $sum += 2 * ($this->value[4] + $this->value[12]);
        for ($index = 5; $index < 8; $index++) {
            $sum += (14 - $index) * $this->value[$index];
        }
        $calculatedDigit = 11 - ($sum % 11);
        if ($calculatedDigit >= 10) {
            $calculatedDigit = 0;
        }
        return $calculatedDigit == $this->value[13];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return strlen($this->value) == 14
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
            $pattern = "/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/";
            $replacement = "$1.$2.$3/$4-$5";
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
