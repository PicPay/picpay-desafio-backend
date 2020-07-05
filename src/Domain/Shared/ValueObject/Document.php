<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\ValueObject\Document\InvalidNumberException;

use function filter_var;
use function is_null;
use function preg_replace;
use function strlen;

class Document implements DocumentInterface
{
    public const TYPE_CPF = 'cpf';
    public const TYPE_CNPJ = 'cnpj';

    protected string $number;
    protected string $type;

    public function __construct(string $number)
    {
        $this->setNumber($number);

        if (self::isValidCpf($number)) {
            $this->setTypeCpf();

            return;
        }

        if (self::isValidCnpj($number)) {
            $this->setTypeCnpj();

            return;
        }

        throw InvalidNumberException::handle($number);
    }


    public function getNumber(): string
    {
        return $this->number;
    }

    private function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getType(): string
    {
        return $this->type;
    }

    private function setTypeCpf(): void
    {
        $this->type = self::TYPE_CPF;
    }

    private function setTypeCnpj(): void
    {
        $this->type = self::TYPE_CNPJ;
    }

    public function isTypeCpf(): bool
    {
        return self::TYPE_CPF === $this->getType();
    }

    public function isTypeCnpj(): bool
    {
        return self::TYPE_CNPJ === $this->getType();
    }

    public static function isValidCpf(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        $number = preg_replace("/[^0-9]/", "", $number);

        if (strlen($number) != 11) {
            return false;
        }

        if (filter_var($number, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/(\d)\1{10}/']]) !== false) {
            return false;
        }

        $sum = [];
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $sum[] = $number[$i] * $j;
        }

        $rest = \array_sum($sum) % 11;
        $digit1 = $rest < 2 ? 0 : 11 - $rest;

        if ($number[9] != $digit1) {
            return false;
        }

        $sum = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $sum[] = $number[$i] * $j;
        }

        $rest = \array_sum($sum) % 11;
        $digit2 = $rest < 2 ? 0 : 11 - $rest;

        return $number[10] == $digit2;
    }

    public static function isValidCnpj(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        $number = preg_replace("/[^0-9]/", "", $number);

        if (strlen($number) != 14) {
            return false;
        }

        if (filter_var($number, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/(\d)\1{13}/']]) !== false) {
            return false;
        }

        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $number[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($number[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $number[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $number[13] == ($rest < 2 ? 0 : 11 - $rest);
    }
}
