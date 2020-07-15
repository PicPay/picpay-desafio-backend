<?php


namespace App\Authorizer\Adapter;


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MockyAdapter implements AuthorizerAdapterInterface
{
    const MESSAGE_OK = 'Autorizado';

    protected HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function allow(): bool
    {
        try {
            $response = $this->client->request('GET', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            $data = $response->toArray();
            return $data['message'] == self::MESSAGE_OK;
        } catch(\Throwable $e) {
            //TODO Criar log
            return false;
        }
    }
}