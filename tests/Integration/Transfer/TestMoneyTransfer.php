<?php

namespace Tests\Integration\Transfer;

use App\Models\Users\Users;
use Tests\TestCase;

class TestMoneyTransfer extends TestCase
{
    public function testMoneyTransfer(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            "value" => 100.20,
            "payer_id" => 1,
            "payee_id" => 2
        ];

        //build comparison data
        $payer = Users::find($data['payer_id']);
        $payee = Users::find($data['payee_id']);

        $currentPayerWallet=$payer->wallet_amount;
        $currentPayeeWallet=$payee->wallet_amount;

        //make request
        $response = $this->postJson(route('transaction'), $data);

        //validate status code
        $response->assertOk();

        $transfer=$response->decodeResponseJson();

        //validate transfer
        $data['id'] = $transfer['transfer']['id'];
        $data['authorization_status']=1;
        $data['processed']=1;
        $this->assertDatabaseHas('transfer', $data);

        //validate if money was deducted from payer wallet
        $dataPayer['id'] = $data['payer_id'];
        $dataPayer['wallet_amount'] = $currentPayerWallet - $data['value'];
        $this->assertDatabaseHas('users', $dataPayer);

        //validate if money was added to payee wallet
        $dataPayee['id'] = $data['payee_id'];
        $dataPayee['wallet_amount'] = $currentPayeeWallet + $data['value'];
        $this->assertDatabaseHas('users', $dataPayee);

        //validate notification sent
        $dataNotification['transfer_id'] = $transfer['transfer']['id'];
        $dataNotification['status'] = 1;
        $this->assertDatabaseHas('notification', $dataNotification);

    }

    public function testMoneyTransferInvalidArguments(): void
    {
        //no value
        $data = [
            "payer_id" => 1,
            "payee_id" => 2
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //no payer
        $data = [
            "value" => 100.00,
            "payee_id" => 2
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //no payee
        $data = [
            "value" => 100.00,
            "payer_id" => 1,
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //payer does not exist
        $data = [
            "payer_id" => 100,
            "payee_id" => 2,
            "value" => 100.00,
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //payee does not exist
        $data = [
            "payer_id" => 1,
            "payee_id" => 200,
            "value" => 100.00,
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //value is not a valid number
        $data = [
            "payer_id" => 1,
            "payee_id" => 2,
            "value" => "100,10",
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //no amount being transferred
        $data = [
            "payer_id" => 1,
            "payee_id" => 2,
            "value" => 0,
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //payer is not a common user
        $data = [
            "payer_id" => 2,
            "payee_id" => 1,
            "value" => 100,
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);

        //payer is trying to transfer a larger amount than is available is his wallet
        $data = [
            "payer_id" => 1,
            "payee_id" => 2,
            "value" => 2000000000.40,
        ];
        $response = $this->postJson(route('transaction'), $data);
        $response->assertStatus(422);
    }


}
