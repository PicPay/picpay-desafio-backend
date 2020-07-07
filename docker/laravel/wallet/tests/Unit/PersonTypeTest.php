<?php

namespace Tests\Unit;

// use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\PersonType;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PersonTypeTest extends TestCase
{
    // limpa a tabela
    // use RefreshDatabase;
    // use DatabaseMigrations;

    const RECORD_NOT_FOUND = 'Registro não encontrado.';
    const COUNDT_SAVE_RECORD = 'Não foi possível salvar o registro.';
    const COUNDT_DELETE_RECORD = 'Não foi possível excluir o registro.';
    const OK = 'ok';

    public function testIndex()
    {
        // $personType = factory(PersonType::class)->make();

        $response = $this->getJson('/api/personType');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->getJson('/api/personType/1');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $params = [
            'name' => 'MEI',
            'description' => 'Micro Empreendedor Individual'
        ];

        $response = $this->postJson('/api/personType', $params);

        $response
        ->assertStatus(201)
        ->assertJson([
            'name' => 'MEI',
            'description' => 'Micro Empreendedor Individual'
        ]);
    }

    public function testUpdate()
    {
        $params = [
            'description' => 'Micro Empreendedor Individual Updated'
        ];

        $response = $this->putJson('/api/personType/3', $params);

        $response
        ->assertStatus(200)
        ->assertJson([
            'name' => 'MEI',
            'description' => 'Micro Empreendedor Individual Updated'
        ]);
    }

    public function testDelete()
    {
        $response = $this->deleteJson('/api/personType/8');
        $response
        ->assertStatus(200)
        ->assertJson([
            'message' => self::OK
        ]);
    }
}
