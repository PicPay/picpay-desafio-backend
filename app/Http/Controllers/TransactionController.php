<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\Transfer\TransferServiceInterface;
use App\Traits\ApiResponse;

class TransactionController extends Controller
{
    use ApiResponse;

    public function __invoke(TransactionRequest $request,TransferServiceInterface $service)
    {
        $payer_id = $request->get('payer');
        $payee_id = $request->get('payee');
        $amount   = $request->get('value');

        $transfer = $service->executeTransferTransaction($payer_id,$payee_id,$amount);

        return $this->successResponse($transfer);
    }
}
