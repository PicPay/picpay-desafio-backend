<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiRepository
{
    /**
     * Connect API
     *
     * @param $uri
     * @param $params
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function connect($uri, $params)
    {
        $client = new Client();

        try {
            $result = $client->post($uri, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'form_params' => $params,
                'timeout' => 10,
                'connect_timeout' => 10,
            ]);

            if ($result) {
                $result = json_decode($result->getBody()->getContents(), true);

                if ($result) {
                    return $result;
                }
            }

            return [];
        } catch (RequestException $e) {
            logger()->error((string)$e);

            return [];
        }
    }
}
