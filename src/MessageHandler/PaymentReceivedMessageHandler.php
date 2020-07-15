<?php


namespace App\MessageHandler;


use App\Message\PaymentReceivedMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PaymentReceivedMessageHandler implements MessageHandlerInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(PaymentReceivedMessage $message)
    {
        $response = $this->client->request('GET', 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        $data = $response->toArray();

        if ($data['message'] == 'Enviado') {
            // @TODO Sucesso na mensagem
        }
    }
}