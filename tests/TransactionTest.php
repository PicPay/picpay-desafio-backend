<?php

use App\Events\TransactionEvent;
use App\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    public function defaultEvent()
    {
        return new TransactionEvent( User::find(4), User::find(15), 100 );
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTransactionEvent()
    {
        $this->expectsEvents('App\Events\TransactionEvent');
        event( $this->defaultEvent() );
    }

    public function testTransactionEventSuccess()
    {
        $event = $this->defaultEvent() ;        
        event( $event );
        $this->assertFalse($event->isFailed());

        $this->assertTrue( !!$event->done() );
    }

    public function testTransactionSaved()
    {
        $event = $this->defaultEvent() ;        
        event( $event );
        $this->assertTrue( !!$event->done() );

        $this->assertTrue( isset( $event->getTransaction()->id ) && $event->getTransaction()->id !== null );
        $this->seeInDatabase('transaction', ['id' => $event->getTransaction()->id]);
    }

    
}
