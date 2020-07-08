<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Validator;

use App\Infrastructure\Validator\UserAccountRegisterValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UserAccountRegisterValidatorTest extends TestCase
{
    public function testHandleValidation(): void
    {
        $validator = new UserAccountRegisterValidator($this->getRequest());

        self::assertFalse($validator->hasErrors());
        self::assertCount(0, $validator->getErrors());
    }

    public function testHandleValidationGetErrors(): void
    {
        $validator = new UserAccountRegisterValidator($this->getRequestInvalid());

        self::assertTrue($validator->hasErrors());
        self::assertCount(5, $validator->getErrors());
    }

    private function getRequest(): Request
    {
        $request = Request::create('', 'POST');
        $request
            ->request
            ->replace([
                'firstName' => 'John',
                'lastName' => 'Doe',
                'document' => '00412651068',
                'email' => 'john@doe.com',
                'password' => '123456',
            ])
        ;

        return $request;
    }

    private function getRequestInvalid(): Request
    {
        $request = Request::create('', 'POST');
        $request
            ->request
            ->replace([
                'firstName' => 'o',
                'lastName' => 'o',
                'document' => '000000000000',
                'email' => 'john.doe.com',
            ])
        ;

        return $request;
    }
}
