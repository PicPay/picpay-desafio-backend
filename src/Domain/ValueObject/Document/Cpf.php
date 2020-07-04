<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Document;

use App\Domain\Exception\ValueObject\Document\Cpf\InvalidNumberException;

use function array_sum;
use function filter_var;
use function preg_replace;
use function strlen;

class Cpf extends AbstractDocument
{
    public function __construct(string $number)
    {
        if (!self::isValidNumber($number)) {
            throw InvalidNumberException::handle($number);
        }

        $this->number = $number;
    }

    public static function isValidNumber(string $number): bool
    {
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

        $rest = array_sum($sum) % 11;
        $digit1 = $rest < 2 ? 0 : 11 - $rest;

        if ($number[9] != $digit1) {
            return false;
        }

        $sum = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $sum[] = $number[$i] * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit2 = $rest < 2 ? 0 : 11 - $rest;

        return $number[10] == $digit2;
    }
}
