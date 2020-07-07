<?php

namespace App\Repositories;

use App\Person;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class PersonRepository extends EloquentRepository implements EloquentRepositoryInterface {
    const PERSON_NAME = 'person';

    function __construct(Person $model)
    {
        $this->model = $model;
    }

    public function payerIsPerson(Person $payer): bool {
        return self::PERSON_NAME === $payer->personType()->first()->name;
    }
}
