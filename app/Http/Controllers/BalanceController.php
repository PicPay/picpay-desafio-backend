<?php

namespace App\Http\Controllers;

use App\User;
use App\Balance;
use Illuminate\Http\Request;
use App\Http\Requests\MoneyValidationFormRequest;

class BalanceController extends Controller
{
    public function index()
    {
        $balance = auth()->user()->balance;
        $amount = $balance ? $balance->amount : 0;

        return view('balance.index', compact('amount'));
    }

    public function deposit()
    {
        return view('balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->deposit($request->value);

        if($response['success']){
            return redirect()->route('balance.index')->with('success', $response['message']);
        }

        return redirect()->back()->with('error', $response['message']);
    }

    public function withdraw()
    {
        return view('balance.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->withdraw($request->value);

        if($response['success']){
            return redirect()->route('balance.index')->with('success', $response['message']);
        }

        return redirect()->back()->with('error', $response['message']);
    }

    public function transfer()
    {
        if( strlen(auth()->user()->cpf_cnpj) > 14 ){
            return redirect()->route('balance.index')->with('error', 'Lojista não pode fazer transferência.');    
        }

        return view('balance.transfer');
    }

    public function confirmTransfer(Request $request, User $user)
    {
        if( strlen(auth()->user()->cpf_cnpj) > 14 ){
            return redirect()->route('balance.index')->with('error', 'Lojista não pode fazer transferência.');    
        }
        
        $sender = $user->getSender($request->sender);

        if(!$sender){
            return redirect()
                    ->back()
                    ->with('error', 'Usuário informado não encontrado.');
        }

        if ($sender->id === auth()->user()->id) {
            return redirect()
                    ->back()
                    ->with('error', 'Não pode transferir para você mesmo.');
        }

        $balance = auth()->user()->balance;

        return view('balance.transfer-confirm', compact('sender', 'balance'));
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {
        $sender = $user->find($request->sender_id);
        if(!$sender){
            return redirect()->route('balance.transfer')->with('error', 'Recebedor não encontrado.');
        }

        $balance = auth()->user()->balance()->firstOrCreate([]);
        $response = $balance->transfer($request->value, $sender);

        if($response['success']){
            return redirect()->route('balance.index')->with('success', $response['message']);
        }

        return redirect()->route('balance.transfer')->with('error', $response['message']);
    }
}
