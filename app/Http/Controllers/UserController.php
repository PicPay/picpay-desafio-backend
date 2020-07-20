<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Models\User;
use App\Http\Requests\User as Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function store(Request $request){

        $user = $this->user->create($request->all());

        return response()->json(['message' => 'Usuário criado'], 201);
    }

}