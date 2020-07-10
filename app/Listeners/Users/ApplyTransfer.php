<?php

namespace App\Listeners\Users;

use App\Events\Transfer\TransferAuthorized;
use App\Services\Contracts\Transfer\TransferServiceContract;
use App\Services\Contracts\Wallet\WalletServiceContract;
use Log;

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
        Log::info("Event listener authorized chamado".json_encode($event->transfer));
        if($event->transfer->authorization_status===1 && $event->transfer->cancelled===0)
        {
            Log::info("Autorizacao confirmada ".json_encode($event));
            $this->walletService->applyTransfer(
                $event->transfer->payer_id,
                $event->transfer->payee_id,
                $event->transfer->value
            );

            $this->transferService->markAsProcessed($event->transfer->id);
        }
    }
}
