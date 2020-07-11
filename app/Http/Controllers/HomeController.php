<?php

namespace App\Http\Controllers;

use App\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->id();

        $balance = auth()->user()->balance();

        $transactions = Transaction::with(['payer', 'payee'])
            ->where('payer_id', $user_id)
            ->orWhere('payee_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('home', compact('user_id', 'balance', 'transactions'));
    }
}
