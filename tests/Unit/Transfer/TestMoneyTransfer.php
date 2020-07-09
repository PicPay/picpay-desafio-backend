<?php

namespace Tests\Unit\Transfer;

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
        $response = $this->postJson('/api/transfer', $data);
        $response->assertOk();
        $data['authorization_status']=1;
        $this->assertDatabaseHas('transfer', $data);
    }

    public function testMoneyTransferInvalidArguments(): void
    {
        //no value
        $data = [
            "payer_id" => 1,
            "payee_id" => 2
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //no payer
        $data = [
            "value" => 100.00,
            "payee_id" => 2
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //no payee
        $data = [
            "value" => 100.00,
            "payer_id" => 1,
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //payer does not exist
        $data = [
            "payer_id" => 100,
            "payee_id" => 2,
            "value" => 100.00,
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //payee does not exist
        $data = [
            "payer_id" => 1,
            "payee_id" => 200,
            "value" => 100.00,
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //value is not a valid number
        $data = [
            "payer_id" => 1,
            "payee_id" => 2,
            "value" => "100,10",
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //no amount being transferred
        $data = [
            "payer_id" => 1,
            "payee_id" => 2,
            "value" => 0,
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //payer is not a common user
        $data = [
            "payer_id" => 2,
            "payee_id" => 1,
            "value" => 100,
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);

        //payer is trying to transfer a larger amount than what is available is his wallet
        $data = [
            "payer_id" => 1,
            "payee_id" => 2,
            "value" => 100.40,
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertStatus(422);
    }


}
