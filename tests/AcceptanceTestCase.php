<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class AcceptanceTestCase extends BaseTestCase
{
    protected static $migrationsRun = false;

    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();

        DB::beginTransaction();

        if (! static::$migrationsRun) {
            Artisan::call('migrate');
            static::$migrationsRun = true;
        }
    }

    public function tearDown(): void
    {
        $this->beforeApplicationDestroyed(function () {
            DB::rollback();
            DB::disconnect();
        });

        parent::tearDown();

        Mockery::close();
    }
}
