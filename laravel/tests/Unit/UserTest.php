<?php

namespace Tests\Unit;

use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserFactory(): void
    {
        $user = factory(User::class)->make();
        $this->assertTrue($user instanceof User, "O objeto gerado não é uma instância da classe User");
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

    public function testUserSave(): void
    {
        $user = factory(User::class)->make();
        $this->assertTrue($user->save(), "Não foi possível salvar no banco de dados");
    }

    public function testUserFetch(): void
    {
        $this->testUserSave();
        $userId = DB::getPdo()->lastInsertId();
        $user = User::findOrFail($userId);
        $this->assertTrue($user instanceof User, "O objeto gerado não é uma instância da classe User");
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

    public function testUserDelete(): void
    {
        $this->testUserSave();
        $userId = DB::getPdo()->lastInsertId();
        $user = User::findOrFail($userId);
        $user->delete();

        $user = User::find($userId);
        $this->assertTrue(empty($user), "O usuário ainda existe: " . var_export($user, true));
    }
}
