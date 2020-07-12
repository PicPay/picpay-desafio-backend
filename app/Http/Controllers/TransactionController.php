<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Interfaces\Transaction\TransactionInterface;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Validation\ValidationException;

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
            
            $this->validateRequest($request);

            $jsonReponse['data'] = $this->transactionRepository->create($request->all());
            $jsonReponse['status'] = "success";
        } catch (ValidationException $exception) {
            $jsonReponse["message"] = $exception->getMessage();
            $code = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (Exception $exception) {
            dd($exception);
            $jsonReponse["message"] = $exception->getMessage();
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($jsonReponse, $code);
    }
    /**
     * Enforce challenge rules
     *
     * @param Request $request
     * @return void
     */
    private function validateRequest(Request $request)
    {
        $transactionRequest = new TransactionRequest;

        $this->validate(
            $request,
            $transactionRequest->getRules(),
            $transactionRequest->getMessages()
        );
    }
}
