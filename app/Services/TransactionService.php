<?php

namespace App\Services;

use App\Models\User;
use App\Enum\UserType;
use App\Models\Transaction;
use App\Enum\TransactionStatus;
use App\Events\CreateTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidPayerException;
use App\Repositories\TransactionRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionService
{
    private $transactionRepository;

    private $authService;

    private $payeeService;

    private $authorizationService;

    public function __construct(
        TransactionRepository $transactionRepository,
        AuthService $authService,
        PayeeService $payeeService,
        AuthorizationService $authorizationService
    ) {
        $this->transactionRepository = $transactionRepository;

        $this->authService = $authService;

        $this->payeeService = $payeeService;

        $this->authorizationService = $authorizationService;
    }

    public function create(array $payload): Transaction
    {
        $user = $this->authService->context();

        $this->isAbleToMakeTransfers($user, $payload);

        $payee = $this->payeeService->getById($payload['payee']);

        $newTransaction = $this->transactionRepository->createWithAssociations(
            ['value' => $payload['value']],
            ['payer' => $user, 'payee' => $payee, 'wallet' => $user->wallet]
        );

        event(new CreateTransaction($newTransaction));

        return $newTransaction;
    }

    private function isAbleToMakeTransfers(User $user, array $payload): void
    {
        throw_if(
            $user->id !== $payload['payer'],
            InvalidPayerException::class
        );

        throw_if(
            $user->id === $payload['payee'],
            InvalidPayerException::class,
            'It is not possible to transfer from payer to payer.'
        );

        throw_if(
            $user->type === UserType::SELLER,
            InvalidPayerException::class,
            'Seller user cannot make transfers.'
        );
    }

    public function process(Transaction $transaction): void
    {
        $UUID = '8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $log = ['transaction_id' => $transaction->id, 'uuid' => $UUID];

        Log::info('PROCESSING_TRANSACTION', $log);

        if ($this->authorizationService->isAuthorized($UUID)) {
            $this->transactionRepository->update($transaction, ['status' => TransactionStatus::PROCESSED]);
            Log::info('PROCESSING_TRANSACTION_PROCESSED', $log);

            return;
        }

        $this->transactionRepository->update($transaction, ['status' => TransactionStatus::UNAUTHORIZED]);
        Log::info('PROCESSING_TRANSACTION_UNAUTHORIZED', $log);
    }

    public function list(array $status, int $pearPage = 15): LengthAwarePaginator
    {
        return $this->transactionRepository->listPaginate(Auth::user(), $status, $pearPage);
    }

    public function single(int $id): Transaction
    {
        return $this->transactionRepository->findByUserAndId(Auth::user(), $id);
    }
}
