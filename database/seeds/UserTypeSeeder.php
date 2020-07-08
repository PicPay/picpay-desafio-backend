<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_type')->insert(
            [
                'type' => 'client',
            ]
        );

        DB::table('user_type')->insert(
            [
                'type' => 'shop_owner',
            ]
        );
    }
}
