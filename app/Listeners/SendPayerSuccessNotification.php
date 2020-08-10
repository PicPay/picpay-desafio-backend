<?php

namespace App\Listeners;

use App\Events\TransactionAuthorizedAndCompleted;
use App\Jobs\SendMessageJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;

class SendPayerSuccessNotification
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
        $payer_id = $event->transaction->payer_id;
        $amount = $event->transaction->amount;
        $payee_name = $event->transaction->payee->name;
        $msg_content = "Comprovante: Você pagou {$amount} para  {$payee_name}";

        $message = $this->messageQueueRepository->add($payer_id, $msg_content);
        SendMessageJob::dispatch($message->message_id);
    }
}
