<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Regular()
 * @method static static SalesPerson()
 */
final class UserType extends Enum
{
    const Regular     =   0;
    const SalesPerson =   1;
}
