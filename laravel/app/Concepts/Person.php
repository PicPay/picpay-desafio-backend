<?php

namespace App\Concepts;

use App\Documents\Cnpj;
use App\Documents\Cpf;
use App\Documents\Email;
use App\Exceptions\InvalidEmailException;
use App\Exceptions\InvalidIdentityException;
use Illuminate\Support\Facades\Hash;

abstract class Person
{
    /** @var string $name */
    protected $name;
    /** @var MaskedDocument $identity */
    protected $identity;
    /** @var Email $email */
    protected $email;
    /** @var string $password */
    protected $password;

    /**
     * @param string $password
     * @return bool
     */
    public function isCurrentPassword(string $password): bool
    {
        return $this->password && Hash::check($password, $this->password);
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return MaskedDocument|null
     */
    public function getIdentity(): ?MaskedDocument
    {
        return $this->identity;
    }

    /**
     * @return Email|null
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $cpf
     * @throws InvalidIdentityException
     */
    public function setCpf(string $cpf): void
    {
        $identity = new Cpf($cpf);
        if (!$identity->isValid()) {
            throw new InvalidIdentityException("'$cpf' não é um CPF válido.");
        }
        $this->identity = $identity;
    }

    /**
     * @param string $cnpj
     * @throws InvalidIdentityException
     */
    public function setCnpj(string $cnpj): void
    {
        $identity = new Cnpj($cnpj);
        if (!$identity->isValid()) {
            throw new InvalidIdentityException("'$cnpj' não é um CNPJ válido.");
        }
        $this->identity = $identity;
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
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = Hash::make($password);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "identity" => $this->identity->getMaskedValue(),
            "email" => $this->email->getValue(),
            "password" => $this->password,
        ];
    }

    /**
     * @param array $personArray
     * @return Person
     */
    public static function instanceFromArray(array $personArray): self
    {
        $person = new static();
        $person->setName($personArray["name"]);
    }
}
