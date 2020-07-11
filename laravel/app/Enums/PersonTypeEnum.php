<?php

namespace App\Enums;

use App\Concepts\Enum;

/**
 * Class PersonTypeEnum
 * @package App\Enums
 *
 * @method static PersonTypeEnum USER()
 * @method static PersonTypeEnum SHOPKEEPER()
 */
class PersonTypeEnum extends Enum
{
    public const USER = "user";
    public const SHOPKEEPER = "shopkeeper";

    public const LABELS = [
        self::USER => "usuário",
        self::SHOPKEEPER => "lojista",
    ];
}
