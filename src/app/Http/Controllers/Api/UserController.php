<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Wallet;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('wallet')->get();

        if($users){
            return response()->json($users, 200);
        }

        return response()->json(['message' => 'No Content'], 204);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "email" => 'required | email | unique:users',
            "cpf" => 'required | unique:users',
            "wallet_type" => 'required',
            "password" => 'required',
            "password_confirmation" => 'required'
        ]);

        $userData = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "cpf" => $request->cpf,
            "password" => Hash::make($request->password)
        ]);

        Wallet::create([
            'user_id' => $userData->id,
            'wallet_type' => $request->wallet_type,
            'balance' => 0
        ]);

    }

}
