<?php

declare(strict_types=1);

namespace Transfer\Infra\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class Client
 * @package Transfer\Infra\Http
 */
class Client implements Http
{
    /**
     * @var GuzzleClient
     */
    private GuzzleClient $client;

    /**
     * Client constructor.
     * @param GuzzleClient $client
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return Response
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, array $options = [])
    {
        try {
            return $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}
