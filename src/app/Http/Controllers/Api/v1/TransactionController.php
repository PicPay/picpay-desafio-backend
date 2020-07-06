<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    /**
     * @var \App\Services\TransactionService
     */
    private $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            $transaction = $this->service->createTransaction($request->all());
            return response()->json(
                [
                    'data' => [
                        'message' => $transaction['message']
                    ]
                ]
            );
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }
}
