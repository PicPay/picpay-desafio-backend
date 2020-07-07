<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient\ApiClientInterface;

class ApiClient implements ApiClientInterface
{
    public function isValidPayerAccount(Document $document): bool
    {
        return false;
    }
}
