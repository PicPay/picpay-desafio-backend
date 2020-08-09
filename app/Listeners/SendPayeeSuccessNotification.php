<?php

namespace App\Listeners;

use App\Events\TransactionAuthorizedAndCompleted;
use App\Jobs\SendMessageJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class SendPayeeSuccessNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $messageQueueRepository;

    public function __construct(MessageQueueRepositoryInterface $messageQueueRepository)
    {
        $this->messageQueueRepository = $messageQueueRepository;
    }

    /**
     * Handle the event.
     *
     * @param  TransactionAuthorizedAndCompleted  $event
     * @return void
     */
    public function handle(TransactionAuthorizedAndCompleted $event)
    {
        $payee_id = $event->transaction->payee_id;
        $amount = $event->transaction->amount;
        $payer_name = $event->transaction->payer->name;

        $msg_content = "Você recebeu {$amount} de  {$payer_name}";
        $message = $this->messageQueueRepository->add($payee_id,$msg_content);
        SendMessageJob::dispatch($message->message_id);
    }
}
