<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;

class WalletController extends Controller
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function directWithdraw(Request $request)
    {
        $payload = $this->validate($request, [
            'value' => 'required|numeric',
        ]);

        $this->walletService->directWithdraw($payload['value']);

        return response(null, 201);
    }
}
