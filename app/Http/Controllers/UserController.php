<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\{Request,Response};

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::paginate(10);
        return $users;
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found!"], 404);
        }
        return $user;
    }
}
