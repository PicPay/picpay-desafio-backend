<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Validator;

use App\Infrastructure\Validator\TransactionValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class TransactionValidatorTest extends TestCase
{
    public function testHandleValidation(): void
    {
        $validator = new TransactionValidator($this->getRequest());

        self::assertFalse($validator->hasErrors());
        self::assertCount(0, $validator->getErrors());
    }

    public function testHandleValidationGetErrors(): void
    {
        $validator = new TransactionValidator($this->getRequestInvalid());

        self::assertTrue($validator->hasErrors());
        self::assertCount(3, $validator->getErrors());
    }

    private function getRequest(): Request
    {
        $request = Request::create('', 'POST');
        $request
            ->request
            ->replace([
                'payerUuid' => '89b4e999-ebda-45f8-91e6-3500b7993772',
                'payeeUuid' => 'a01e3d27-0279-4968-9a84-641c82522ac6',
                'amount' => 1250,
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
                'payerUuid' => 'other',
                'payeeUuid' => 'other',
                'amount' => 0,
            ])
        ;

        return $request;
    }
}
