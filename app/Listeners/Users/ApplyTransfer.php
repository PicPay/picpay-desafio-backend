<?php

namespace App\Listeners\Users;

use App\Events\Transfer\TransferAuthorized;
use App\Services\Contracts\Transfer\TransferServiceContract;
use App\Services\Contracts\Wallet\WalletServiceContract;

class ApplyTransfer
{
    /**
     * @var WalletServiceContract
     */
    private $walletService;
    /**
     * @var TransferServiceContract
     */
    private $transferService;

    /**
     * Create the event listener.
     *
     * @param  WalletServiceContract  $walletService
     * @param  TransferServiceContract  $transferService
     */
    public function __construct(WalletServiceContract $walletService, TransferServiceContract $transferService)
    {
        $this->walletService = $walletService;
        $this->transferService = $transferService;
    }

    /**
     * Handle the event.
     *
     * @param  TransferAuthorized  $event
     * @return void
     */
    public function handle(TransferAuthorized $event)
    {
        if($event->transfer->authorization_status===1 && $event->transfer->cancelled===0)
        {
           $this->walletService->applyTransfer(
                $event->transfer->payer_id,
                $event->transfer->payee_id,
                $event->transfer->value
            );

            $this->transferService->markAsProcessed($event->transfer->id);
        }
    }
}
