<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletController extends BaseController
{
    public function __construct()
    {
        $this->classModel = Wallet::class;
    }

    public final function createWallet(User $user, UserRequest $request)
    {
        try {
          DB::transaction(function () use ($user, $request) {
                $wallet = new Wallet();
                $wallet->user_id = $user->id;
                $wallet->balance = 0.0;
                $wallet->saveOrFail();
            });
        }catch (Throwable $error){
            return response()->json(['message' => $error->getMessage()], 400);
        }
    }
}
