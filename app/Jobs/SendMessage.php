<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Model\MessageQueue\MessageQueue;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $message_id;

    public function __construct($message_id)
    {
        $this->message_id = $message_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MessageQueueRepositoryInterface $messageQueueRepository)
    {
        $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        if($response->successful()){
            if($response['message'] == 'Enviado') {
                $messageQueueRepository->setSent($this->message_id);
                return true;
            }
        }
        throw new\Exception("Erro ao enviar mensagem");
    }
}
