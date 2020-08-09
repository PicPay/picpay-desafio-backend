<?php

namespace App\Listeners;

use App\Events\TransactionFailedAndRollbacked;
use App\Jobs\SendMessageJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class SendPayerFailureNotification
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
     * @param  TransactionFailedAndRollbacked  $event
     * @return void
     */
    public function handle(TransactionFailedAndRollbacked $event)
    {
        $payer_id = $event->transaction->payer_id;
        $amount = $event->transaction->amount;
        $payee_name = $event->transaction->payee->name;
        $msg_content =  "Sua transação falhou :(";

        $message = $this->messageQueueRepository->add($payer_id,$msg_content);
        SendMessageJob::dispatch($message->message_id);
    }
}
