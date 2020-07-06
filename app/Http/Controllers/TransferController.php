<?php

namespace App\Http\Controllers;

use App\Repositories\TransferRepository;
use Illuminate\Http\Request;

class TransferController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\TransferErrorException
     * @throws \App\Exceptions\UnauthorizedServiceException
     */
    public function create(Request $request)
    {
        $repository = new TransferRepository($request);
        return $repository->create();
    }
}
