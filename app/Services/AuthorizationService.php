<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class AuthorizationService
{
    public function getAuthorization(string $uuid)
    {
        $url = sprintf('%s/%s', config('app.url_transaction_authorization'), $uuid);

        return Http::get($url);
    }

    public function isAuthorized(string $uuid): bool
    {
        $response = $this->getAuthorization($uuid);

        $body = $response->json();

        return $response->status() === Response::HTTP_OK &&
            isset($body['message']) &&
            $body['message'] === 'Autorizado';
    }
}
