<?php

namespace Tests\Unit\Transfer;

use App\Events\Transfer\TransferCancelled;
use App\Models\Transfer\Transfer;
use Tests\TestCase;

class TestCancelledTransferEvent extends TestCase
{
    public function testMoneyTransferCancelled(): void
    {
        $transfer=Transfer::find(3);
        event(new TransferCancelled($transfer));
        $data = [
            'id' => 2,
            "wallet_amount" => 0,
        ];

        $this->assertDatabaseHas('users', $data);

        $dataTransfer = [
            'id' => 3,
            "cancelled" => 1,
        ];

        $this->assertDatabaseHas('transfer', $dataTransfer);
    }

}
