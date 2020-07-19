<?php

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run()
    {
        factory(Wallet::class,50)->create();
    }
}
