<?php

namespace App\Events;

use App\User;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionEvent extends Event
{
    
    private $error  = "Unknow error";
    private $failed = true;

    private $transaction = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( User $payer, User $payee, $value )
    {
        $this->payer = $payer;
        $this->payee = $payee;

        $this->value = $value;
    }


    public function getPayer(): User 
    {
        return $this->payer;
    }

    public function getPayee(): User 
    {
        return $this->payee;
    }

    public function getTransaction(): Transaction
    {
        if(!$this->transaction ) {
            $this->transaction = new Transaction();
        
            $this->transaction->payer_id = $this->payer->id; 
            $this->transaction->payee_id = $this->payee->id;
            $this->transaction->value    = $this->value;
        }
        return $this->transaction;
    }

    public function isFailed()
    {
        return $this->failed;
    }

    public function getError()
    {
        return $this->error;
    }

    public function abort( $errorMessage = "Unknow error in transaction" )
    {
        $this->failed = true;
        $this->error  = $errorMessage;
        return false;
    }

    public function proceed()
    {
        $this->failed = false;
        $this->error  = null;
    }

    public function done()
    {
        if( $this->failed ) {
            return false;
        }


        $value = $this->getTransaction()->value;

        $this->payer->balance = $this->payer->balance - $value;
        $this->payee->balance = $this->payee->balance + $value;

        try {
            DB::transaction(function () {
                $this->payer->save();
                $this->payee->save();
                $this->getTransaction()->save();
            }, 5);
        }catch( \Exception $e ) {
            return $this->abort('Failed to proceed');
        }
        
        return $this->getTransaction();
    }
}
