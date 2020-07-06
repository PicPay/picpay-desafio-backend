<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    protected $postLink = 'api/users';

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        DB::rollback();
        parent::tearDown();
    }

    public function testUserCreate()
    {
        $data = factory(User::class)->make([
            'cpf_cnpj' => '12345678901'
        ])->toArray();

        $response = $this->postJson($this->postLink, $data);

        unset($data['email_verified_at']);

        $response->assertJson([
            'data' => $data,
            'message' => __('messages.userCreateSuccess'),
            'success' => true,
            'statusCode' => 200
        ]);
    }

    public function testUserCreateUniqueError()
    {
        $data = factory(User::class)->make()->toArray();

        $this->postJson($this->postLink, $data);
        $response = $this->postJson($this->postLink, $data);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => ['The Email has already been taken.'],
                'cpf_cnpj' => ['The CPF/CNPJ has already been taken.'],
            ]
        ]);
    }

    public function testUserUpdate()
    {
        $cpfcnpj = '12345678901';
        $data = factory(User::class)->make([
            'cpf_cnpj' => $cpfcnpj
        ])->toArray();

        $this->postJson($this->postLink, $data);

        $id = User::where('cpf_cnpj', $cpfcnpj)->first()->id;

        $response = $this->putJson($this->postLink . '/' . $id, $data);

        unset($data['email_verified_at']);

        $response->assertJson([
            'data' => $data,
            'message' => __('messages.userUpdateSuccess'),
            'success' => true,
            'statusCode' => 200
        ]);
    }

    public function testUserUpdateError()
    {
        $cpfcnpj = '12345678901';
        $data = factory(User::class)->make([
            'cpf_cnpj' => $cpfcnpj
        ])->toArray();

        $this->postJson($this->postLink, $data);

        $id = User::first()->id;

        $response = $this->putJson($this->postLink . '/' . $id, $data);

        unset($data['email_verified_at']);

        $response->assertJson([
            'errors' => [
                'email' => ['The Email has already been taken.'],
                'cpf_cnpj' => ['The CPF/CNPJ has already been taken.'],
            ]
        ]);
    }

    public function testCreateUsersCpfUniqueError()
    {
        $this->expectException('Illuminate\Database\QueryException');
        $this->expectExceptionMessage(
            "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '12345678901' for key 'users_cpf_cnpj_unique"
        );

        User::insert(
            factory(User::class)->make([
                'cpf_cnpj' => '12345678901'
            ])->toArray()
        );

        User::insert(
            factory(User::class)->make([
                'cpf_cnpj' => '12345678901'
            ])->toArray()
        );
    }

    public function testCreateUsersCnpjUniqueError()
    {
        $this->expectException('Illuminate\Database\QueryException');
        $this->expectExceptionMessage(
            "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '12345678901234' for key 'users_cpf_cnpj_unique"
        );

        User::insert(
            factory(User::class)->make([
                'cpf_cnpj' => '12345678901234'
            ])->toArray()
        );

        User::insert(
            factory(User::class)->make([
                'cpf_cnpj' => '12345678901234'
            ])->toArray()
        );
    }

    public function testCreateUsersEmailUniqueError()
    {
        $this->expectException('Illuminate\Database\QueryException');
        $this->expectExceptionMessage(
            "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'test@test.com' for key 'users_email_unique"
        );

        User::insert(
            factory(User::class)->make([
                'email' => 'test@test.com'
            ])->toArray()
        );

        User::insert(
            factory(User::class)->make([
                'email' => 'test@test.com'
            ])->toArray()
        );
    }
}
