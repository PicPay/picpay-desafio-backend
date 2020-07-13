<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {
            $createCompany = $i % 5 === 0;
            $createCompany
                ? factory('App\Models\User')->state('company')->create()
                : factory('App\Models\User')->create();
        }
    }
}
