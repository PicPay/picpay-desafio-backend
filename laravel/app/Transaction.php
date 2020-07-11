<?php

namespace App;

use App\Concepts\Person;
use App\Exceptions\InvalidPersonTypeException;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";

    protected $fillable = [
        "value",
        "payer_id",
        "payee_id",
    ];

    /**
     * @return Person|null
     * @throws InvalidPersonTypeException
     */
    public function payer(): ?Person
    {
        return Person::getBelongedPerson($this, "payer_id");
    }

    /**
     * @return Person|null
     * @throws InvalidPersonTypeException
     */
    public function payee(): ?Person
    {
        return Person::getBelongedPerson($this, "payee_id");
    }
}
