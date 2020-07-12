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
       
    }
}
