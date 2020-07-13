<?php
namespace App\Notifications;

use App\Channels\MockyChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class TransferReceiptNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public object $transfer;

    public function __construct($transfer)
    {
        $this->queue = 'transferReceipt';
        $this->transfer = (object) $transfer;
    }


    public function via($notifiable)
    {
        return [MockyChannel::class];
    }

    public function toMock($notifiable)
    {
        return [
            "id" => $this->id,
            "payee" => $this->transfer->payee_id,
            "payer" => $this->transfer->payer_id,
            "amount" => $this->transfer->amount,
        ];
    }
}
