<?php

namespace App\Traits\Mutators;

trait UserMutator {

    /**
     * Exibe o Preço com o valor formatado.
     *
     * @param  string  $value
     * @return string
     */
    public function getBalanceAttribute($value)
    {
        return 'R$ '.number_format($value, 2, ',', '.');
    }
}