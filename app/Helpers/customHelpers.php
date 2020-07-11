<?php

if (!function_exists('money_to_float')) {
    /**
     * Transforms a valid money string to float
     *
     * @param string $number
     *
     * @return float
     */
    function money_to_float($number)
    {
        if (!is_null($number)) {
            // Removing non-number caracteres.
            $number = preg_replace("/[^0-9,.-]/", "", $number);

            if (substr($number, -1) == ',' || substr($number, -1) == '.') {
                $number = substr($number, 0, strlen($number) - 1);
            }
        }

        if (preg_match("/^(-)?[0-9]{1,3}(,?[0-9]{3})*(\.[0-9]{1,6})?$/", $number)) {
            return (float)str_replace(',', '.', $number);
        } elseif (preg_match("/^(-)?[0-9]{1,3}(\.?[0-9]{3})*(,[0-9]{1,6})?$/", $number)) {
            return (float)str_replace(',', '.', str_replace('.', '', $number));
        } elseif (empty($number)) {
            return (float)0;
        } elseif ($number <= 0.000001) {
            return (float)0;
        } else {
            throw new InvalidArgumentException(
                'The parameter is not a valid money string. Ex.: 100.00, 100,00, 1.000,00, 1,000.00'
            );
        }
    }
}

if (!function_exists('float_to_money')) {
    /**
     * Transforms a float to a currency formatted string
     *
     * @param float $number
     *
     * @return string
     */
    function float_to_money($number, $prefix = 'R$ ', $decimals = 2)
    {
        try {
            if (empty($number)) {
                $number = 0;
            }

            return $prefix . number_format(round($number, $decimals), $decimals, ',', '.');
        } catch (Exception $e) {
            dd($number, $prefix, $e);
        }
    }
}