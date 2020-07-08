<?php

use App\User;
use App\Wallet;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');
    	foreach (range(1,5) as $index) {
	        $user = User::create([
	            'name' => $faker->name,
                'cpf_cnpj' => $faker->cpf(false),
                'balance' => $faker->randomFloat(2,0,2000),
                'email' => $faker->email,
                'type' => User::TYPE_USER,
	            'password' => Hash::make($faker->password),
            ]);

	        $user = User::create([
	            'name' => $faker->name,
                'cpf_cnpj' => $faker->cnpj(false),
                'balance' => $faker->randomFloat(2,0,2000),
                'email' => $faker->email,
                'type' => User::TYPE_STORE,
	            'password' => Hash::make($faker->password),
	        ]);
	    }
    }
}
