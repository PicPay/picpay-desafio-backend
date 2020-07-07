<?php

namespace App\Repositories;

use App\Account;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class AccountRepository extends EloquentRepository implements EloquentRepositoryInterface {
    function __construct(Account $model)
    {
        $this->model = $model;
    }
}
