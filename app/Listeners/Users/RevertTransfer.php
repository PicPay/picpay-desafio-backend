<?php

namespace App\Listeners\Users;

use App\Events\Transfer\TransferCancelled;
use App\Services\Contracts\Transfer\TransferServiceContract;
use App\Services\Contracts\Wallet\WalletServiceContract;

class RevertTransfer
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
     * @param  TransferCancelled  $event
     * @return void
     */
    public function handle(TransferCancelled $event)
    {
        if ($this->walletService->isReversible($event->transfer)) {
            $this->walletService->revertTransfer(
                $event->transfer->payer_id,
                $event->transfer->payee_id,
                $event->transfer->value
            );
            return true;
        }
        throw new \RuntimeException('Não é possível reverter a transferência');
    }
}
