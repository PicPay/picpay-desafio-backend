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
        $user = auth()->user();

        $balance = $user->balance();

        $can_pay = $user->canPay();

        $transactions = Transaction::with(['payer', 'payee'])
            ->where('payer_id', $user->id)
            ->orWhere('payee_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('home', compact('user', 'balance', 'can_pay', 'transactions'));
    }
}
