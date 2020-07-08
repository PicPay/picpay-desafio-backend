<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\UserAccount\DTO;

use App\Domain\Shared\ValueObject\Amount\AmountInterface;
use DateTimeInterface;

use function is_null;

trait DTOHelperTrait
{
    private function getAmountFragment(AmountInterface $amount): array
    {
        return [
            'integer' => $amount->getValue(),
            'decimal' => $amount->getValueDecimal(),
        ];
    }

    private function getDateTimeFragment(?DateTimeInterface $dateTime): ?string
    {
        if (is_null($dateTime)) {
            return null;
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
