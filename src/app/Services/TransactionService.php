<?php

namespace App\Services;

use App\Jobs\SendNotificationTransactionEmail;
use App\Repositories\Contracts\UserRepositoryInterface;

class TransactionService
{
    const NORMAL = 'NORMAL';
    const SHOPKEEPER = 'SHOPKEEPER';

    /**
     * @var \App\Repositories\Contracts\UserRepositoryInterface
     */
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createTransaction(array $data)
    {
        try {
            $payer = $this->repository->findById($data['payer']);

            if ($payer->type == self::SHOPKEEPER) {
                return [
                    'message' => 'Lojista não pode realizar transferência.'
                ];
            }

            $mocky = new \App\Services\MockyService();
            if ($mocky->autorize()) {
                if ($this->repository->createTransaction($data)) {
                    $value = $data['value'];
                    $data = [
                        'balance' => $payer->balance - $value
                    ];
                    $this->repository->update($payer->id, $data);

                    $parameters = [
                        'payer' => $payer,
                        'value' => 'R$ '.number_format($value, 2, ',', '.'),
                        'message' => $mocky->notificate()['message'],
                    ];
                    SendNotificationTransactionEmail::dispatch($parameters);

                    return [
                        'message' => 'Transferência realizada com sucesso.'
                    ];
                }
            }

            return [
                'message' => 'Não foi possivel realizar a transferência.'
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}