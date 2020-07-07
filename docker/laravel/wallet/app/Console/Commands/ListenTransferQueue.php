<?php

namespace App\Console\Commands;

use App\Account;
use App\Repositories\AccountRepository;
use App\Repositories\TransferRepository;
use App\Transfer;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Support\Facades\DB;

class ListenTransferQueue extends Command
{
    CONST HOST = 'rabbitmq';
    CONST PORT = 5672;
    CONST USER = 'guest';
    CONST PASSWORD = 'guest';
    CONST EXCHANGE = 'transfer';
    CONST EXCHANGE_TYPE = 'fanout';
    CONST QUEUE = 'transferWallet';

    const PAYER_ACCOUNT_NOT_FOUND = 'Conta do Pagador não encontrado.';
    const PAYEE_ACCOUNT_NOT_FOUND = 'Conta do Recebedor não encontrado.';
    const PERSON = 'person';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:listenTransfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen transfer queue';

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
        $this->listenTransfer();
        $this->info("finish listening rabbitmq");
    }

    private function listenTransfer()
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
        try {
            $transferEntity = new Transfer();
            $transferRepository = new TransferRepository($transferEntity);

            $transfer = $transferRepository->getById($data['id']);

            if ($transfer) {
                return;
            }

            $transferEntity = new Account();
            $accountRepository = new AccountRepository($transferEntity);
            $accountPayer = $accountRepository->getById($data['payer']);
            $accountPayee = $accountRepository->getById($data['payee']);

            if (!$accountPayer) {
                throw new Exception(self::PAYER_ACCOUNT_NOT_FOUND);
            }

            if (!$accountPayee) {
                throw new Exception(self::PAYEE_ACCOUNT_NOT_FOUND);
            }

            $accountPayer->saldo = $accountPayer->saldo - $data['value'];
            $accountPayer->saldo = $accountPayer->saldo + $data['value'];

            DB::beginTransaction();

            $accountPayer = $accountRepository->update($accountPayer->all(), $accountPayer->id, $attribute = self::PERSON);
            $accountPayee = $accountRepository->update($accountPayee->all(), $accountPayee->id, $attribute = self::PERSON);
            $transferRepository->create($data);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }



    }
}
