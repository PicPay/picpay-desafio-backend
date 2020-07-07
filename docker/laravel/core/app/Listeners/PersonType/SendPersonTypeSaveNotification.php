<?php

namespace App\Listeners\PersonType;

use App\Events\PersonType\PersonTypeSave;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendPersonTypeSaveNotification
{
    CONST EXCHANGE_NAME = 'personType';
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
     * @param  PersonTypeSave  $event
     * @return void
     */
    public function handle(PersonTypeSave $event)
    {
        $connection = new AMQPStreamConnection(self::HOST, self::PORT, self::USER, self::PASSWORD);
        $channel = $connection->channel();
        $channel->exchange_declare(self::EXCHANGE_NAME, self::EXCHANGE_TYPE, true, false, false);
        $msg = new AMQPMessage($event->data);
        $channel->basic_publish($msg, self::EXCHANGE_NAME);
    }
}
