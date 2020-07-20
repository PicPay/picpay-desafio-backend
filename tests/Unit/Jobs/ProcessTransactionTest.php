<?php
namespace Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserHistory;
use App\Models\Transaction;
use App\Jobs\ProcessTransaction;
use App\Events\ReceiveTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;

use GuzzleHttp\Psr7\Response;
use Kozz\Laravel\Facades\Guzzle;

class ProcessTransactionTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function handle(){
        Queue::fake();

        $transaction = new Transaction;
        $transaction->payer = 1;
        $transaction->payee = 2;
        $transaction->value = 1.00;
        $transaction->save();

        Guzzle::shouldReceive('POST')
        ->once()
        ->andReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode(['message' => 'Autorizado'])));

        $job = new ProcessTransaction($transaction);
        $job->handle();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'COMPLETED'
        ]);
    }

    /**
     * @test
     */
    public function handleAuthFailed(){
        
        Queue::fake();

        $transaction = new Transaction;
        $transaction->payer = 1;
        $transaction->payee = 2;
        $transaction->value = 1.00;
        $transaction->save();

        Guzzle::shouldReceive('POST')
        ->once()
        ->andReturn(new Response(400, ['Content-Type' => 'application/json'], json_encode(['message' => 'Não Autorizado'])));
        
        $job = new ProcessTransaction($transaction);
        $job->handle();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'REJECT'
        ]);
    }

    /**
     * @test
     */
    public function handleQueedNotification(){

        Queue::fake();

        $transaction = new Transaction;
        $transaction->payer = 1;
        $transaction->payee = 2;
        $transaction->value = 1.00;
        $transaction->save();

        Guzzle::shouldReceive('POST')
        ->once()
        ->andReturn(new Response(200, ['Content-Type' => 'application/json'], json_encode(['message' => 'Autorizado'])));

        $job = new ProcessTransaction($transaction);
        $job->handle();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'COMPLETED'
        ]);

        Queue::assertPushed(\App\Jobs\UserNotification::class);
    }

}