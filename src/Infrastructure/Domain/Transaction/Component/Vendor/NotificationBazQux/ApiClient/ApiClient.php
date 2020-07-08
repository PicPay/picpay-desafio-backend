<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Transaction\Component\Vendor\NotificationBazQux\ApiClient;

use App\Domain\Transaction\Component\Vendor\NotificationBazQux\ApiClient\ApiClientInterface;
use App\Domain\Transaction\Entity\Transaction\Transaction;
use Fig\Http\Message\RequestMethodInterface;
use GuzzleHttp\ClientInterface;
use Throwable;

class ApiClient implements ApiClientInterface
{
    public const RESPONSE_SENT = 'Enviado';

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function notifyNewTransaction(Transaction $transaction): bool
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

            return self::RESPONSE_SENT === $apiData['message'];
        } catch (Throwable $e) {
            return false;
        }
    }
}
