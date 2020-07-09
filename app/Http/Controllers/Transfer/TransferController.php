<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\ValidateTransferRequest;
use App\Services\Contracts\Transfer\TransferServiceContract;

class TransferController extends Controller
{

    /**
     * @var TransferServiceContract
     */
    private $transferService;

    public function __construct(
        TransferServiceContract $transferService
    ) {
        $this->transferService = $transferService;
    }

    public function __invoke(ValidateTransferRequest $request)
    {
        $this->transferService->processTransfer($request->payer_id, $request->payee_id, $request->value);
        return [];
    }
}
