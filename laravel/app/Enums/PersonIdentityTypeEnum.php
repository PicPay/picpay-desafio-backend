<?php

namespace App\Enums;

use App\Concepts\Enum;

/**
 * Class PersonIdentityTypeEnum
 * @package App\Enums
 *
 * @method static PersonIdentityTypeEnum CPF()
 * @method static PersonIdentityTypeEnum CNPJ()
 */
class PersonIdentityTypeEnum extends Enum
{
    public const CPF = "cpf";
    public const CNPJ = "cnpj";

    public const LABELS = [
        self::CPF => "CPF",
        self::CNPJ => "CNPJ",
    ];
}
