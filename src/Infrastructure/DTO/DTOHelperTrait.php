<?php

declare(strict_types=1);

namespace App\Infrastructure\DTO;

use App\Domain\Shared\ValueObject\Amount\AmountInterface;
use App\Domain\Shared\ValueObject\DocumentInterface;
use DateTimeInterface;

trait DTOHelperTrait
{
    private function getDocumentFragment(DocumentInterface $document): array
    {
        return [
            'number' => [
                'clean' => $document->getNumber(),
                'masked' => $document->getNumberMasked(),
            ],
            'type' => $document->getType(),
        ];
    }

    private function getAmountFragment(AmountInterface $amount): array
    {
        return [
            'integer' => $amount->getValue(),
            'decimal' => $amount->getValueDecimal(),
        ];
    }

    private function getDateTimeFragment(?DateTimeInterface $dateTime): array
    {
        if (is_null($dateTime)) {
            return [
                'canonical' => null,
                'ptBr' => null,
            ];
        }

        return [
            'canonical' => $dateTime->format('Y-m-d H:i:s'),
            'ptBr' => $dateTime->format('d/m/Y H:i:s'),
        ];
    }
}
