<?php

namespace App\Concepts;

use App\DocumentModels\Cnpj;
use App\DocumentModels\Cpf;
use App\DocumentModels\Email;
use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonTypeEnum;
use App\Exceptions\InvalidEmailException;
use App\Exceptions\InvalidIdentityException;
use App\Exceptions\InvalidPersonTypeException;
use App\Models\User;
use App\Models\Shopkeeper;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Person extends Authenticatable
{
    use Notifiable;

    protected $table = "persons";

    protected $fillable = [
        "name",
        "email",
        "password",
    ];
    protected $hidden = ["password"];

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

    public function wallet(): ?Wallet
    {
        return Wallet::getPersonWallet($this);
    }

    /**
     * @return HasMany
     */
    public function purchaseTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payer_id');
    }

    /**
     * @return HasMany
     */
    public function saleTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_id');
    }

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->purchaseTransactions->merge($this->saleTransactions);
    }

    /**
     * @return $this|null
     * @throws InvalidPersonTypeException
     */
    private function getRightBuild(): ?self
    {
        if (!$this->type) {
            return null;
        }
        if (get_class($this) !== self::class) {
            return $this;
        }
        switch ($this->type) {
            case PersonTypeEnum::USER:
                $user = new User();
                $user->setRawAttributes($this->getAttributes(), true);
                return $user;
                break;
            case PersonTypeEnum::SHOPKEEPER:
                $shopkeeper = new Shopkeeper();
                $shopkeeper->setRawAttributes($this->getAttributes(), true);
                return $shopkeeper;
                break;
        }
        throw new InvalidPersonTypeException();
    }

    /**
     * @param Model $model
     * @param string $foreignKey
     * @return static|null
     * @throws InvalidPersonTypeException
     */
    public static function getBelongedPerson(Model $model, string $foreignKey = "person_id"): ?self
    {
        $personModel = $model->belongsTo(self::class, $foreignKey);
        if (!$personModel->exists()) {
            return null;
        }
        /** @var self $person */
        $person = $personModel->first();
        return $person->getRightBuild();
    }
}
