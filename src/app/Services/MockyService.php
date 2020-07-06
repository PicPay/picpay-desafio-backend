<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MockyService
{
    protected $endpoint;

    public function __construct()
    {
        $this->endpoint = config('mocky.host');
    }

    public function autorize()
    {
        try {
            $response = Http::get("{$this->endpoint}/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");
            $result = $response->json();
            return ($result['message'] == 'Autorizado') ? true : false;
        } catch (\Exception $e) {
            Log::error('Falha ao acessar o serviço Mocky');
            throw $e;
        }
    }

    public function notificate()
    {
        try {
            $response = Http::get("{$this->endpoint}/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04");
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Falha ao acessar o serviço Mocky');
            throw $e;
        }
    }
}