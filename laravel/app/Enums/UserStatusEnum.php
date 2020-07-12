<?php

namespace App\Enums;

use App\Concepts\Enum;

/**
 * Class PersonStatusEnum
 * @package App\Enums
 *
 * @method static UserStatusEnum BANNED()
 * @method static UserStatusEnum ACTIVE()
 */
class UserStatusEnum extends Enum
{
    public const BANNED = "banned";
    public const ACTIVE = "active";

    public const LABELS = [
        self::BANNED => "banido",
        self::ACTIVE => "ativo",
    ];
}
