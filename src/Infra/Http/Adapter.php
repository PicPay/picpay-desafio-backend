<?php

declare(strict_types=1);

namespace Transfer\Infra\Http;

use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface as HttpResponse;

/**
 * Class Adapter
 * @package Transfer\Infra\Http
 */
class Adapter
{
    /**
     * @var array
     */
    private static array $expectedResponse = ['Autorizado', 'Enviado'];

    /**
     * @var Http
     */
    private Http $httpClient;

    /**
     * Adapter constructor.
     * @param Http $httpClient
     */
    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @return Response
     */
    public function request(string $url): Response
    {
        $requestErrors = [];
        try {
            $response  = $this->httpClient->request('GET', $url);
            return $this->handleResponse($response);
        } catch (ConnectException $exception) {
            $requestErrors[] = $this->handleHttpExceptionResponse($exception);
        } catch (\Exception $exception) {
            $requestErrors[] = $exception->getMessage();
        }

        return new Response(
            500,
            false,
            !empty($requestErrors) ? $requestErrors : null
        );
    }

    /**
     * @param HttpResponse $response
     * @return Response
     */
    private function handleResponse(HttpResponse $response): Response
    {
        $httpCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody()->getContents(), true);

        return new Response(
            $httpCode,
            in_array($responseBody['message'], self::$expectedResponse) ?? false,
            null
        );
    }

    /**
     * @param \Exception $exception
     * @return string
     */
    private function handleHttpExceptionResponse(\Exception $exception): string
    {
        $wasTimeout = strpos($exception->getMessage(), "cURL error 28");
        return ($wasTimeout === false) ? $exception->getMessage() : 'CONNECTION_TIMEOUT';
    }
}
