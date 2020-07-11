<?php

namespace App\Enums;

use App\Concepts\Enum;

/**
 * Class PersonStatusEnum
 * @package App\Enums
 *
 * @method static PersonStatusEnum BANNED()
 * @method static PersonStatusEnum ACTIVE()
 */
class PersonStatusEnum extends Enum
{
    public const BANNED = "banned";
    public const ACTIVE = "active";

    public const LABELS = [
        self::BANNED => "banido",
        self::ACTIVE => "ativo",
    ];
}
