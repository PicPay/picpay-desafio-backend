<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use App\Models\User\CommonUser;
use App\Models\User\ShopkeeperUser;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Alias for Common user factory
     *
     * @param array $data
     * @param integer $amount
     * @param string $method
     * @return CommonUser
     */
    public function createCommonUser(array $data = [], string $method = "create"): CommonUser
    {
        return \factory(CommonUser::class)->$method($data);
    }

    /**
     * Alias for Shopkeeper factory
     *
     * @param array $data
     * @param integer $amount
     * @param string $method
     * @return ShopkeeperUser
     */
    public function createShopKeeper(array $data = [], string $method = "create"): ShopkeeperUser
    {
        return \factory(ShopkeeperUser::class)->$method($data);
    }

    public function removeDateFields(array &$data): void
    {
        unset($data["created_at"]);
        unset($data["updated_at"]);
    }
}
