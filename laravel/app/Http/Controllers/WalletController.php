<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\Http\Resources\WalletResource;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Console\Exception\MissingInputException;
use Throwable;

class WalletController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param Wallet $wallet
     * @param User $user
     * @return WalletResource|JsonResponse
     */
    public function show(Wallet $wallet, User $user)
    {
        try {
            $resource = new WalletResource($user->wallet);
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return $resource;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WalletRequest $request
     * @param User $user
     * @return WalletResource|JsonResponse
     */
    public function update(WalletRequest $request, User $user)
    {
        try {
            $wallet = $user->wallet;
            $hadChanges = false;
            if ($request->exists("balance")) {
                $wallet->balance = $request->get("balance");
                $hadChanges = true;
            }
            if ($request->exists("type")) {
                $wallet->type = $request->get("type");
                $hadChanges = true;
            }
            if (!$hadChanges) {
                throw new Exception("Não houve alteração de dados.");
            }
            $wallet->saveOrFail();
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return new WalletResource($wallet);
    }
}
