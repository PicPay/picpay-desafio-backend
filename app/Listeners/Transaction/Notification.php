<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Validation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\ConnectionException;
use App\Models\Transaction\Transaction;
use App\Interfaces\Transaction\TransactionInterface;
use Log;
use Exception;

class Notification implements ShouldQueue
{
    use InteractsWithQueue;

    private $transactionRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Handle the event.
     *
     * @param  Validation  $event
     * @return void
     */
    public function handle(Validation $event): bool
    {
        Log::info(__CLASS__);
        if ($this->hasntBeenApproved($event)) {
            return false;
        }

        $this->send($event->payload);
        return true;
    }

    /**
     * Validation to use this listener
     *
     * @param Validation $event
     * @return bool
     */
    public function hasntBeenApproved(Validation $event): bool
    {
        return $this->transactionRepository->findById($event->transaction["id"])["status"] != Transaction::APPROVED;
    }

    /**
     * Send Notificationto 3rd party service
     *
     * @param array $payload
     * @return void
     */
    private function send(array $payload): void
    {
        try {
            $response = Http::post(config("external.notification"), $payload);

            if ($response->getStatusCode() != Response::HTTP_OK) {
                $this->release(30);
            }
        } catch (ConnectionException $exception) {
            $this->release(60);
        } catch (Exception $exception) {
            Log::error($exception);
            $this->fail($exception);
        }
    }
}
