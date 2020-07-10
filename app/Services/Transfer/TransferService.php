<?php

namespace App\Services\Transfer;

use App\Repositories\Contracts\Transfer\TransferRepositoryContract;
use App\Services\Contracts\Authorization\AuthorizationServiceContract;
use App\Services\Contracts\Transfer\TransferServiceContract;

class TransferService implements TransferServiceContract
{

    /**
     * @var TransferRepositoryContract
     */
    private $transferRepository;
    /**
     * @var AuthorizationServiceContract
     */
    private $authorizationService;

    public function __construct(
        TransferRepositoryContract $transferRepository,
        AuthorizationServiceContract $authorizationService
    ) {
        $this->transferRepository = $transferRepository;
        $this->authorizationService = $authorizationService;
    }

    public function processTransfer($payer_id, $payee_id, $value)
    {
        $transfer = $this->transferRepository->createTransfer($payer_id, $payee_id, $value);
        if ($this->authorizationService->isTransferAuthorized(
            $payer_id,
            $payee_id,
            $value
        )) {
            $this->transferRepository->setTransferAsAuthorized($transfer->id);
        }
        return $transfer;
    }

    public function markAsProcessed($transfer_id)
    {
        return $this->transferRepository->markAsProcessed($transfer_id);
    }
}
