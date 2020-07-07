<?php

namespace App\Console\Commands;

use App\PersonType;
use App\Repositories\PersonTypeRepository;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ListenPersonTypeQueue extends Command
{
    CONST HOST = 'rabbitmq';
    CONST PORT = 5672;
    CONST USER = 'guest';
    CONST PASSWORD = 'guest';
    CONST EXCHANGE = 'personType';
    CONST EXCHANGE_TYPE = 'fanout';
    CONST QUEUE = 'personTypeTransaction';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:listenPersonType';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen person type queue';

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
        $this->listenPersonType();
        $this->info("finish listening rabbitmq");
    }

    private function listenPersonType()
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
        $personTypeEntity = new PersonType();
        $personTypeRepository = new PersonTypeRepository($personTypeEntity);

        $personType = $personTypeRepository->getById($data['id']);

        if (!$personType) {
            $personTypeRepository->create($data);
            return;
        }

        $personTypeRepository->update($data, $data['id']);
    }
}
