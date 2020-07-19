<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->classModel = User::class;
    }

    public function store(UserRequest $request)
    {
        try {
            $userInput = $request->all();
            $userInput['password'] = Hash::make($request->get('password'));
            $user = User::create($userInput);

            $wallet = new WalletController();
            $wallet->createWallet($user, $request);
            return response()->json($userInput,201);

        } catch (Throwable $error){
            return response()->json(['message' => $error->getMessage()], 400);
        }
    }
}
