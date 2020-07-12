<?php

use Illuminate\Database\Seeder;

use App\Models\User\CommonUser;
use App\Models\User\ShopkeeperUser;
use App\Models\User\UsersWallet;
use App\Models\User\User;
use Illuminate\Support\Facades\Schema;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanUp();

        $this->createCommonUsers();

        $this->createShopkeeperUser();
    }
    
    /**
     * Erasing tables
     *
     * @return void
     */
    private function cleanUp(): void
    {
        ShopkeeperUser::truncate();
        CommonUser::truncate();
        UsersWallet::truncate();

        Schema::disableForeignKeyConstraints();
        User::query()->delete();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Alias for CommonUser factory
     *
     * @return void
     */
    private function createCommonUsers(): void
    {
        factory(CommonUser::class, 2)
            ->create();
    }

    /**
     * Alias for Shopkeeper factory
     *
     * @return void
     */
    private function createShopkeeperUser(): void
    {
        factory(ShopkeeperUser::class)
            ->create();
    }
}
