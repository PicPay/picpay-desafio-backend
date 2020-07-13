<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait NotificationTrait
{
    private function notify()
    {
        $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');

        if($response->ok()){
            $data = $response->json();

            return [
                'success' => true,
                'message' => $data['message']
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Erro ao enviar notificação'
            ];
        }
    }    
}