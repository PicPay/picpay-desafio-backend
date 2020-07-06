<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Entities\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jonathan Xavier Ribeiro',
            'document' => '11.222.333/0001-44',
            'email' => 'jonathanxribeiro@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('xavier'),
            'balance' => 1000.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faker = \Faker\Factory::create();

        factory(User::class, 10)
            ->create()
            ->each(function ($user) use ($faker) {
                User::first()->transactions()->attach($user, [
                    'value' => $faker->randomFloat(5, 0, 20),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }
}
