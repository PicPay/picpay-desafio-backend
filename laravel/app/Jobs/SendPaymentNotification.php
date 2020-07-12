<?php

namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    /**
     * @var User $payer
     */
    private $payer;
    /**
     * @var User $payee
     */
    private $payee;
    /**
     * @var float $amount
     */
    private $amount;

    /**
     * Create a new job instance.
     *
     * @param User $payer
     * @param User $payee
     * @param float $amount
     */
    public function __construct(User $payer, User $payee, float $amount)
    {
        $this->payer = $payer;
        $this->payee = $payee;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new Client())->post(
            "https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04",
            [
                "accept" => "application/json",
                "body" => json_encode([
                    "target_id" => $this->payee->id,
                    "target_name" => $this->payee->name,
                    "target_email" => $this->payee->email,
                    "title" => "Você recebeu um pagamento!",
                    "message" => "Você recebu R$ {$this->amount} de {$this->payer->name}.",
                ]),
            ]
        );
    }
}
