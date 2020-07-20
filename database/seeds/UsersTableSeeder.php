<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'user_id' => 1,
                'name' => 'Eduardo',
                'email' => 'edu_ls@teste.com',
                'password' => '',
                'document' => '35579377800',
                'is_shopkeeper' => 0,
                'credit_balance' => '1000.00',
                'creation_date' => '2020-07-18 21:53:20',
            ),
            1 => 
            array (
                'user_id' => 2,
                'name' => 'Loja Kuka',
                'email' => 'kuka.b@teste.com',
                'password' => '',
                'document' => '84095065000158',
                'is_shopkeeper' => 1,
                'credit_balance' => '1402.00',
                'creation_date' => '2020-07-18 21:57:15',
            ),
            2 => 
            array (
                'user_id' => 3,
                'name' => 'Maria',
                'email' => 'maria.d@teste.com',
                'password' => '',
                'document' => '51450060048',
                'is_shopkeeper' => 0,
                'credit_balance' => '5.00',
                'creation_date' => '2020-07-18 03:42:20',
            ),
        ));
        
        
    }
}