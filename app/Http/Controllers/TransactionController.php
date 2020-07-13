<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Interfaces\Transaction\TransactionInterface;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Validation\ValidationException;
use Log;

class TransactionController extends Controller
{

    protected $transactionRepository;

    /**
     * Injecting Transaction interface
     *
     * @param TransactionInterface $transactionRepositoy
     */
    public function __construct(TransactionInterface $transactionRepositoy)
    {
        $this->transactionRepository = $transactionRepositoy;
    }

    /**
     * Begin transaction funds
     *
     * @param Request $request
     * @return void
     */
    public function execute(Request $request)
    {
        try {
            $jsonReponse = [
                'status' => 'error',
                'message' => ""
            ];
            $code = Response::HTTP_OK;
            
            $this->validateRequest($request, TransactionRequest::class);

            $jsonReponse['data'] = $this->transactionRepository->create($request->all());
            $jsonReponse['status'] = "success";
        } catch (ValidationException $exception) {
            Log::error($exception);
            $jsonReponse["message"] = $exception->validator->errors();
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (Exception $exception) {
            Log::error($exception);
            $jsonReponse["message"] = $exception->getMessage();
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($jsonReponse, $code);
    }
}
