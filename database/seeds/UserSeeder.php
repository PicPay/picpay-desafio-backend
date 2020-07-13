<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\UserType;
use \App\Transaction;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertUsers();
        $this->insertTransactions();
    }

    private function insertUsers()
    {
        User::insert([
            [
                'name' => 'João da Silva',
                'user_type_id' => UserType::COMMON,
                'document' => '260.316.770-75',
                'email' => 'joao@gmail.com',
                'password' => bcrypt('admin123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Maria da Silva',
                'user_type_id' => UserType::COMMON,
                'document' => '859.672.740-06',
                'email' => 'maria@gmail.com',
                'password' => bcrypt('admin123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Loja do José',
                'user_type_id' => UserType::SHOPKEEPER,
                'document' => '22.297.533/0001-10',
                'email' => 'jose@loja.com',
                'password' => bcrypt('admin123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }

    private function insertTransactions()
    {
        $users = User::get();

        foreach ($users as $user) {
            Transaction::insert([
                [
                    'payee_id' => $user->id,
                    'value' => 1000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);
        }
    }
}
