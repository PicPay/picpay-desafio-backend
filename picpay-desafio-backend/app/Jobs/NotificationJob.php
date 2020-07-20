<?php

namespace App\Jobs;

use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $attempts = 3;

    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle()
    {
        (new Client())->post("https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04",
            [
                "accept" => "application/json",
                "body" => json_encode([
                    "payee_id" => $this->transaction->payee_id,
                    "message" => "Você acaba de receber {$this->transaction->value} na sua carteira."
                ])
            ]
        );
    }
}
