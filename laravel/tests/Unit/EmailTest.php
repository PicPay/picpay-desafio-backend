<?php

namespace Tests\Unit;

use App\DocumentModels\Email;
use Tests\TestCase;

class EmailTest extends TestCase
{
    public function testValid(): void
    {
        $email = new Email("valid@google.com");
        $this->assertIsString($email->getValue(), "O e-mail não e uma String");
        $this->assertTrue($email->isValid(), "E-mail inválido.");
    }

    public function testInvalid(): void
    {
        $email = new Email("invalidEmail");
        $this->assertIsString($email->getValue(), "O e-mail não e uma String");
        $this->assertFalse($email->isValid(), "O e-mail é válido quando não deveria ser.");
    }
}
