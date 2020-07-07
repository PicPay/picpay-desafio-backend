<?php

namespace App\Console\Commands;

use App\Person;
use App\Repositories\PersonRepository;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ListenPersonQueue extends Command
{
    CONST HOST = 'rabbitmq';
    CONST PORT = 5672;
    CONST USER = 'guest';
    CONST PASSWORD = 'guest';
    CONST EXCHANGE = 'person';
    CONST EXCHANGE_TYPE = 'fanout';
    CONST QUEUE = 'personWallet';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:listenPerson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen person queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("start listening rabbitmq");
        $this->listenPerson();
        $this->info("finish listening rabbitmq");
    }

    private function listenPerson()
    {
        $connection = new AMQPStreamConnection(self::HOST, self::PORT, self::USER, self::PASSWORD);
        $channel = $connection->channel();
        $channel->exchange_declare(self::EXCHANGE, self::EXCHANGE_TYPE, true, false, false);
        $channel->queue_declare(self::QUEUE, true, false, false, false);
        $channel->queue_bind(self::QUEUE, self::EXCHANGE);
        $this->info("Waiting for messages. To exit press CTRL+C");

        $callback = function ($msg) {
            $this->info("Received");
            $this->info($msg->body);
            $body = json_decode($msg->body, true);
            $this->save($body);
        };

        $channel->basic_consume(self::QUEUE, '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    private function save($data) {
        $personEntity = new Person();
        $personRepository = new PersonRepository($personEntity);

        $person = $personRepository->getById($data['id']);

        if (!$person) {
            $personRepository->create($data);
            return;
        }

        $personRepository->update($data, $data['id']);
    }
}
