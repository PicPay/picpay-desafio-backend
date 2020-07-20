<?php
namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Jobs\UserNotification;
use GuzzleHttp\Psr7\Response;
use Kozz\Laravel\Facades\Guzzle;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserNotificationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function handle(){
        $notifications = [
            [
                'user_id' => 1,
                'message' => 'Transferencia realizada com sucesso'
            ],
            [
                'user_id' => 2,
                'message' => 'Transferencia recebida'
            ]
        ];

        Guzzle::shouldReceive('POST')
        ->once()
        ->andReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode(['message' => 'Enviado'])));

        $job = new UserNotification($notifications);
        $job->handle();

    }

}