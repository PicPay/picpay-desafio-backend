<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\UserHistory;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('user_history')->truncate();

        factory(User::class, 10)->create()->each(function ($user) {
            $history = factory(UserHistory::class)->make();
            $user->history()->save($history);
        });
        factory(User::class, 10)->state('company')->create()->each(function ($user) {
            $history = factory(UserHistory::class)->make();
            $user->history()->save($history);
        });
    }
}
