<?php

namespace App\Repositories;

use App\DocumentType;
use App\Repositories\Contracts\EloquentRepositoryInterface;

class DocumentTypeRepository extends EloquentRepository implements EloquentRepositoryInterface {
    function __construct(DocumentType $model)
    {
        $this->model = $model;
    }
}
