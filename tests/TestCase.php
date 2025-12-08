<?php

namespace PicPay\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Mockery;
use Override;

abstract class TestCase extends BaseTestCase
{
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    #[Override]
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function httpFake(array $requests): void
    {
        Http::fake([
            ...$requests,
            '*' => Http::response('', Response::HTTP_NOT_FOUND),
        ]);
    }
}
