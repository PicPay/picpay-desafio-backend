<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient;

use App\Domain\Shared\ValueObject\Document;
use App\Infrastructure\Domain\Transaction\Component\Vendor\AuthorizerFooBar\ApiClient\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase
{
    public function testIsValidPayerAccount(): void
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], '{"message":"Autorizado"}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $document = new Document('00412651068');
        $apiClient = new ApiClient($client);

        self::assertTrue($apiClient->isValidPayerAccount($document));
    }

    public function testIsNotValidPayerAccount(): void
    {
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], '{"message":"Negado"}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $document = new Document('00412651068');
        $apiClient = new ApiClient($client);

        self::assertFalse($apiClient->isValidPayerAccount($document));
    }

    public function testIsValidThrowException(): void
    {
        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $document = new Document('00412651068');
        $apiClient = new ApiClient($client);

        self::assertFalse($apiClient->isValidPayerAccount($document));
    }
}
