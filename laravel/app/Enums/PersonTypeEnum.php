<?php

namespace App\Enums;

/**
 * Class PersonTypeEnum
 * @package App\Enums
 *
 * @method static PersonTypeEnum USER()
 * @method static PersonTypeEnum SHOPKEEPER()
 */
class PersonTypeEnum
{
    public const USER = "user";
    public const SHOPKEEPER = "shopkeeper";

    public const LABELS = [
        self::USER => "usuário",
        self::SHOPKEEPER => "lojista",
    ];
}
