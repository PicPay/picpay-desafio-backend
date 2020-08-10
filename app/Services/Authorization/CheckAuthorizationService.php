<?php

namespace App\Services\Authorization;

use Illuminate\Support\Facades\Http;
use Model\MessageQueue\Repositories\MessageQueueRepositoryInterface;
use Model\Transactions\Repositories\TransactionsRepositoryInterface;

class CheckAuthorizationService implements CheckAuthorizationServiceInterface
{
    private $transactionRepository;

    public function __construct(TransactionsRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function executeCheckAuthorization($transaction_id): bool
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            if ($response->successful() && $response['message'] == 'Autorizado') {
                return true;
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
        return false;

//        $transactionsRepository->setNotAuthorized($this->transfer_id);
//        return false;
    }
}
