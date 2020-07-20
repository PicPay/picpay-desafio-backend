<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User ;

class AuthController extends Controller
{
    public function login(Request $request){
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(User::where('email', $credentials['email'])->first(), 200);
        }

        return response()->json(['message' => 'Unauthorized'], 400);

    }
}
