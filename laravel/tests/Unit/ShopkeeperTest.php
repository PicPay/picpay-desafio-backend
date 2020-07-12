<?php

namespace Tests\Unit;

use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;
use App\Models\Shopkeeper;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ShopkeeperTest extends TestCase
{
    use DatabaseMigrations;

    public function testShopkeeperFactory(): void
    {
        $user = factory(Shopkeeper::class)->make();
        $this->assertTrue($user instanceof Shopkeeper, "O objeto gerado não é uma instância da classe Shopkeeper");
        $this->assertIsString($user->name, "O nome gerado não é String.");
        $this->assertIsString($user->email, "O e-mail gerado não é String");
        $this->assertIsString($user->identity, "A identificação não é String");
        $this->assertTrue(
            PersonTypeEnum::isValid($user->type),
            "type inválido: {$user->type}"
        );
        $this->assertTrue(
            PersonStatusEnum::isValid($user->status),
            "status inválido: {$user->status}"
        );
        $this->assertTrue(
            PersonIdentityTypeEnum::isValid($user->identity_type),
            "identity_type inválido: {$user->identity_type}"
        );
    }

    public function testShopkeeperSave(): void
    {
        $user = factory(Shopkeeper::class)->make();
        $this->assertTrue($user->save(), "Não foi possível salvar no banco de dados");
    }

    public function testShopkeeperFetch(): void
    {
        $this->testShopkeeperSave();
        $userId = DB::getPdo()->lastInsertId();
        $user = Shopkeeper::findOrFail($userId);
        $this->assertTrue($user instanceof Shopkeeper, "O objeto gerado não é uma instância da classe Shopkeeper");
        $this->assertIsString($user->name, "O nome gerado não é String.");
        $this->assertIsString($user->email, "O e-mail gerado não é String");
        $this->assertIsString($user->identity, "A identificação não é String");
        $this->assertTrue(
            PersonTypeEnum::isValid($user->type),
            "type inválido: {$user->type}"
        );
        $this->assertTrue(
            PersonStatusEnum::isValid($user->status),
            "status inválido: {$user->status}"
        );
        $this->assertTrue(
            PersonIdentityTypeEnum::isValid($user->identity_type),
            "identity_type inválido: {$user->identity_type}"
        );
    }

    public function testShopkeeperDelete(): void
    {
        $this->testShopkeeperSave();
        $userId = DB::getPdo()->lastInsertId();
        $user = Shopkeeper::findOrFail($userId);
        $user->delete();

        $user = Shopkeeper::find($userId);
        $this->assertTrue(empty($user), "O usuário ainda existe: " . var_export($user, true));
    }
}
