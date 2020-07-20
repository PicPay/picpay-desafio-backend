<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\GuzzleException;
use Guzzle;

class ThirdPartNotificationService{

    private $url;
    Private $data;

    public function __construct($data){
        $this->url = env('NOTIFY_URL', 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        $this->data = $data;
    }

    public function userNotification(){
        try {
            $response = Guzzle::post($this->url,['body' => json_encode($this->data)]);
            $body = json_decode($response->getBody()->getContents());

            if ($response->getStatusCode() != 200 || $body->message != 'Enviado') {
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