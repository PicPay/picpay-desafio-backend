<?php

namespace App\Response;

use Illuminate\Http\JsonResponse;

abstract class Response
{
    protected $payload;

    protected $status;

    public function response(): JsonResponse
    {
        return response()->json(['data' => $this->payload], $this->status);
    }

    public function error(): JsonResponse
    {
        return response()->json(['error' => $this->payload], $this->status);
    }
}
