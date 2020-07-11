<?php

namespace App\Concepts;

use App\DocumentModels\Cnpj;
use App\DocumentModels\Cpf;
use App\DocumentModels\Email;
use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;
use App\Exceptions\InvalidEmailException;
use App\Exceptions\InvalidIdentityException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

abstract class Person extends Authenticatable
{
    use Notifiable;

    protected $table = "persons";

    protected $attributes = [
        "identity_type" => PersonIdentityTypeEnum::CPF,
        "status" => PersonStatusEnum::ACTIVE,
        "type" => PersonTypeEnum::USER,
    ];

    protected $fillable = [
        "name",
        "email",
        "password",
    ];
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * @param string $password
     * @return bool
     */
    public function isCurrentPassword(string $password): bool
    {
        return $this->password && Hash::check($password, $this->password);
    }

    /**
     * @param MaskedDocument $identity
     * @param string $errorMessage
     * @throws InvalidIdentityException
     */
    private function setIdentity(MaskedDocument $identity, string $errorMessage): void
    {
        if (!$identity->isValid()) {
            throw new InvalidIdentityException($errorMessage);
        }
        $this->identity = $identity->getUnmaskedValue();
    }

    /**
     * @param PersonIdentityTypeEnum $identityType
     */
    private function setIdentityType(PersonIdentityTypeEnum $identityType): void
    {
        $this->identity_type = $identityType->getValue();
    }

    /**
     * @param string $cpf
     * @throws InvalidIdentityException
     */
    public function setCpf(string $cpf): void
    {
        $this->setIdentity(new Cpf($cpf), "'$cpf' não é um CPF válido.");
        $this->setIdentityType(PersonIdentityTypeEnum::CPF());
    }

    /**
     * @param string $cnpj
     * @throws InvalidIdentityException
     */
    public function setCnpj(string $cnpj): void
    {
        $this->setIdentity(new Cnpj($cnpj), "'$cnpj' não é um CNPJ válido.");
        $this->setIdentityType(PersonIdentityTypeEnum::CNPJ());
    }

    /**
     * @param string $emailString
     * @throws InvalidEmailException
     */
    public function setEmail(string $emailString): void
    {
        $email = new Email($emailString);
        if (!$email->isValid()) {
            throw new InvalidEmailException("'$emailString' não é um e-mail válido.");
        }
        $this->email = $email->getValue();
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = Hash::make($password);
    }
}
