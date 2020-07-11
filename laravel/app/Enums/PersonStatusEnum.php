<?php

namespace App\Enums;

use App\Concepts\Enum;

class PersonStatusEnum extends Enum
{
    public const BANNED = "banned";
    public const ACTIVE = "active";

    public const LABELS = [
        self::BANNED => "banido",
        self::ACTIVE => "ativo",
    ];
}
