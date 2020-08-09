<?php

namespace App\Jobs;

use App\Services\Message\SendMessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Model\MessageQueue\MessageQueue;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class SendMessageJob implements ShouldQueue
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
    public function handle(SendMessageService $sendMessageService,MessageQueueRepositoryInterface $messageQueueRepository)
    {
        if($sendMessageService->executeSendMessage($this->message_id)){
            $messageQueueRepository->setSent($this->message_id);
            return true;
        }
        return false;
    }
}
