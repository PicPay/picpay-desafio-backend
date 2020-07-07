<?php

namespace App\Listeners\Person;

use App\Events\Person\PersonSave;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendPersonSaveNotification
{
    CONST EXCHANGE_NAME = 'person';
    CONST EXCHANGE_TYPE ='fanout';
    CONST HOST = 'rabbitmq';
    CONST PORT = '5672';
    CONST USER = 'guest';
    CONST PASSWORD = 'guest';

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
     * @param  PersonSave  $event
     * @return void
     */
    public function handle(PersonSave $event)
    {
        $connection = new AMQPStreamConnection(self::HOST, self::PORT, self::USER, self::PASSWORD);
        $channel = $connection->channel();
        $channel->exchange_declare(self::EXCHANGE_NAME, self::EXCHANGE_TYPE, true, false, false);
        $msg = new AMQPMessage($event->data);
        $channel->basic_publish($msg, self::EXCHANGE_NAME);
    }
}
