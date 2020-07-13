<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait VerifyTransactionTrait
{
    private function verify()
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        if($response->ok()){
            $data = $response->json();

            return [
                'success' => true,
                'message' => $data['message']
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Erro ao verificar a transação.'
            ];
        }
    }    
}