<?php
namespace Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Queue;

class TransactionsControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
    */
    public function receiveValidData(){
        Queue::fake();

        factory(User::class, 2)->create()->each(function ($user){
            $users[] = $user->id;
            $history = new UserHistory();
            $history->user_id = $user->id;
            $history->amount = 10;
            $history->date = now();
            $user->history()->save($history);
        });


        $payload = [
            "value" => 1.00,
            "payer" => 1,
            "payee" => 2
        ];

        $response = $this->postJson('/api/transaction', $payload);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Transação recebida',
            ]);
    }

    /**
     * @test
    */
    public function receiveTransferFromCompany(){
        Queue::fake();

        factory(User::class, 1)->state('company')->create()->each(function ($user) {
            $users[] = $user->id;
            $history = new UserHistory();
            $history->user_id = $user->id;
            $history->amount = 10;
            $history->date = now();
            $user->history()->save($history);
        });

       factory(User::class, 1)->create()->each(function ($user) {
            $history = new UserHistory();
            $history->user_id = $user->id;
            $history->amount = 10;
            $history->date = now();
            $user->history()->save($history);
        });

        $payload = [
            "value" => 1.00,
            "payer" => 1,
            "payee" => 2
        ];

        $response = $this->postJson('/api/transaction', $payload);

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'Empresas não podem realizar transações',
            ]);
    }

    /**
     * @test
    */
    public function receiveTransferFromUserWithoutAmount(){
        Queue::fake();

        factory(User::class, 2)->create()->each(function ($user) {
            $users[] = $user->id;
            $history = new UserHistory();
            $history->user_id = $user->id;
            $history->amount = 1;
            $history->date = now();
            $user->history()->save($history);
        });

        $payload = [
            "value" => 2.00,
            "payer" => 1,
            "payee" => 2
        ];

        $response = $this->postJson('/api/transaction', $payload);

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'Usuário não tem saldo para realizar transação',
            ]);
    }

}