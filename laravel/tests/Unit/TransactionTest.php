<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    public function testTransactionFactory(): void
    {
        $transaction = factory(Transaction::class)->make();
        $this->assertTrue($transaction instanceof Transaction,
            "O objeto gerado não é uma instância da classe Transaction");
        $this->assertIsFloat($transaction->value, "O valor gerado não é Float.");
        $this->assertIsInt($transaction->payer_wallet_id, "O payer_wallet_id gerado não é Int.");
        $this->assertIsInt($transaction->payee_wallet_id, "O payee_wallet_id gerado não é Int.");
        $payer = $transaction->payerWallet->user;
        $this->assertNotNull($payer, "O pagante retornou NULL");
        $this->assertTrue($payer instanceof User, "O pagante não é uma instância da classe User");
        $payee = $transaction->payeeWallet->user;
        $this->assertNotNull($payee, "O receptor retornou NULL");
    }

    public function testTransactionSave(): void
    {
        $transaction = factory(Transaction::class)->make();
        $this->assertTrue($transaction->save(), "Não foi possível salvar no banco de dados");
    }

    public function testTransactionFetch(): void
    {
        $this->testTransactionSave();
        $transactionId = DB::getPdo()->lastInsertId();
        $transaction = Transaction::findOrFail($transactionId);
        $this->assertTrue($transaction instanceof Transaction,
            "O objeto gerado não é uma instância da classe Transaction");
        $this->assertIsFloat($transaction->value, "O valor gerado não é Float.");
        $this->assertIsInt($transaction->payer_wallet_id, "O payer_wallet_id gerado não é Int.");
        $this->assertIsInt($transaction->payee_wallet_id, "O payee_wallet_id gerado não é Int.");
        $payer = $transaction->payerWallet->user;
        $this->assertNotNull($payer, "O pagante retornou NULL");
        $this->assertTrue($payer instanceof User, "O pagante não é uma instância da classe User");
        $payee = $transaction->payeeWallet->user;
        $this->assertNotNull($payee, "O receptor retornou NULL");
    }

    public function testTransactionDelete(): void
    {
        $this->testTransactionSave();
        $transactionId = DB::getPdo()->lastInsertId();
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->delete();

        $transaction = Transaction::find($transactionId);
        $this->assertTrue(empty($transaction), "A transação ainda existe: " . var_export($transaction, true));
    }
}
