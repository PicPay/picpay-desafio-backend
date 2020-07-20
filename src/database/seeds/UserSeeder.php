<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Wallet;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i < 50; $i++){
            $faker = Faker::create();

            $userData = User::create([
                "name" => $faker->name,
                "email" =>  $faker->safeEmail,
                "cpf" => $faker->numberBetween(10000000000, 99999999999),
                "password" => Hash::make('teste123')
            ]);
    
            Wallet::create([
                'user_id' => $userData->id,
                'wallet_type' => $faker->numberBetween(1,2),
                'balance' => $faker->randomNumber()
            ]);

        }
    }
}
