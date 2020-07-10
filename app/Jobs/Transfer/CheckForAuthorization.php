<?php

namespace App\Jobs\Transfer;

use App\Models\Transfer\Transfer;
use App\Repositories\Contracts\Transfer\TransferRepositoryContract;
use App\Services\Contracts\Authorization\AuthorizationServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckForAuthorization implements ShouldQueue
{
    use Dispatchable;

    /**
     * @var Transfer
     */
    private $transfer;
    /**
     * @var AuthorizationServiceContract
     */
    private $authorizationService;
    /**
     * @var TransferRepositoryContract
     */
    private $transferRepository;

    public function __construct(
        Transfer $transfer,
        AuthorizationServiceContract $authorizationService,
        TransferRepositoryContract $transferRepository
    ) {
        $this->transfer = $transfer;
        $this->authorizationService = $authorizationService;
        $this->transferRepository = $transferRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->authorizationService->isTransferAuthorized(
            $this->transfer->payer_id,
            $this->transfer->payee_id,
            $this->transfer->value
        )) {
            $this->transferRepository->setTransferAsAuthorized($this->transfer->id);
        }
    }
}
