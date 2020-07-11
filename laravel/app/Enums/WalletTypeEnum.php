<?php

namespace App\Enums;

use App\Concepts\Enum;

/**
 * Class WalletTypeEnum
 * @package App\Enums
 *
 * @method static WalletTypeEnum USER_WALLET()
 * @method static WalletTypeEnum SHOPKEEPER_WALLET()
 */
class WalletTypeEnum extends Enum
{
    public const USER_WALLET = "user";
    public const SHOPKEEPER_WALLET = "shopkeeper";

    public const LABELS = [
        self::USER_WALLET => "carteira de usuário",
        self::SHOPKEEPER_WALLET => "carteira de lojista",
    ];
}
