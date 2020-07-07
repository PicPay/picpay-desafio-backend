<?php

namespace App\Repositories;

use App\Transfer;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class TransferRepository extends EloquentRepository implements EloquentRepositoryInterface {
    function __construct(Transfer $model)
    {
        $this->model = $model;
    }
}
