<?php

namespace App\Events;

use App\User;
use App\Transaction;

class TransactionEvent extends Event
{
    
    private $error  = false;
    private $failed = false;

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

    public function done()
    {
        $this->getTransaction()->save();
        return $this->getTransaction();
    }
}
