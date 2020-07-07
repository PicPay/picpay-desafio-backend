<?php

namespace App\Console\Commands;

use App\DocumentType;
use App\Repositories\DocumentTypeRepository;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ListenDocumentTypeQueue extends Command
{
    CONST HOST = 'rabbitmq';
    CONST PORT = 5672;
    CONST USER = 'guest';
    CONST PASSWORD = 'guest';
    CONST EXCHANGE = 'documentType';
    CONST EXCHANGE_TYPE = 'fanout';
    CONST QUEUE = 'documentTypeTransaction';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:listenDocumentType';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen document type queue';

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
        $this->listenDocumentType();
        $this->info("finish listening rabbitmq");
    }

    private function listenDocumentType()
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
        $documentTypeEntity = new DocumentType();
        $documentTypeRepository = new DocumentTypeRepository($documentTypeEntity);

        $documentType = $documentTypeRepository->getById($data['id']);

        if (!$documentType) {
            $documentTypeRepository->create($data);
            return;
        }

        $documentTypeRepository->update($data, $data['id']);
    }
}
