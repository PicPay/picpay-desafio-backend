<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Usuário Comum',
            'email' => 'usuario@exemplo.com',
            'cpf_cnpj' => '365.252.610-40',
            'password' => bcrypt('12345678'),
            // 'image' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Loja',
            'email' => 'loja@exemplo.com',
            'cpf_cnpj' => '13.091.870/0001-65',
            'password' => bcrypt('12345678'),
            // 'image' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
