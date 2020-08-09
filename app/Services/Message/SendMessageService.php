<?php

namespace App\Services\Message;

use Illuminate\Support\Facades\Http;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class SendMessageService implements SendMessageServiceInterface
{
    private $messageRepository;

    public function __construct(MessageQueueRepositoryInterface $messageQueueRepository)
    {
        $this->messageRepository = $messageQueueRepository;
    }

    public function executeSendMessage($message_id) : bool
    {
        $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        if($response->successful() && $response['message'] == 'Enviado'){
            return true;
        }
        return false;
//        throw new\Exception("Erro ao enviar mensagem");
    }
}
