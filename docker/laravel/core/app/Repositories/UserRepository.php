<?php

namespace App\Repositories;

use App\User;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class UserRepository extends EloquentRepository implements EloquentRepositoryInterface {
    function __construct(User $model)
    {
        $this->model = $model;
    }
}
