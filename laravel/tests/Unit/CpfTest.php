<?php

namespace Tests\Unit;

use App\DocumentModels\Cpf;
use Tests\TestCase;

class CpfTest extends TestCase
{
    public function testValid(): void
    {
        $validCpf = "589.677.850-38";
        $cpf = new Cpf($validCpf);
        $this->assertTrue($cpf->isValid(), "CPF inválido.");
        $this->assertIsString($cpf->getValue(), "O CPF não é uma String");
        $this->assertTrue(
            preg_replace("/[^0-9]/", "", $cpf->getValue()) === $cpf->getValue(),
            "O CPF não está sendo desmascarado"
        );
        $this->assertTrue(
            boolval(preg_match("/^(\d{3}).(\d{3}).(\d{3})-(\d{2})$/", $cpf->getMaskedValue())),
            "A classe não conseguiu mascarar o valor."
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
        $this->assertFalse($cpf->isValid(), "CPF válido quando não deveria ser.");
        $this->assertNull($cpf->getValue(), "O CPF não está nulo quando deveria estar.");
    }
}
