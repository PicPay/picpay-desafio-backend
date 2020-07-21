<?php

namespace App\Http\Controllers;

use App\Transactions;
use Carbon\Carbon;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
     * Returns the user's balance and transactions of the lasts 30 days.
     *
     * @return Renderable
     */
    public function index()
    {
        try{
            $transactions = Transactions::query()
                ->where('created_at', '>=', Carbon::now()->subDays(30))->where(function (Builder $query) {
                    $query->where('sender_id', Auth::user()->getAuthIdentifier())
                          ->orWhere('receiver_id', Auth::user()->getAuthIdentifier());
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }catch (\Exception $e){
            $transactions = [];
        }

        return view('home', compact('transactions'));
    }
}
