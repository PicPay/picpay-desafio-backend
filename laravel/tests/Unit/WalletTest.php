<?php

namespace Tests\Unit;

use App\Enums\WalletTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use DatabaseMigrations;

    private function assertInstance($wallet): void
    {
        $this->assertTrue($wallet instanceof Wallet, "Não é uma instância de Wallet");
        $this->assertIsFloat($wallet->balance, "O saldo não é Float.");
        $this->assertIsInt($wallet->user_id, "O id de usuário não é Inteiro.");
        $this->assertTrue(in_array($wallet->type, WalletTypeEnum::getConstants()), "Tipo de carteira inválido.");
        $owner = $wallet->user;
        $this->assertTrue($owner instanceof User, "O dono da carteira não é uma instância de Wallet.");
    }

    public function testFactory(): void
    {
        $this->assertInstance(factory(Wallet::class)->create());
    }

    public function testSave(): void
    {
        $wallet = factory(Wallet::class)->create();
        $this->assertTrue($wallet->save(), "Não foi possível salvar no banco de dados.");
    }

    public function testFetch(): void
    {
        $this->testSave();
        $wallet = Wallet::findOrFail(DB::getPdo()->lastInsertId());
        $this->assertInstance($wallet);
    }

    public function testDelete(): void
    {
        $this->testSave();
        $id = DB::getPdo()->lastInsertId();
        $wallet = Wallet::findOrFail($id);
        $this->assertTrue($wallet->delete(), "Não foi possível excluir do banco de dados.");
        $wallet = Wallet::find($id);
        $this->assertTrue(empty($wallet), "A carteira ainda existe: " . var_export($wallet, true));
    }
}
