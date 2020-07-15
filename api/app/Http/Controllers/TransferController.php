<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Facades\TransferFacade;

class TransferController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $payer = User::find($request->payer);
        $payee = User::find($request->payee);
        $transfer = TransferFacade::transfer($payer, $payee, $request->value);

        return response()->json($transfer, 201);
    }
}
