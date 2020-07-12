<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Validation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use App\Interfaces\Transaction\TransactionInterface;
use App\Models\Transaction\Transaction;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\ConnectionException;
use Log;
use Exception;

class Authorization implements ShouldQueue
{
    use InteractsWithQueue;

    private $transactionRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionInterface $transaction)
    {
        $this->transactionRepository = $transaction;
    }

    /**
     * Handle the event.
     *
     * @param  Validation  $event
     * @return bool
     */
    public function handle(Validation $event): void
    {
        Log::info(__CLASS__);
        $this->requestAuthorization($event);

        $this->updateTransactionStatus($event);
    }

    /**
     * Ger authorization to begin transaction
     *
     * @param array $payload
     * @return void
     */
    private function requestAuthorization(Validation &$event): void
    {
        try {
            $response = Http::post(config("external.authorization"), $event->payload);
            if ($response->getStatusCode() != Response::HTTP_OK) {
                $event->status = Transaction::INCONSISTENCY;
            }
        } catch (ConnectionException $exception) {
            Log::error($exception);
            $event->status = Transaction::INCONSISTENCY;
            $this->release(60);
        } catch (Exception $exception) {
            Log::error($exception);
            $event->status = Transaction::INCONSISTENCY;
            $this->fail($exception);
        }
    }

    /**
     * Undocumented function
     *
     * @param Validation $event
     * @return void
     */
    private function updateTransactionStatus(Validation $event): void
    {
        $this->transactionRepository->updateStatus($event->status, $event->transaction["id"]);
    }
}
