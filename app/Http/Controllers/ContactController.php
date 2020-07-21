<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
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
     * List the contacts available to send.
     *
     * @return Renderable
     */
    public function contacts()
    {
        return view('contacts');
    }

    /**
     * Add a new contact.
     *
     * @param Request $request
     * @return mixed
     */
    public function newContact(Request $request)
    {
        if($request->get('document')){
            try{
                if($user = User::query()->where('document', preg_replace( '/[^0-9]/', '', $request->get('document')))->where('id', '!=', Auth::user()->getAuthIdentifier())->first()){
                    if(Auth::user()->contacts()->where('user_contact_id', $user->getAttribute('id'))->count() > 0)
                        return Redirect::back()->withErrors(['document' => "Este contato já está vinculado."]);

                    Auth::user()->contacts()->create([
                        'user_id' => Auth::user()->getAuthIdentifier(),
                        'user_contact_id' => $user->getAttribute('id')
                    ]);

                    return Redirect::to(route('contacts'))->with(['status' => "Contato adicionado com sucesso"]);

                }
                return Redirect::back()->withErrors(['document' => "Não encontramos nenhum registro pra este CPF/CNPJ"]);
            }catch (\Exception $e){
                return Redirect::back()->withErrors(['document' => "Um erro ocorreu! Revise os dados e tente novamente."]);
            }
        }

        return view('new-contact');
    }
}
