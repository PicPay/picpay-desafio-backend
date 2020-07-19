<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;

class TransferAuthorization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $maxExceptions = 1;

    private $transfer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($transfer_id)
    {
        $this->transfer_id = $transfer_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TransactionsRepositoryInterface $transactionsRepository)
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if($response->successful()){
            if($response['message'] == 'Autorizado'){
                $transactionsRepository->setAuthorized($this->transfer_id);
            }else{
                throw new \Exception("Não autorizado");
            }
        }
    }
}
