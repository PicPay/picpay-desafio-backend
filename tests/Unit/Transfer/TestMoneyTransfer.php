<?php

namespace Tests\Unit\Transfer;

use Tests\TestCase;

class TestMoneyTransfer extends TestCase
{
    public function testMoneyTransfer(): void
    {
        $this->withoutExceptionHandling();
        $data = [
            "value" => 100.00,
            "payer_id" => 1,
            "payee_id" => 2
        ];
        $response = $this->postJson('/api/transfer', $data);
        $response->assertOk();
        $this->assertDatabaseCount('transfer', 1);
        $data['authorization_status']=1;
        $this->assertDatabaseHas('transfer', $data);
    }
}
