<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Guzzle;

class ThirdPartAuthService{

    private $url;
    Private $data;

    public function __construct($data){
        $this->url = env('AUTH_URL', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        $this->data = $data;
    }

    public function authTransaction(){
        try {
            $response = Guzzle::post($this->url,['body' => json_encode($this->data)]);
            $body = json_decode($response->getBody()->getContents());

            if ($response->getStatusCode() != 200 || $body->message != 'Autorizado') {
                return false;
            }

            return true;
        } catch (GuzzleException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}