<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Transfer\TransferServiceContract;
use Illuminate\Http\Request;

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

    public function __invoke(Request $request)
    {
        $this->transferService->processTransfer($request->payer_id, $request->payee_id, $request->value);
        return [];
    }
}
