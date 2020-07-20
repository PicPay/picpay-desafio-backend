<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Services\ThirdPartAuthService;
use App\Jobs\UserNotification;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\Transaction;

class ProcessTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payer = User::find($this->transaction->payer);
        $payee = User::find($this->transaction->payee);
        $transaction = Transaction::find($this->transaction->id);

        //third party validate
        $authService = new ThirdPartAuthService($this->transaction);

        if($authService->authTransaction()){
            UserHistory::create([
                'user_id' => $this->transaction->payee,
                'amount' => $this->transaction->value,
                'date' => now()
            ]);

            $transaction->status = 'COMPLETED';
            $transaction->save();

            $notifications = [
                [
                    'user_id' => $this->transaction->payer,
                    'message' => 'Transferencia realizada com sucesso'
                ],
                [
                    'user_id' => $this->transaction->payee,
                    'message' => 'Transferencia recebida'
                ]
            ];
        }else{
            UserHistory::create([
                'user_id' => $this->transaction->payer,
                'amount' => $this->transaction->value,
                'date' => now()
            ]);
            $transaction->status = 'REJECT';
            $transaction->save();

            $notifications = [
                [
                    'user_id' => $this->transaction->payer,
                    'message' => 'Transferencia rejeitada'
                ]
            ];
        }

        UserNotification::dispatch($notifications)->onQueue('notification');
    }
}
