<?php

namespace App\Http\Controllers;


use App\User;

class TransactionController extends Controller
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
        $balance = auth()->user()->balance();

        $users = User::paginate(10);

        return view('transactions.index', compact('balance', 'users'));
    }
}
