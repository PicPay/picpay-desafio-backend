<?php

declare(strict_types=1);

namespace PicPay\Tests\Debugging;

use Illuminate\Support\Facades\Artisan;
use PicPay\Tests\TestCase;

/**
 * Use this test to debug artisan commands during development.
 * Xdebug may not work properly with artisan commands,
 * so running them through a test is a good workaround.
 */
class CommandTest extends TestCase
{
    public function test_the_command_to_debug(): void
    {
        $this->withoutMockingConsoleOutput();

        Artisan::call('command', []);

        $output = Artisan::output();

        $this->assertStringNotContainsString('Error', trim($output));
    }
}
