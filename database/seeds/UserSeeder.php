<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        App\Models\User::insert([
            factory(App\Models\User::class)->make()->toArray(),
            factory(App\Models\User::class)->make()->toArray(),
            factory(App\Models\User::class)->state('shopkeeper')->make()->toArray()
        ]);
    }
}
