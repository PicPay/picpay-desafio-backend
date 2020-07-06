<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;

class Repository
{
    protected function validate($data, $rules, $messages, $attributes)
    {
        $validator = Validator::make($data, $rules, $messages, $attributes);
        $validator->validate();
    }

    protected function returnResponseJson($data, $message, $success = true, $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => $success,
            'statusCode' => $statusCode
        ]);
    }
}
