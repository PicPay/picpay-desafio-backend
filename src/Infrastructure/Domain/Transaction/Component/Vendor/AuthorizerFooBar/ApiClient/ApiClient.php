<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient\ApiClientInterface;
use Fig\Http\Message\RequestMethodInterface;
use GuzzleHttp\ClientInterface;
use Throwable;

use function json_decode;

class ApiClient implements ApiClientInterface
{
    public const RESPONSE_AUTHORIZED = 'Autorizado';

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function isValidPayerAccount(Document $document): bool
    {
        try {
            $response = $this
                ->client
                ->request(RequestMethodInterface::METHOD_GET, '')
            ;

            $apiData = json_decode(
                $response
                    ->getBody()
                    ->getContents(),
                true
            );

            return self::RESPONSE_AUTHORIZED === $apiData['message'];
        } catch (Throwable $e) {
            return false;
        }
    }
}
