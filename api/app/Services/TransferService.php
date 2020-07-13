<?php

namespace App\Services;

use App\Models\Transfer;
use App\Models\User;
use App\Notifications\TransferReceiptNotification;
use App\Services\Contracts\AuthorizationServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class TransferService
 * @package App\Services
 */
class TransferService
{
    private AuthorizationServiceInterface $authorizationService;

    /**
     * TransferService constructor.
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function __construct(AuthorizationServiceInterface $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    /**
     * @param User $payer
     * @param User $payee
     * @param int $amount
     * @return Transfer
     */
    public function transfer(User $payer, User $payee, int $amount): Transfer
    {
        Log::info("Transfer resquest: payer $payer->id payee $payee->id amount $amount");
        $transfer = new Transfer($payer, $payee, $amount);

        if (!$canTransfer = $payer->canTransfer($amount)) {
            return $transfer->invalidate(
                is_null($canTransfer)
                    ? 'Company user is not allowed to transfer'
                    : 'Insufficient balance'
            );
		}

        $result = $this->authorizationService->authorize($transfer);

        if (!$result->isSuccess()) {
            return $transfer->fail($result->getMessage());
        }

        DB::beginTransaction();
        try {
            $payer->removeBalance($amount);
            $payee->addBalance($amount);
            DB::commit();
        } catch (\Throwable $e) {
            $transfer->fail('Fail to send money');
            Log::error("Transfer error: transfer $transfer->id rolling back");
            DB::rollBack();
            return $transfer;
        }

        $transfer->succeed();
        Log::info("Notification create: transfer $transfer->id");
        $payee->notify(new TransferReceiptNotification($transfer->toArray()));

        return $transfer;
    }
}
