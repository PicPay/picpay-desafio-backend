<?php

namespace App\Http\Controllers;

use App\{Transaction,User};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class TransactionController extends Controller
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
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = Transaction::paginate(10);
        return $transactions;
    }

    /**
     * Display the specified transaction.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(["message" => "Transaction not found!"], 404);
        }
        return $transaction;
    }

    /**
     * Display the specified transaction.
     *
     * @param Request $request
     */
    public function transfer(Request $request)
    {
        $this->validate($request, [
            'payer' => 'required|exists:users,id',
            'payee' => 'required|exists:users,id',
            'value' => 'required|numeric'
        ]);

        $payer = User::find($request->get('payer'));

        try {
            $payer->transfer($request);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }

        return response()->json(["message" => "Successful transfer!"], 201);

    }
}
