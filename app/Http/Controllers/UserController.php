<?php

namespace App\Http\Controllers;


use App\User;

class UserController extends Controller
{

    public function details($id) {
        try {
            $userDetails = User::details($id);

            if (empty($userDetails)) {
                return response()->json([]);
            }

            return response()->json(collect($userDetails));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
