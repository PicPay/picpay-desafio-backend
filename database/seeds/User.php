<?php

use App\User as AppUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        //random create new users with 50/50 probability to be merchant or normal user
        for ($i = 0; $i < 50; $i++) {
            $isMerchant = rand(0, 1) === 1;
            do {
                $user = AppUser::create([
                    'name' => $faker->name(),
                    'email' => $faker->email(),
                    'is_merchant' => $isMerchant,
                    'document' =>  $isMerchant ?
                        $faker->numberBetween(10000000000000, 999999999999999) :
                        $faker->numberBetween(10000000000, 99999999999),
                    'password' => Hash::make($faker->password()),
                ]);
            }while( !$user );
        }

        //ensure user 4 and 15 has right profiles for test
        $user4  = AppUser::find(4);
        $user4->is_merchant = 0;
        $user4->save();

        $user15 = AppUser::find(15);
        $user15->is_merchant = 1;
        $user15->save();
    }
}
