<?php

declare(strict_types=1);

namespace App\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient;

use App\Domain\Shared\ValueObject\Document;

interface ApiClientInterface
{
    public function isValidPayerAccount(Document $document): bool;
}
