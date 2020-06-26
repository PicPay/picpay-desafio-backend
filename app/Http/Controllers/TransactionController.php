<?php

namespace App\Http\Controllers;

use App\Events\TransactionEvent;
use App\Http\Requests\TransactionRequest;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        //
    }

    public function execute(Request $req)
    {
        //cast necessary to make integration tests on Lumen (Bug on 7.2)
        //https://github.com/laravel/lumen-framework/issues/1100
        $request = castObject( $req, new TransactionRequest());
        $params = $request->all();

        //validate request params and validate user
        $this->validate($request, $request->rules(), $request->messages() );

        $params = $request->all();

        $payer = User::find($params['payer']);
        $payee = User::find($params['payee']);

        $event = new TransactionEvent( $payer, $payee, $params['value'] );
        event( $event );

        if( $event->isFailed() ) {
            return response([
                'failed' => 1,
                'error'  => $event->getError()
            ], 403 );
        }

        $event->done();

        return [
            'message' => "Done"
        ];

    }
}
