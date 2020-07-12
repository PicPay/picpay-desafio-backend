<?php

namespace App\Enums;

use App\Concepts\Enum;

/**
 * Class PersonIdentityTypeEnum
 * @package App\Enums
 *
 * @method static UserIdentityTypeEnum CPF()
 * @method static UserIdentityTypeEnum CNPJ()
 */
class UserIdentityTypeEnum extends Enum
{
    public const CPF = "cpf";
    public const CNPJ = "cnpj";

    public const LABELS = [
        self::CPF => "CPF",
        self::CNPJ => "CNPJ",
    ];
}
