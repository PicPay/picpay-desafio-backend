<?php

namespace App\Listeners;

use Log;
use App\Exceptions\UserWithNoBalanceException;
use App\Exceptions\NotAllowerTransactionException;
use App\Models\User;
use App\Models\UserHistory;
use App\Events\ReceiveTransactions;

class VerifyUserHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReceiveTransactions  $event
     * @return void
     */
    public function handle(ReceiveTransactions $event)
    {
        $amount = UserHistory::where('user_id', $event->transaction()->payer)->sum('amount');

        if( ($amount - $event->transaction()->value) <= 0){
            Log::error('User has no value to do transaction');
            throw new UserWithNoBalanceException('Usuário não tem saldo para realizar transação');
        }

        $payer = User::find($event->transaction()->payer);

        if($payer->type === 'COMPANY'){
            Log::error('Company is not allower to do transaction');
            throw new NotAllowerTransactionException("Empresas não podem realizar transações");
        }
    }
}
