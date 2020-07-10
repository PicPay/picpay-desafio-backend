<?php

namespace Tests\Unit\Transfer;

use App\Events\Transfer\TransferAuthorized;
use App\Models\Transfer\Transfer;
use Tests\TestCase;

class TestTransferAuthorizedEvent extends TestCase
{
    public function testMoneyTransferAuthorized(): void
    {
        $transfer=Transfer::find(1);
        event(new TransferAuthorized($transfer));
        $data = [
            'id' => 2,
            "wallet_amount" => 100.20,
        ];

        $this->assertDatabaseHas('users', $data);

        $dataTransfer = [
            'id' => 1,
            "processed" => 1,
        ];

        $this->assertDatabaseHas('transfer', $dataTransfer);
    }

    public function testMoneyTransferUnAuthorized(): void
    {
        $transfer=Transfer::find(2);
        event(new TransferAuthorized($transfer));
        $data = [
            'id' => 2,
            "wallet_amount" => 100.20,
        ];

        $this->assertDatabaseHas('users', $data);

        $dataTransfer = [
            'id' => 2,
            "processed" => 0,
        ];

        $this->assertDatabaseHas('transfer', $dataTransfer);
    }

}
