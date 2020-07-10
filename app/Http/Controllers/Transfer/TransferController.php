<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\ValidateTransferRequest;
use App\Services\Contracts\Transfer\TransferServiceContract;

class TransferController extends Controller
{
    public function __invoke(ValidateTransferRequest $request, TransferServiceContract $transferService)
    {
        try {
            $transfer = $transferService->registerTransfer($request->payer_id, $request->payee_id, $request->value);
            $result = [
                'status' => true,
                'transfer' => $transfer
            ];
            return response()->json($result);
        } catch (Exception $e) {
            $result = [
                'status' => false,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $e->getCode());
        }
    }
}
