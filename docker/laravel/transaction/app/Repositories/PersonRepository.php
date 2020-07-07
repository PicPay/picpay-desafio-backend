<?php

namespace App\Repositories;

use App\Person;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class PersonRepository extends EloquentRepository implements EloquentRepositoryInterface {
    function __construct(Person $model)
    {
        $this->model = $model;
    }
}
