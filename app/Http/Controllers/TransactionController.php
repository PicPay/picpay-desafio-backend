<?php

namespace App\Http\Controllers;

use App\Transactions;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
     * Returns details of transaction.
     *
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        if(!$transaction = Transactions::query()->find($id))
            return Redirect::route('home');

        if($transaction->received() && !boolval($transaction->getAttribute('read')))
            $transaction->setAttribute('read', (int)true)->save();

        return view('transaction', compact('transaction'));
    }

    /**
     * Form to send transaction.
     *
     * @param $contact
     * @return mixed
     */
    public function send($contact)
    {
       if(!$user = User::query()->find($contact))
           return Redirect::route('contacts');

       return view('send', ['contact' => $user]);
    }

    /**
     * Calls the transaction.
     *
     * @param Request $request
     * @param $payee
     * @return mixed
     */
    public function call(Request $request, $payee)
    {
        $request->merge(['payee' => $payee]);
        $response = $this->transaction($request);

        if($response["success"])
            return Redirect::route('home')->with(['status' => 'Transferência realizada com sucesso!']);

        return Redirect::back()->withErrors(['transaction' => $response['error']]);

    }

    /**
     * Make the transaction.
     *
     * @param Request $request
     * @return array
     */
    public function transaction(Request $request)
    {
        try{
            if(Auth::user()->type != User::default)
                return $this->return('Ação não permitida para este tipo de usuário!');

            $value = (double) str_replace(",", ".", $request->get('value'));

            /** Check if the user has the value to send */
            if($value > Auth::user()->wallet)
                return $this->return('O valor da transferência não pode ser maior que R$ '. Auth::user()->wallet());

            /** Doesn't check SSL because the application runs locally */
            $client = new Client(['verify' => false]);
            $response = $client->post(env("MOCK_TRANSACTION"), [
                'form_params' => [
                    'value' => $value,
                    'payer' => Auth::user()->getAuthIdentifier(),
                    'payee' => $request->get('payee'),
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());

            /** Uses string to compare because the service of transaction doesn'r return a number code */
            $authorized = $response->message == "Autorizado";
            $transaction = new Transactions(
                ['sender_id' => Auth::user()->getAuthIdentifier(), 'receiver_id' => $request->get('payee'), 'value' => $value, "authorized" => (int)$authorized]
            );

            $transaction->save();

            /** If se the service authorizes the transaction make the transfer */
            if(boolval($transaction->getAttribute("authorized"))){
                $receiver = User::query()->find($request->get('payee'));

                /** Adds the value on the receiver's balance */
                $receiver->setAttribute('wallet', $receiver->wallet + $value)->save();

                /** Subtracts the value on the sender's balance (current user) */
                Auth::user()->setAttribute('wallet',  Auth::user()->wallet - $value)->save();

                return $this->return();
            }

            return $this->return('Transação reprovada! Revise os dados e tente novamente.');
        }catch (\Exception $e){
            //return $this->return('Um erro ocorreu! Revise os dados e tente novamente.');
            return $this->return($e->getMessage());
        }
    }

    public function return($error = null){
        return ["success" => empty($error), "error" => $error];
    }
}
