<?php

namespace Tests\Unit;

use App\DocumentModels\Cpf;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person as FakePersonProvider;
use Tests\TestCase;

class CpfTest extends TestCase
{
    private function getFaker(): Faker
    {
        $faker = new Faker();
        $faker->addProvider(new FakePersonProvider($faker));
        return $faker;
    }

    public function testValid(): void
    {
        $validCpf = $this->getFaker()->cpf;
        $cpf = new Cpf($validCpf);
        $this->assertTrue($cpf->isValid(), "CPF inválido.");
        $this->assertIsString($cpf->getValue(), "O CPF não é uma String");
        $this->assertTrue(
            preg_replace("/[^0-9]/", "", $cpf->getValue()) === $cpf->getValue(),
            "O CPF não está sendo desmascarado"
        );
        $this->assertTrue(
            boolval(preg_match("/^(\d{3}).(\d{3}).(\d{3})-(\d{2})$/", $cpf->getMaskedValue())),
            "A classe não conseguiu mascarar o valor"
        );
        $this->assertTrue(
            $cpf->getMaskedValue() === $validCpf,
            "O CPF mascarado ficou diferente do cpf original"
        );
    }

    public function testInvalid(): void
    {
        $invalidCpf = "111.111.111-11";
        $cpf = new Cpf($invalidCpf);
        $this->assertFalse($cpf->isValid(), "CPF válido quando não deveria ser");
        $this->assertNull($cpf->getValue(), "O CPF não está nulo quando deveria estar");
    }
}
