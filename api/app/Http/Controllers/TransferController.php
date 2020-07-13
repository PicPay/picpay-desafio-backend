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
     * @return Transfer
     */
    public function store(Request $request): Transfer
    {
        $payer = User::find($request->payer);
        $payee = User::find($request->payee);

        return TransferFacade::transfer($payer, $payee, $request->value);
    }
}
