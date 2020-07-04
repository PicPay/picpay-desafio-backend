<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Document;

use App\Domain\Exception\ValueObject\Document\Cnpj\InvalidNumberException;

use function filter_var;
use function preg_replace;
use function strlen;

class Cnpj extends AbstractDocument
{
    public const TYPE = 'cpf';

    public function __construct(string $number)
    {
        if (!self::isValidNumber($number)) {
            throw InvalidNumberException::handle($number);
        }

        $this->number = $number;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function isTypeCpf(): bool
    {
        return false;
    }

    public function isTypeCnpj(): bool
    {
        return true;
    }

    public static function isValidNumber(string $number): bool
    {
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
