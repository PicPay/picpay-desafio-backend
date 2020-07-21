<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Services\NotificationService;

class NotificationServiceTest extends TestCase
{
    public function testMustNotify()
    {
        Http::fake();

        $user = factory(User::class)->make();

        $notificationService = new NotificationService();

        $notificationService->sendNotification($user, 'foo-test');

        Http::assertSent(function ($request) use ($user) {
            return $request['user_id'] === $user->id && $request['message'] === 'foo-test';
        });
    }
}
