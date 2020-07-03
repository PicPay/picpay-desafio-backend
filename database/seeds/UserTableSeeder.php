<?php

use App\User;
use App\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    private $faker;

    private $fakerWalletBalances = [100.00, 8000.00, 750.50, 50.00, 10.00, 6400.00];

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function run()
    {
        factory(User::class, 3)->create()->each(function ($user) {
            $this->createWallet($user);
        });

        $userStore = User::create([
            'fullname' => "Picpay Store",
            'email' => 'store@picpay.com.br',
            'cnpj' => '63325789000170',
            'password' => Hash::make($this->faker->password()),
            'type' => 'store'
        ]);

        $this->createWallet($userStore);
    }

    /**
     * @param $user
     */
    private function createWallet($user): void
    {
        Wallet::create([
            'balance' => $this->faker->randomElement($this->fakerWalletBalances),
            'user_id' => $user->id
        ]);
    }
}
