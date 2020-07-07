<?php

namespace App\Repositories;

use App\PersonType;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class PersonTypeRepository extends EloquentRepository implements EloquentRepositoryInterface {
    function __construct(PersonType $model)
    {
        $this->model = $model;
    }
}
