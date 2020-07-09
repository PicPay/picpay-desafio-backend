<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Transfer\TransferRepositoryContract;
use App\Services\Contracts\Authorization\AuthorizationServiceContract;
use Illuminate\Http\Request;

class TransferController extends Controller
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

    public function __invoke(Request $request)
    {
        $transfer = $this->transferRepository->createTransfer($request->payer_id, $request->payee_id, $request->value);
        if ($this->authorizationService->isTransferAuthorized(
            $request->payer_id,
            $request->payee_id,
            $request->value
        )) {
            $this->transferRepository->setTransferAsAuthorized($transfer->id);
        }
        return [];
    }
}
