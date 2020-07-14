<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class TransferMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'payee' => 'required|int|min:1|exists:App\Models\User,id',
                'payer' => 'required|int|min:1|exists:App\Models\User,id',
                'value' => 'required|numeric|min:1',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->payee === $request->payer) {
            return response()->json(['message' => 'Transaction not allowed, payee and payer can not be the same.'], 400);
        }

        $request->value = $this->convertToCents($request->value);
        return $next($request);
    }

    private function convertToCents(float $value)
    {
        return (int)($value * 100);
    }
}
