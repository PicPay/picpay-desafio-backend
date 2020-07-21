<?php

namespace Tests\Feature;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * A basic test of the transaction routine.
     *
     * @return void
     */
    public function testTransaction()
    {
        $user = factory(User::class)->create();
        $user->setAttribute('wallet', $this->rand());
        $value = $this->rand();
        $params = ['_token' => csrf_token(), 'value' => $value, 'payee' => User::query()->where('id', '!=', $user->id)->get()->random()->id];

        $user->setAttribute('type', 1);
        $response = $this->actingAs($user)->post(route("transaction"), $params);

        if($user->getAttribute('wallet') >= $value){
            $this->assertTrue(json_decode($response->getContent())->success);
        }else{
            $this->assertFalse(json_decode($response->getContent())->success);
        }

        $user->setAttribute('type', 2);
        $response = $this->actingAs($user)->post(route("transaction"), $params);
        $this->assertFalse(json_decode($response->getContent())->success);
    }


    /**
     * A basic test of the transaction API.
     *
     * @return void
     */
    public function testTransactionApi()
    {
        /** Doesn't check SSL because the application runs locally */
        $client = new Client(['verify' => false]);
        $response = $client->post(env("MOCK_TRANSACTION"), [
            'form_params' => [
                'value' => $this->rand(),
                'payer' => $this->rand(),
                'payee' => $this->rand(),
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());
        $this->assertContains("Autorizado", $response->message);

    }

    /**
     * Returns a random integer.
     *
     * @return int
     */
    public function rand(){
        return mt_rand(0, 200);
    }
}
