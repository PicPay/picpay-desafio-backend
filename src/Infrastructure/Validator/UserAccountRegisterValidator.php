<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

use App\Domain\Shared\ValueObject\Document;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use function sprintf;

class UserAccountRegisterValidator extends AbstractValidator
{
    protected function handleValidation(): void
    {
        if (!Name::isValid($this->getValue('firstName'))) {
            $this->addError('firstName', 'param should be a valid name');
        }

        if (!Name::isValid($this->getValue('lastName'))) {
            $this->addError('lastName', 'param should be a valid name');
        }

        $document = $this->getValue('document');
        if (!Document::isValidCpf($document) && !Document::isValidCnpj($document)) {
            $this->addError(
                'document',
                sprintf(
                    'param should be "%s" or "%s"',
                    Document::TYPE_CPF,
                    Document::TYPE_CNPJ
                )
            );
        }

        $email = $this->getValue('email');
        if (!Email::isValid($email)) {
            $this->addError('email', 'param should be a valid email');
        }

        if (!$this->hasValue('password')) {
            $this->addErrorParamRequired('password');
        }
    }
}
