<?php

use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all()->toArray();
        foreach ($users as $user) {
            \App\Models\Wallet::insert(
                factory(App\Models\Wallet::class)->make([
                    'user_id' => $user['id']
                ])->toArray()
            );
        }
    }
}
